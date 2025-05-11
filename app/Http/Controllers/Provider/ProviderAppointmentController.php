<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('provider')->get();
        return view('provider.view-all-providers', compact('services'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        // Validate the incoming request
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'nullable|string',
            'qualifications_certifications' => 'string|max:255',
            'service_category' => 'required|string',
            'service_duration' => 'required|integer|min:1|max:24',
            'service_price' => 'required|numeric|min:0',
            'service_location' => 'required|string',
            'service_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'work_gallery' => 'nullable|array', // Allow array for multiple files
            'work_gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:10240', // Each file should be an image
            'service_offered' => ['array'],
            'service_offered.*' => ['required', 'string', 'max:255'],
            'service_offered_description' => ['array'],
            'service_offered_description.*' => ['required', 'string', ],
            'service_offered_price' => ['array'],
            'service_offered_price.*' => ['required', 'numeric', 'min:0'],
            'additional_services' => ['nullable', 'string', 'max:255'],
        ]);

        // Add provider_id and service_status to the validated data
        $validated['provider_id'] = Auth::id();
        $validated['service_status'] = $request->has('service_status');

        // Handle the main service image upload
        if ($request->hasFile('service_image')) {
            $validated['service_image'] = $request->file('service_image')->store('services', 'public');
        }

        // Handle work gallery (multiple images)
        if ($request->hasFile('work_gallery')) {
            $galleryPaths = [];
            foreach ($request->file('work_gallery') as $image) {
                // Store each image and add the path to the array
                $galleryPaths[] = $image->store('services/gallery', 'public');
            }
            // Store the gallery paths as a JSON-encoded string
            $validated['work_gallery'] = json_encode($galleryPaths);
        }

        // Handle service offerings (Service_Offered, Service_Offered_description, Service_Offered_price)
        $offerings = [];
        if ($request->has('service_offered')) {
            foreach ($request->input('service_offered') as $index => $offeredService) {
                $offerings[] = [
                    'service_name' => $offeredService,
                    'description' => $request->input('service_offered_description')[$index] ?? '',
                    'price' => $request->input('service_offered_price')[$index] ?? 0,
                ];
            }
        }
        $validated['service_offerings'] = json_encode($offerings); // Store offerings as JSON

        // Handle additional services
        $validated['additional_services'] = $request->input('additional_services') ?? null;

        try {
            // Create a new service entry in the database
            Service::create($validated);

            // Redirect or return a response
            return redirect()->back()->with('success', 'Service created successfully!');
        } catch (\Exception $e) {
            // Handle error if something goes wrong
            return back()->withErrors(['error' => 'There was an error creating the service: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    // Example: ProviderController.php
    public function show($id)
    {
        $service = Service::with(['provider', 'reviews.user'])->findOrFail($id);

        $averageRating = number_format($service->reviews->avg('rating'), 1); // e.g., 4.8
        $totalReviews = $service->reviews->count(); // e.g., 128

        return view('provider.provider-detail', compact('service', 'averageRating', 'totalReviews'));
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
