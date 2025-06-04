<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AvailabilityService;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $providerId = $request->input('provider_id');
        $location = $request->input('location');

        $availabilityService = new AvailabilityService();

        // All services with availability status
        $services = Service::with('provider')->get()->map(function ($service) use ($availabilityService) {
            $service->availability_status = $availabilityService->getTodayStatus($service->id);
            return $service;
        });

        // Filtered & recommended services with availability status
        $recommendedServices = Service::with(['provider', 'reviews'])
            ->when($providerId, fn($query) => $query->where('provider_id', $providerId))
            ->when($location, fn($query) => $query->where('service_location', 'like', '%' . $location . '%'))
            ->limit(4)
            ->get()
            ->map(function ($service) use ($availabilityService) {
                $service->availability_status = $availabilityService->getTodayStatus($service->id);
                return $service;
            });

        // Count for "View All Providers"
        $allProvidersCount = Service::when($providerId, fn($query) => $query->where('provider_id', $providerId))
            ->when($location, fn($query) => $query->where('service_location', 'like', '%' . $location . '%'))
            ->count();

        // All providers with their services and availability status
        $allProviders = User::where('account_type', 'provider')
            ->with(['services' => function ($query) {
                $query->select('id', 'provider_id', 'service_location', 'service_name');
            }])
            ->get()
            ->map(function ($provider) use ($availabilityService) {
                $provider->services->map(function ($service) use ($availabilityService) {
                    $service->availability_status = $availabilityService->getTodayStatus($service->id);
                    return $service;
                });
                return $provider;
            });

        // Top 5 reviews with 5-star rating
        $topReviews = \App\Models\Review::where('rating', 5)
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('home.Home', compact(
            'recommendedServices',
            'services',
            'allProviders',
            'allProvidersCount',
            'topReviews'
        ));
    }
}
