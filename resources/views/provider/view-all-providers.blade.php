@extends('layouts.app')
@Section('content')
    <!-- Header -->
    @include('navigation.Header')

    <!-- Modern Gradient Header -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white  border-gray-100">

        <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h1
                    class="text-3xl sm:text-4xl font-bold text-white text-transparent mb-4">
                    All Service Providers
                </h1>
                <p class="text-lg text-white max-w-2xl mx-auto">
                    Find and book the perfect service provider for your needs from our verified professionals
                </p>

            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="providerFilters()">
        <!-- Active Filters Display -->
        <div x-show="hasActiveFilters()" class="mb-6">
            <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-gray-700">Active Filters:</span>

                    <!-- Category Filters -->
                    <template x-for="category in selectedCategories" :key="category">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            <span x-text="category"></span>
                            <button @click="removeCategory(category)" class="ml-1 text-indigo-600 hover:text-indigo-800">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </span>
                    </template>

                    <!-- Price Filter -->
                    <span x-show="selectedPrice"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        <span x-text="'Price: ' + selectedPrice"></span>
                        <button @click="selectedPrice = ''" class="ml-1 text-indigo-600 hover:text-indigo-800">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>

                    <!-- Rating Filter -->
                    <span x-show="selectedRating"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-indigo-800">
                        <span x-text="selectedRating + ' stars & up'"></span>
                        <button @click="selectedRating = ''" class="ml-1 text-indigo-600 hover:text-indigo-800">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>

                    <!-- Location Filter -->
                    <span x-show="selectedLocation"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                        <span x-text="'Location: ' + selectedLocation"></span>
                        <button @click="selectedLocation = ''" class="ml-1 text-purple-600 hover:text-purple-800">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </span>

                    <!-- Clear All Button -->
                    <button @click="clearAllFilters()"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 hover:bg-red-200 transition-colors">
                        Clear All
                        <svg class="ml-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Filters and Search Section -->
        <div class="flex flex-col xl:flex-row gap-8 mb-8">
            <!-- Modern Filter Sidebar -->
            <div class="w-full xl:w-1/4">
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden sticky top-4">
                    <!-- Filter Header -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Smart Filters
                            </h2>
                            <button @click="mobileFiltersOpen = !mobileFiltersOpen"
                                class="text-white/80 hover:text-white xl:hidden">
                                <svg x-show="!mobileFiltersOpen" class="h-5 w-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                                <svg x-show="mobileFiltersOpen" class="h-5 w-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Filter Content -->
                    <div x-show="mobileFiltersOpen" x-transition
                        class="p-6 space-y-8 max-h-96 xl:max-h-none overflow-y-auto">
                        <!-- Service Category -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Service Categories
                            </h3>
                            <div class="space-y-3">
                                @foreach ($categories as $category)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="checkbox" x-model="selectedCategories"
                                            value="{{ $category->category_name }}" @change="applyFilters()"
                                            class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4 border-gray-300 transition-colors">
                                        <span
                                            class="ml-3 text-sm text-gray-700 group-hover:text-indigo-600 transition-colors">
                                            {{ $category->category_name }}
                                        </span>
                                        <span class="ml-auto text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                            {{ $category->services_count ?? 0 }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                Price Range
                            </h3>
                            <div class="space-y-3">
                                @php
                                    $priceRanges = [
                                        '' => 'Any price',
                                        '0-25' => '$0 - $25',
                                        '25-50' => '$25 - $50',
                                        '50-100' => '$50 - $100',
                                        '100+' => '$100+',
                                    ];
                                @endphp
                                @foreach ($priceRanges as $value => $label)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="price" x-model="selectedPrice"
                                            value="{{ $value }}" @change="applyFilters()"
                                            class="text-indigo-600 focus:ring-indigo-500 h-4 w-4 border-gray-300 transition-colors">
                                        <span
                                            class="ml-3 text-sm text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Rating -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                Minimum Rating
                            </h3>
                            <div class="space-y-3">
                                @php
                                    $ratings = [
                                        '' => 'Any rating',
                                        '4' => '4+ stars',
                                        '3' => '3+ stars',
                                        '2' => '2+ stars',
                                    ];
                                @endphp
                                @foreach ($ratings as $value => $label)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="rating" x-model="selectedRating"
                                            value="{{ $value }}" @change="applyFilters()"
                                            class="text-indigo-600 focus:ring-indigo-500 h-4 w-4 border-gray-300 transition-colors">
                                        <span
                                            class="ml-3 flex items-center text-sm text-gray-700 group-hover:text-yellow-600 transition-colors">
                                            @if ($value)
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="h-4 w-4 {{ $i <= $value ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                                <span class="ml-1">& up</span>
                                            @else
                                                {{ $label }}
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Availability -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Availability
                            </h3>
                            <div class="space-y-3">
                                @php
                                    $availabilityOptions = [
                                        'today' => 'Available Today',
                                        'week' => 'Available This Week',
                                        'weekend' => 'Weekend Availability',
                                    ];
                                @endphp
                                @foreach ($availabilityOptions as $value => $label)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="checkbox" x-model="selectedAvailability"
                                            value="{{ $value }}" @change="applyFilters()"
                                            class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4 border-gray-300 transition-colors">
                                        <span
                                            class="ml-3 text-sm text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Location
                            </h3>
                            <div class="space-y-3">
                                <input type="text" x-model="selectedLocation" @input.debounce.500ms="applyFilters()"
                                    placeholder="Enter your location"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white">

                                <div class="space-y-2">
                                    @php
                                        $distanceOptions = [
                                            '5' => 'Within 5 miles',
                                            '10' => 'Within 10 miles',
                                            '20' => 'Within 20 miles',
                                        ];
                                    @endphp
                                    @foreach ($distanceOptions as $value => $label)
                                        <label class="flex items-center group cursor-pointer">
                                            <input type="radio" name="distance" x-model="selectedDistance"
                                                value="{{ $value }}" @change="applyFilters()"
                                                class="text-indigo-600 focus:ring-indigo-500 h-4 w-4 border-gray-300 transition-colors">
                                            <span
                                                class="ml-3 text-sm text-gray-700 group-hover:text-indigo-600 transition-colors">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="border-t border-gray-100 p-6 bg-gray-50/50">
                        <div class="space-y-3">
                            <button @click="applyFilters()"
                                class="w-full bg-indigo-600 text-white py-3 px-4 rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 font-medium">
                                <span class="flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Apply Filters
                                </span>
                            </button>
                            <button @click="clearAllFilters()"
                                class="w-full text-gray-600 py-2 px-4 text-sm hover:text-indigo-600 transition-colors font-medium">
                                Clear All Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Results -->
            <div class="w-full xl:w-3/4">
                <!-- Modern Search Bar -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 mb-8">
                    <div class="flex flex-col lg:flex-row gap-4">
                        <div class="flex-grow">
                            <div class="relative">
                                <input type="text" x-model="searchQuery" @input.debounce.500ms="applyFilters()"
                                    placeholder="Search providers by name, service, or location..."
                                    class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white text-lg">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <label for="sort"
                                    class="block text-sm font-medium text-gray-700 mr-3 whitespace-nowrap">Sort by:</label>
                                <select id="sort" x-model="sortBy" @change="applyFilters()"
                                    class="px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white">
                                    <option value="recommended">Recommended</option>
                                    <option value="rating">Highest Rated</option>
                                    <option value="price_low">Price: Low to High</option>
                                    <option value="price_high">Price: High to Low</option>
                                    <option value="reviews">Most Reviews</option>
                                    <option value="newest">Newest First</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <p class="text-lg font-medium text-gray-900">
                            Showing <span class="text-indigo-600 font-bold" x-text="filteredResults.length"></span>
                            of <span class="font-bold">{{ $services->count() }}</span> providers
                        </p>
                        <p class="text-sm text-gray-600 mt-1" x-show="hasActiveFilters()">
                            Filtered results based on your preferences
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">View:</span>
                        <div class="flex rounded-lg border border-gray-200 overflow-hidden">
                            <button @click="viewMode = 'grid'"
                                :class="viewMode === 'grid' ? 'bg-indigo-600 text-white' :
                                    'bg-white text-gray-600 hover:bg-gray-50'"
                                class="p-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </button>
                            <button @click="viewMode = 'list'"
                                :class="viewMode === 'list' ? 'bg-indigo-600 text-white' :
                                    'bg-white text-gray-600 hover:bg-gray-50'"
                                class="p-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="text-center py-12">
                    <div
                        class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-indigo-600 bg-white transition ease-in-out duration-150">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Loading providers...
                    </div>
                </div>

                <!-- Provider Cards Grid -->
                <div x-show="!loading"
                    :class="viewMode === 'grid' ? 'grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3 gap-6' :
                        'space-y-4'"
                    class="transition-all duration-300">
                    @foreach ($services as $service)
                        <div class="provider-card bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                            :class="viewMode === 'list' ? 'flex' : ''"
                            data-categories="{{ $service->category->category_name ?? '' }}"
                            data-price="{{ $service->service_price }}" data-rating="{{ $service->average_rating ?? 0 }}"
                            data-location="{{ $service->service_location }}"
                            data-availability="{{ $service->availability_status }}">

                            <div :class="viewMode === 'list' ? 'w-48 flex-shrink-0' : ''" class="relative">
                                <img :class="viewMode === 'list' ? 'h-full' : 'h-48'" class="w-full object-cover"
                                    src="{{ asset('storage/' . $service->service_image) }}" alt="Provider profile">
                            
                                <div class="absolute top-0 right-0 m-3">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        @if ($service->availability_status === 'Available') bg-green-100 text-green-800
                                        @elseif($service->availability_status === 'Fully Booked') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        <div
                                            class="w-2 h-2 rounded-full mr-1
                                            @if ($service->availability_status === 'Available') bg-green-500
                                            @elseif($service->availability_status === 'Fully Booked') bg-red-500
                                            @else bg-gray-500 @endif">
                                        </div>
                                        {{ $service->availability_status }}
                                    </span>
                                </div>
                            </div>
                            

                            <div :class="viewMode === 'list' ? 'flex-1' : ''" class="p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div
                                                class="h-12 w-12 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                                {{ strtoupper(substr($service->provider->first_name, 0, 1) . substr($service->provider->last_name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ $service->provider->first_name }} {{ $service->provider->last_name }}
                                            </h3>
                                            <p class="text-sm text-gray-600">{{ $service->service_name }}</p>
                                            <p class="text-xs text-indigo-600 font-medium">
                                                {{ $service->category->category_name ?? 'General' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="flex items-center mb-2">
                                        <div class="flex items-center">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="h-4 w-4 {{ $i <= ($service->average_rating ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">
                                            {{ number_format($service->average_rating ?? 0, 1) }}
                                            ({{ $service->reviews->count() }} reviews)
                                        </span>
                                    </div>

                                    <div class="flex items-center text-sm text-gray-500 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $service->service_location }}
                                    </div>
                                </div>

                                <div class="border-t border-gray-100 pt-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-500">Starting from</p>
                                            <p class="text-xl font-bold text-gray-900">${{ $service->service_price }}<span
                                                    class="text-sm font-normal text-gray-500">/hr</span></p>
                                        </div>
                                        <div class="flex space-x-2">

                                            <a href="{{ route('providers.show', $service->id) }}"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                                </svg>
                                                Book Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- No Results -->
                <div x-show="!loading && filteredResults.length === 0" class="text-center py-12">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No providers found</h3>
                        <p class="text-gray-600 mb-4">Try adjusting your filters or search terms to find more providers.
                        </p>
                        <button @click="clearAllFilters()"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                            Clear All Filters
                        </button>
                    </div>
                </div>

                <!-- Enhanced Pagination -->
                <div x-show="!loading && filteredResults.length > 0" class="mt-12 flex justify-center">
                    {{ $services->links() }}
                </div>
                
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('navigation.Footer')
@endsection
<script>
    function providerFilters() {
        return {
            // Filter state\
            selectedCategories: @json(request('categories', [])),
            selectedPrice: @json(request('price', '')),
            selectedRating: @json(request('rating', '')),
            selectedAvailability: @json(request('availability', [])),
            selectedLocation: @json(request('location', '')),
            selectedDistance: @json(request('distance', '')),
            searchQuery: @json(request('search', '')),
            sortBy: @json(request('sort', 'recommended')),

            // UI state
            mobileFiltersOpen: false,
            viewMode: 'grid',
            loading: false,
            filteredResults: [],

            // Initialize
            init() {
                this.updateFilteredResults();
                this.mobileFiltersOpen = window.innerWidth >= 1280 // xl breakpoint

                // Handle window resize
                window.addEventListener("resize", () => {
                    if (window.innerWidth >= 1280) {
                        this.mobileFiltersOpen = true
                    } else {
                        this.mobileFiltersOpen = false
                    }
                })

                // Initialize from URL parameters
                this.initializeFromURL()
            },

            // Initialize filters from URL parameters
            initializeFromURL() {
                const urlParams = new URLSearchParams(window.location.search)

                // Set filters from URL
                if (urlParams.has("categories")) {
                    this.selectedCategories = urlParams.get("categories").split(",").filter(Boolean)
                }
                if (urlParams.has("price")) {
                    this.selectedPrice = urlParams.get("price")
                }
                if (urlParams.has("rating")) {
                    this.selectedRating = urlParams.get("rating")
                }
                if (urlParams.has("availability")) {
                    this.selectedAvailability = urlParams.get("availability").split(",").filter(Boolean)
                }
                if (urlParams.has("location")) {
                    this.selectedLocation = urlParams.get("location")
                }
                if (urlParams.has("distance")) {
                    this.selectedDistance = urlParams.get("distance")
                }
                if (urlParams.has("search")) {
                    this.searchQuery = urlParams.get("search")
                }
                if (urlParams.has("sort")) {
                    this.sortBy = urlParams.get("sort")
                }

                this.updateFilteredResults()
            },

            // Check if any filters are active
            hasActiveFilters() {
                return this.selectedCategories.length > 0 ||
                    this.selectedPrice !== '' ||
                    this.selectedRating !== '' ||
                    this.selectedAvailability.length > 0 ||
                    this.selectedLocation !== '' ||
                    this.selectedDistance !== '' ||
                    this.searchQuery !== '';
            },

            // Remove specific category
            removeCategory(category) {
                this.selectedCategories = this.selectedCategories.filter((c) => c !== category)
                this.applyFilters()
            },

            // Clear all filters
            clearAllFilters() {
                this.selectedCategories = []
                this.selectedPrice = ""
                this.selectedRating = ""
                this.selectedAvailability = []
                this.selectedLocation = ""
                this.selectedDistance = ""
                this.searchQuery = ""
                this.sortBy = "recommended"
                this.applyFilters()
            },

            // Update filtered results
            updateFilteredResults() {
                const cards = document.querySelectorAll(".provider-card")
                let visibleCount = 0

                cards.forEach((card) => {
                    let visible = true

                    // Category filter
                    if (this.selectedCategories.length > 0) {
                        const cardCategories = card.dataset.categories
                        visible =
                            visible && this.selectedCategories.some((cat) => cardCategories.toLowerCase()
                                .includes(cat.toLowerCase()))
                    }

                    // Price filter
                    if (this.selectedPrice && this.selectedPrice !== "") {
                        const cardPrice = Number.parseFloat(card.dataset.price)
                        const [min, max] = this.selectedPrice.includes("+") ?
                            [Number.parseFloat(this.selectedPrice.replace("+", "")), Number.POSITIVE_INFINITY] :
                            this.selectedPrice.split("-").map((p) => Number.parseFloat(p))

                        visible = visible && cardPrice >= min && (max === undefined || cardPrice <= max)
                    }

                    // Rating filter
                    if (this.selectedRating && this.selectedRating !== "") {
                        const cardRating = Number.parseFloat(card.dataset.rating)
                        visible = visible && cardRating >= Number.parseFloat(this.selectedRating)
                    }

                    // Location filter
                    if (this.selectedLocation && this.selectedLocation !== "") {
                        const cardLocation = card.dataset.location.toLowerCase()
                        visible = visible && cardLocation.includes(this.selectedLocation.toLowerCase())
                    }

                    // Search query
                    if (this.searchQuery && this.searchQuery !== "") {
                        const searchText = (card.textContent || card.innerText).toLowerCase()
                        visible = visible && searchText.includes(this.searchQuery.toLowerCase())
                    }

                    // Show/hide card
                    if (visible) {
                        card.style.display = ""
                        visibleCount++
                    } else {
                        card.style.display = "none"
                    }
                })

                this.filteredResults = Array.from(cards).filter((card) => card.style.display !== "none")
            },

            // Apply filters with URL update
            applyFilters() {
                this.loading = true

                // Simulate loading delay for better UX
                setTimeout(() => {
                    this.updateFilteredResults()
                    this.updateURL()
                    this.loading = false
                }, 300)
            },

            // Update URL with current filter state
            updateURL() {
                const params = new URLSearchParams()

                if (this.selectedCategories.length > 0) {
                    params.set("categories", this.selectedCategories.join(","))
                }
                if (this.selectedPrice) {
                    params.set("price", this.selectedPrice)
                }
                if (this.selectedRating) {
                    params.set("rating", this.selectedRating)
                }
                if (this.selectedAvailability.length > 0) {
                    params.set("availability", this.selectedAvailability.join(","))
                }
                if (this.selectedLocation) {
                    params.set("location", this.selectedLocation)
                }
                if (this.selectedDistance) {
                    params.set("distance", this.selectedDistance)
                }
                if (this.searchQuery) {
                    params.set("search", this.searchQuery)
                }
                if (this.sortBy && this.sortBy !== "recommended") {
                    params.set("sort", this.sortBy)
                }

                // Update URL without page reload
                const newURL = params.toString() ? `${window.location.pathname}?${params.toString()}` : window.location
                    .pathname

                window.history.replaceState({}, "", newURL)
            },

            // Sort results
            sortResults() {
                const container = document.querySelector(".provider-cards-container")
                const cards = Array.from(container.children)

                cards.sort((a, b) => {
                    switch (this.sortBy) {
                        case "rating":
                            return Number.parseFloat(b.dataset.rating) - Number.parseFloat(a.dataset.rating)
                        case "price_low":
                            return Number.parseFloat(a.dataset.price) - Number.parseFloat(b.dataset.price)
                        case "price_high":
                            return Number.parseFloat(b.dataset.price) - Number.parseFloat(a.dataset.price)
                        case "reviews":
                            const aReviews = Number.parseInt(a.querySelector(".reviews-count")?.textContent ||
                                "0")
                            const bReviews = Number.parseInt(b.querySelector(".reviews-count")?.textContent ||
                                "0")
                            return bReviews - aReviews
                        default:
                            return 0 // Keep original order for 'recommended'
                    }
                })

                // Re-append sorted cards
                cards.forEach((card) => container.appendChild(card))
            }
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded',
        function() {
            // Add smooth scrolling for filter changes
            const filterInputs = document.querySelectorAll('input[type="checkbox"], input[type="radio"], select');
            filterInputs.forEach(input => {
                input.addEventListener('change', () => {
                    // Smooth scroll to results on mobile
                    if (window.innerWidth < 1280) {
                        document.querySelector('.provider-cards-container')?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        }
    )
</script>
