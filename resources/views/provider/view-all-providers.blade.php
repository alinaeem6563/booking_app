@extends('layouts.app')
@Section('content')
    <!-- Header -->
    @include('navigation.Header')
    <!-- Page Title -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">All Service Providers</h1>
            <p class="mt-2 text-sm sm:text-base text-gray-600">Find and book the perfect service provider for your needs</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters and Search Section -->
        <div class="flex flex-col lg:flex-row gap-6 mb-8">
            <!-- Filters (Left Side) -->
            <div class="w-full lg:w-1/4 bg-white rounded-lg shadow-sm p-4 h-fit">
                <div x-data="{ open: true }">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold">Filters</h2>
                        <button @click="open = !open" class="text-gray-500 hover:text-indigo-600 lg:hidden">
                            <span x-show="!open">Show Filters</span>
                            <span x-show="open">Hide Filters</span>
                        </button>
                    </div>

                    <div x-show="open" class="space-y-6">
                        <!-- Service Category -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Service Category</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Home Cleaning</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Plumbing</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Electrical</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Personal Training</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Massage Therapy</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Home Renovation</span>
                                </label>
                            </div>
                            <button class="text-sm text-indigo-600 hover:text-indigo-800 mt-2">Show more</button>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Price Range</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="price"
                                        class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Any price</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price"
                                        class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">$0 - $25</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price"
                                        class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">$25 - $50</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price"
                                        class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">$50 - $100</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="price"
                                        class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">$100+</span>
                                </label>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Rating</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="radio" name="rating"
                                        class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Any rating</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="rating"
                                        class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 flex items-center text-sm text-gray-700">
                                        <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-gray-300 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <span class="ml-1">& up</span>
                                    </span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="rating"
                                        class="text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 flex items-center text-sm text-gray-700">
                                        <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-gray-300 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-gray-300 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <span class="ml-1">& up</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Availability</h3>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Available Today</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Available This Week</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Weekend Availability</span>
                                </label>
                            </div>
                        </div>

                        <!-- Location -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Location</h3>
                            <div class="mt-1">
                                <input type="text" placeholder="Enter your location"
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="mt-2">
                                <label class="flex items-center">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Within 5 miles</span>
                                </label>
                                <label class="flex items-center mt-1">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Within 10 miles</span>
                                </label>
                                <label class="flex items-center mt-1">
                                    <input type="checkbox" class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                    <span class="ml-2 text-sm text-gray-700">Within 20 miles</span>
                                </label>
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <div class="pt-2">
                            <button
                                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Apply Filters
                            </button>
                            <button class="w-full text-indigo-600 py-2 px-4 mt-2 text-sm hover:text-indigo-800">
                                Clear All Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Results (Right Side) -->
            <div class="w-full lg:w-3/4">
                <!-- Search Bar and Sort -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-grow">
                            <div class="relative">
                                <input type="text" placeholder="Search providers..."
                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md pl-10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4  d="
                                            M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414
                                            1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <label for="sort" class="block text-sm font-medium text-gray-700 mr-2">Sort by:</label>
                            <select id="sort"
                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option>Recommended</option>
                                <option>Highest Rated</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                                <option>Most Reviews</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="flex justify-between items-center mb-4">
                    <p class="text-sm text-gray-600">Showing <span class="font-medium">145</span> providers</p>
                    <div class="flex items-center">
                        <span class="text-sm text-gray-600 mr-2">View:</span>
                        <button class="p-1.5 bg-indigo-100 text-indigo-600 rounded-l-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <button
                            class="p-1.5 bg-white text-gray-600 rounded-r-md border-t border-r border-b border-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Provider Cards Grid -->


                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <!-- Provider Card 1 -->
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <div class="relative">
                                <img class="h-48 w-full object-cover"
                                    src="{{ asset('storage/' . $service->service_image) }}" alt="Provider profile">
                                <div class="absolute top-0 right-0 m-2">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800
                                        @if ($service->availability_status === 'Available') bg-green-100 text-green-800
                                        @elseif($service->availability_status === 'Fully Booked') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $service->availability_status }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($service->provider->first_name, 0, 1) . substr($service->provider->last_name, 0, 1)) }}

                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $service->provider->first_name }}
                                            {{ $service->provider->last_name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $service->service_name }}</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="flex items-center">
                                        <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <span class="ml-2 text-sm text-gray-500">128 reviews</span>
                                    </div>
                                </div>
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Santa Cruz, CA
                                </div>
                                <div class="mt-4 border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-sm text-gray-500">Starting from</p>
                                            <p class="text-lg font-semibold text-gray-900">
                                                ${{ $service->service_price }}/hr</p>
                                        </div>
                                        <div>
                                            <span class="inline-flex rounded-md shadow-sm">
                                                <a href="{{ route('providers.show', $service->id) }}"
                                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Book Now
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <a href="#"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" aria-current="page"
                            class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            1
                        </a>
                        <a href="#"
                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            2
                        </a>
                        <a href="#"
                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            3
                        </a>
                        <span
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                            ...
                        </span>
                        <a href="#"
                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            8
                        </a>
                        <a href="#"
                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            9
                        </a>
                        <a href="#"
                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            10
                        </a>
                        <a href="#"
                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('navigation.Footer')
@endsection
