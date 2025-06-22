<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\DayOff;
use App\Models\Review;
use App\Models\SavedProvider;
use App\Models\Service;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\AvailabilityService;
use Illuminate\Support\Facades\Storage;

class ProviderAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Paginate with provider, reviews, and time slots
        $services = Service::with(['provider', 'reviews', 'timeSlots'])->paginate(15);

        // Mutate each service: add availability status + average rating
        $services->getCollection()->transform(function ($service) {
            // Availability status: check if any slot is not booked
            $hasAvailableSlot = $service->timeSlots->contains(function ($slot) {
                return $slot->is_booked == 0;
            });

            $service->availability_status = $hasAvailableSlot ? 'Available' : 'Fully Booked';
            $service->average_rating = round($service->reviews->avg('rating'), 1);

            return $service;
        });

        // Categories and providers
        $categories = Category::all();
        $providers = User::where('account_type', 'provider')->count();

        // For AJAX JSON
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'services' => $services,
                'categories' => $categories,
                'provider_count' => $providers,
            ]);
        }

        return view('provider.view-all-providers', compact('services', 'categories', 'providers'));
    }









    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all(); // Make sure this is defined
        return view('services.add-new-service', compact('categories'));
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
            'category_id' => 'required|exists:categories,id',
            'service_duration' => 'required|integer|min:1|max:24',
            'service_price' => 'required|numeric|min:0',
            'service_fee' => 'required|numeric|min:0', 
            'tax' => 'required|numeric|min:0', 
            'service_location' => 'required|string',
            'service_image' => 'nullable|image|mimes:jpg,jpeg,avif,png|max:10240',
            'work_gallery' => 'nullable|array',
            'work_gallery.*' => 'nullable|image|mimes:jpg,jpeg,avif,png|max:10240',
            'Service_Offered' => ['array'],
            'Service_Offered.*' => ['required', 'string', 'max:255'],
            'Service_Offered_description' => ['array'],
            'Service_Offered_description.*' => ['required', 'string'],
            'Service_Offered_price' => ['array'],
            'Service_Offered_price.*' => ['required', 'numeric', 'min:0'],
            'additional_services' => ['nullable', 'array'],
            'additional_services.*.name' => ['required', 'string', 'max:255'],
            'additional_services.*.price' => ['required', 'numeric', 'min:0'],
            'questions' => ['array'],
            'questions.*' => ['required', 'string'],
            'answers' => ['array'],
            'answers.*' => ['required', 'string'],
        ]);

        // Add provider_id and service_status
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
                $galleryPaths[] = $image->store('services/gallery', 'public');
            }
            $validated['work_gallery'] = json_encode($galleryPaths);
        }

        // Handle service offerings
        $offerings = [];
        if ($request->has('Service_Offered')) {
            foreach ($request->input('Service_Offered') as $index => $offeredService) {
                $offerings[] = [
                    'service_id' => uniqid('svc_', true),
                    'service_name' => $offeredService,
                    'description' => $request->input('Service_Offered_description')[$index] ?? '',
                    'price' => $request->input('Service_Offered_price')[$index] ?? 0,
                ];
            }
        }
    
        $validated['service_offerings'] = json_encode($offerings);

        // Handle FAQs
        $faqs = [];
        if ($request->has('questions')) {
            foreach ($request->input('questions') as $index => $question) {
                $faqs[] = [
                    'questions' => $question,
                    'answers' => $request->input('answers')[$index] ?? '',
                ];
            }
        }
        $validated['faqs'] = $faqs;

        // Handle additional services
        $validated['additional_services'] = $request->has('additional_services')
            ? json_encode($request->input('additional_services'))
            : null;

        try {
            Service::create($validated);
            
            return redirect()->back()->with('success', 'Service created successfully!');
        } catch (\Exception $e) {
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

        // Add availability status
        $service->availability_status = (new AvailabilityService)->getTodayStatus($service->id);

        $averageRating = number_format($service->reviews->avg('rating'), 1);
        $totalReviews = $service->reviews->count();

        $providerId = $service->provider->id;

        // Get all providers excluding the current one
        $allProviders = User::where('account_type', 'provider')->inRandomOrder()->limit(3)->get();
        $isSavedByUser = false;
        if (Auth::check()) {
            $isSavedByUser = SavedProvider::where('user_id', Auth::id())
                ->where('service_id', $service->id)
                ->exists();
        }
        // Pick 3 random providers from the full collection
        $suggestedProviders = $allProviders->random(min(3, $allProviders->count()));

        return view('provider.provider-detail', compact(
            'service',
            'averageRating',
            'totalReviews',
            'suggestedProviders',
            'isSavedByUser'
        ));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::findOrFail($id);

        // Decode work_gallery and other JSON fields if stored as string
        $service->work_gallery = json_decode($service->work_gallery, true) ?? [];

        $service->service_offerings = json_decode($service->service_offerings, true) ?? [];
        $service->additional_services = json_decode($service->additional_services, true) ?? [];
        $service->faqs = is_array($service->faqs) ? $service->faqs : [];

        return response()->json([
            'service' => $service
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'service_description' => 'nullable|string',
            'qualifications_certifications' => 'string|max:255',
            'category_id' => 'required|exists:categories,id',
            'service_duration' => 'required|integer|min:1|max:24',
            'service_price' => 'required|numeric|min:0',
            'service_fee' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'service_location' => 'required|string',
            'service_image' => 'nullable|image|mimes:jpg,jpeg,avif,png|max:10240',
            'work_gallery' => 'nullable|array',
            'work_gallery.*' => 'nullable|image|mimes:jpg,jpeg,avif,png|max:10240',
            'Service_Offered' => ['array'],
            'Service_Offered.*' => ['required', 'string', 'max:255'],
            'Service_Offered_description' => ['array'],
            'Service_Offered_description.*' => ['required', 'string'],
            'Service_Offered_price' => ['array'],
            'Service_Offered_price.*' => ['required', 'numeric', 'min:0'],
            'additional_services' => ['nullable', 'array'],
            'additional_services.*.name' => ['required', 'string', 'max:255'],
            'additional_services.*.price' => ['required', 'numeric', 'min:0'],
            'questions' => ['array'],
            'questions.*' => ['required', 'string'],
            'answers' => ['array'],
            'answers.*' => ['required', 'string'],
        ]);

        // Update provider_id and service_status
        $validated['provider_id'] = Auth::id();
        $validated['service_status'] = $request->has('service_status');

        // Handle main service image
        if ($request->hasFile('service_image')) {
            // Optional: delete old image first
            if ($service->service_image) {
                Storage::disk('public')->delete($service->service_image);
            }
            $validated['service_image'] = $request->file('service_image')->store('services', 'public');
        }

        // Handle work gallery
        if ($request->hasFile('work_gallery')) {
            $galleryPaths = [];
            foreach ($request->file('work_gallery') as $image) {
                $galleryPaths[] = $image->store('services/gallery', 'public');
            }
            $validated['work_gallery'] = json_encode($galleryPaths);
        }

        // Handle service offerings
        $offerings = [];
        if ($request->has('Service_Offered')) {
            foreach ($request->input('Service_Offered') as $index => $offeredService) {
                $offerings[] = [
                    'service_id' => uniqid('svc_', true),
                    'service_name' => $offeredService,
                    'description' => $request->input('Service_Offered_description')[$index] ?? '',
                    'price' => $request->input('Service_Offered_price')[$index] ?? 0,
                ];
            }
        }
        $validated['service_offerings'] = json_encode($offerings);

        // Handle FAQs
        $faqs = [];
        if ($request->has('questions')) {
            foreach ($request->input('questions') as $index => $question) {
                $faqs[] = [
                    'questions' => $question,
                    'answers' => $request->input('answers')[$index] ?? '',
                ];
            }
        }
        $validated['faqs'] = $faqs;

        // Handle additional services
        $validated['additional_services'] = $request->has('additional_services')
            ? json_encode($request->input('additional_services'))
            : null;

        try {
            $service->update($validated);

            if ($request->expectsJson()) {
                return response()->json(['success' => true]);
            }

            return redirect()->back()->with('success', 'Service updated successfully!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'There was an error updating the service: ' . $e->getMessage()
                ], 500);
            }

            return back()->withErrors(['error' => 'There was an error updating the service: ' . $e->getMessage()]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
   
}
