<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SavedProvider;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedProviderController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        return view('provider.saved-providers', compact('categories'));
    }

    public function getJson(Request $request)
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $savedServices = SavedProvider::with(['service.category', 'service.provider.review'])
                ->where('user_id', $userId)
                ->get()
                ->filter(fn($saved) => $saved->service && $saved->service->provider)
                ->map(function ($saved) {
                    $service = $saved->service;
                    $provider = $service->provider;
                    $categoryId = $service->category->id ?? null;

                    return [
                        'id' => $saved->id,
                        'service_id' => $service->id,
                        'name' => $provider->first_name . ' ' . $provider->last_name,
                        'service_name' => $service->service_name,
                        'image' => $service->service_image ? asset('storage/' . $service->service_image) : null,
                        'rating' => number_format($provider->review->avg('rating') ?? 0, 1),
                        'review_count' => $provider->review->count() ?? 0,
                        'verified' => true,
                        'hourly_rate' => $service->service_price,
                        'response_time' => 'Responds within 1 hour',
                        'category_id' => $categoryId,
                        'saved_at' => $saved->created_at->toDateTimeString(),
                    ];
                })
                ->values();

            return response()->json($savedServices);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }



    public function toggle(Request $request)
    {
        $serviceId = $request->service_id;
        $userId = Auth::id();

        $existing = SavedProvider::where('user_id', $userId)
            ->where('service_id', $serviceId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'status' => 'removed',
                'message' => 'Provider removed from saved list.'
            ]);
        } else {
            SavedProvider::create([
                'user_id' => $userId,
                'service_id' => $serviceId,
            ]);
            return response()->json([
                'success' => true,
                'status' => 'saved',
                'message' => 'Provider saved successfully.'
            ]);
        }
    }
}
