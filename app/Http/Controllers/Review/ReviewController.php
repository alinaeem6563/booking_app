<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all reviews for services owned by the current provider
        $providerServices = Service::where('provider_id', Auth::id())->pluck('id');

        $reviews = Review::whereIn('service_id', $providerServices)
            ->with(['service', 'user'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($review) {
                return [
                    'id' => $review->id,
                    'service_id' => $review->service_id,
                    'service_name' => $review->service->service_name,
                    'customer_name' => $review->user->first_name . ' ' . $review->user->last_name,
                    'rating' => $review->rating,
                    'review_text' => $review->review_text,
                    'service_details' => $review->service_details,
                    'status' => $review->status,
                    'created_at' => $review->created_at->toISOString(),
                ];
            });

        return view('reviews.all-reviews', compact('reviews'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reviews = Review::with('user')->get();
        $services = Service::all();
        return view('provider.provider-detail', compact('reviews', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id'      => 'required|exists:services,id',
            'rating'          => 'required|numeric|min:1|max:5',
            'review_text'     => 'required|string',
            'service_details' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        Review::create($validated);

        return back()->with('success', 'Review submitted successfully. Pending Approval From Admin');
    }

    public function approve(Request $request, Review $review)
    {
        // Check if the review belongs to a service owned by the current provider
        if ($review->service->provider_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        try {
            $review->update(['status' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Review approved successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error approving review. Please try again.'
            ], 500);
        }
    }

    /**
     * Delete multiple reviews
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id',
        ]);

        try {
            // Get provider's service IDs
            $providerServices = Service::where('provider_id', Auth::id())->pluck('id');

            // Only delete reviews that belong to the provider's services
            $deletedCount = Review::whereIn('id', $validated['review_ids'])
                ->whereIn('service_id', $providerServices)
                ->delete();

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} reviews."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting reviews. Please try again.'
            ], 500);
        }
    }

    /**
     * Export reviews to CSV
     */
    public function export()
    {
        $providerServices = Service::where('provider_id', Auth::id())->pluck('id');

        $reviews = Review::whereIn('service_id', $providerServices)
            ->with(['service', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'reviews_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($reviews) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'Review ID',
                'Service Name',
                'Customer Name',
                'Rating',
                'Review Text',
                'Service Details',
                'Status',
                'Created At'
            ]);

            // CSV data
            foreach ($reviews as $review) {
                fputcsv($file, [
                    $review->id,
                    $review->service->service_name,
                    $review->user->first_name . ' ' . $review->user->last_name,
                    $review->rating,
                    $review->review_text,
                    $review->service_details,
                    $review->status ? 'Approved' : 'Pending',
                    $review->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
