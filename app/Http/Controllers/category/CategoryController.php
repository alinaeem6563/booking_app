<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
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
        $categories = Category::all();
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
        // Get services in this category with their providers and ratings
        $services = $category->services()
            ->with(['provider', 'reviews'])
            ->when(Auth::user()->account_type !== 'admin', function ($query) {
                // Non-admin users only see active services
                $query->where('service_status', 'active');
            })
            ->get()
            ->map(function ($service) {
                $service->avg_rating = $service->reviews->avg('rating') ?? 0;
                $service->review_count = $service->reviews->count();
                $service->provider_name = $service->provider->first_name . ' ' . $service->provider->last_name;
                return $service;
            });

        // Get related categories (exclude current category)
        $relatedCategories = Category::where('category_status', 'active')
            ->where('id', '!=', $category->id)
            ->withCount(['services' => function ($query) {
                $query->where('service_status', 'active');
            }])
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // Calculate statistics
        $activeProviders = $services->where('service_status', 'active')
            ->pluck('provider_id')
            ->unique()
            ->count();

        $averageRating = $services->where('service_status', 'active')
            ->avg('avg_rating') ?? 0;

        $activePrices = $services->where('service_status', 'active')
            ->pluck('service_price')
            ->filter();

        $priceRange = [
            'min' => $activePrices->min(),
            'max' => $activePrices->max()
        ];

        // Additional stats for admin
        $additionalStats = [];
        if (Auth::user()->account_type === 'admin') {
            $additionalStats = [
                'total_bookings' => $services->sum(fn($service) => $service->bookings()->count()),
                'total_revenue' => $services->sum(
                    fn($service) =>
                    $service->bookings()->where('status', 'completed')->sum('total_amount')
                ),
                'inactive_services' => $services->where('service_status', '0')->count(),
            ];
        }

        return view('category.single-category', compact(
            'category',
            'services',
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
        $category=Category::findOrFail($id);
        return view('category.edit-category',compact('category'));
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
