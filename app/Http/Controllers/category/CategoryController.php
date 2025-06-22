<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.view-all-category-admin', compact('categories'));
    }

    public function UserCategory()
    {
        $categories = Category::with(['services.reviews'])->get();

        $categories = $categories->map(function ($category) {
            $services = $category->services;
            $serviceCount = $services->count();

            $allReviews = $services->flatMap->reviews;

            $avgRating = $allReviews->count() > 0
                ? round($allReviews->avg('rating'), 1)
                : 0.0;
            return [
                'id' => $category->id,
                'category_icon_link' => $category->category_icon_link,
                'category_name' => $category->category_name,
                'category_description' => $category->category_description,
                'services_count' => $serviceCount,
                'avg_rating' => $avgRating,
                'created_at' => $category->created_at->toDateTimeString(),
            ];
        });

        return view('category.user-category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.add-category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'category_slug' => ['required', 'string', 'max:255'],
            'category_description' => ['required'],
            'category_icon_link' => ['nullable', 'string'],
            'category_status' => ['required', 'in:active,inactive'],
        ]);
        Category::create($validated);
        return redirect()->back()->with('success', 'Category Created Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Get services in this category with provider and reviews
        $categoryServices = $category->services()
            ->with(['provider', 'reviews'])
            ->when(Auth::user()->account_type !== 'admin', function ($query) {
                $query->where('service_status', 'active');
            })
            ->get()
            ->map(function ($service) {
                $service->avg_rating = $service->reviews->avg('rating') ?? 0;
                $service->review_count = $service->reviews->count();
                $service->provider_name = $service->provider->first_name . ' ' . $service->provider->last_name;
                return $service;
            });

        $serviceIdsInCategory = $categoryServices->pluck('id');

        // Related categories (excluding current)
        $relatedCategories = Category::where('category_status', 'active')
            ->where('id', '!=', $category->id)
            ->withCount(['services' => function ($query) {
                $query->where('service_status', 'active');
            }])
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // Active providers
        $activeProviderIds = User::where('account_type', 'provider')
            ->where('status', 'active')
            ->pluck('id');

        $activeProviders = $activeProviderIds->count();

        // Get services by active providers
        $providerServices = Service::whereIn('provider_id', $activeProviderIds)
            ->with(['bookings']) // Assuming 'bookings' is a relationship
            ->get();

        // Calculate average rating for services in current category
        $averageRating = Review::whereIn('service_id', $serviceIdsInCategory)->avg('rating') ?? 0;

        // Price range for services of active providers
        $activePrices = $providerServices->pluck('service_price')->filter();
        $priceRange = [
            'min' => $activePrices->min(),
            'max' => $activePrices->max()
        ];

        // Admin-only stats
        $additionalStats = [];
        if (Auth::user()->account_type === 'admin') {
            $additionalStats = [
                'total_bookings' => $providerServices->sum(fn($service) => $service->bookings->count()),
                'total_revenue' => $providerServices->sum(
                    fn($service) => $service->bookings->where('status', 'completed')->sum('total_amount')
                ),
                'inactive_services' => $providerServices->where('service_status', 'inactive')->count(),
            ];
        }

        return view('category.single-category', compact(
            'category',
            'categoryServices',
            'relatedCategories',
            'activeProviders',
            'averageRating',
            'priceRange',
            'additionalStats'
        ));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit-category', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'category_slug' => ['required', 'string', 'max:255'],
            'category_description' => ['required'],
            'category_icon_link' => ['nullable', 'string'],
            'category_status' => ['required', 'in:active,inactive'],
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return redirect()->back()->with('success', 'Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
