<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')
            ->where('provider_id', Auth::id())
            ->latest()
            ->get();

        $categories = Category::where('category_status', 'inactive')->get();
        $processedServices= $services->map(function ($service) {
            return [
                'id' => $service->id,
                'service_name' => $service->service_name,
                'service_description' => $service->service_description,
                'service_price' => $service->service_price,
                'service_status' => $service->service_status,
                'category_id' => $service->category_id,
                'category_name' => $service->category->category_name ?? 'Uncategorized',
                'image_url' => $service->service_image ? asset('storage/' . $service->service_image) : '/placeholder.jpg?height=200&width=300'
            ];
        });
        return view('provider.all-services', ['services'=> $services, 'categories'=> $categories, 'processedServices'=> $processedServices]);
    }
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
    public function toggleStatus(Service $service)
    {
        // Check if the service belongs to the authenticated user
        if ($service->provider_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $service->service_status = !$service->service_status;
        $service->save();

        return response()->json([
            'message' => 'Service status updated successfully!',
            'service_status' => $service->service_status,
            'success' => true
        ]);
    }

    public function destroy(Service $service)
    {
        // Check if the service belongs to the authenticated user
        if ($service->provider_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete image if exists
        if ($service->service_image) {
            Storage::disk('public')->delete($service->service_image);
        }

        $service->delete();

        return response()->json([
            'message' => 'Service deleted successfully!',
            'success' => true
        ]);
    }
}
