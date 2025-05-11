<!-- categories.blade.php -->
@extends('layouts.app')

@section('title', 'Service Categories')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-purple-600 to-indigo-700">
        <div class="absolute inset-0">
            <img src="{{ asset('images/pattern-bg.png') }}" alt="" class="w-full h-full object-cover opacity-10">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
            <div class="text-center">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Service Categories
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-xl text-indigo-100">
                    Find the perfect service provider for your needs. Browse our categories and connect with trusted professionals.
                </p>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="relative flex-grow max-w-lg">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="search" placeholder="Search categories..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <div>
                        <label for="sort" class="sr-only">Sort by</label>
                        <select id="sort" name="sort" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm rounded-md">
                            <option value="popular">Most Popular</option>
                            <option value="name-asc">Name (A-Z)</option>
                            <option value="name-desc">Name (Z-A)</option>
                            <option value="providers">Most Providers</option>
                        </select>
                    </div>
                    <button type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 flex flex-col">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br {{ $category->gradient }} flex items-center justify-center text-white">
                            {!! $category->icon !!}
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                            <div class="flex items-center mt-1">
                                <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-500">{{ $category->providerCount }} providers</span>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-gray-600 line-clamp-3">{{ $category->description }}</p>
                </div>
                <div class="mt-auto p-6 pt-0">
                    <a href="{{ route('categories.show', $category->slug) }}" class="block w-full text-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        View Services
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if(count($categories) === 0)
        <div class="text-center py-16">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">No categories found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria.</p>
        </div>
        @endif

        <!-- Pagination -->
        @if(count($categories) > 0)
        <div class="mt-12 flex justify-center">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

    <!-- Featured Categories Section -->
    <div class="bg-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">Featured Categories</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Our most popular service categories with top-rated providers
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($featuredCategories as $category)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 text-center">
                        <div class="p-6">
                            <div class="mx-auto h-16 w-16 rounded-full bg-gradient-to-br {{ $category->gradient }} flex items-center justify-center text-white">
                                {!! $category->icon !!}
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                            <p class="mt-2 text-sm text-gray-500">{{ $category->providerCount }} providers</p>
                            <a href="{{ route('categories.show', $category->slug) }}" class="mt-4 inline-flex items-center text-sm font-medium text-purple-600 hover:text-purple-500">
                                Explore
                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900">How It Works</h2>
                <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500">
                    Find and book services in just a few simple steps
                </p>
            </div>

            <div class="mt-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">1. Browse Categories</h3>
                        <p class="mt-2 text-base text-gray-500">Explore our wide range of service categories to find what you need.</p>
                    </div>

                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">2. Choose a Provider</h3>
                        <p class="mt-2 text-base text-gray-500">Compare profiles, reviews, and prices to select the best provider.</p>
                    </div>

                    <div class="text-center">
                        <div class="mx-auto h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">3. Book & Enjoy</h3>
                        <p class="mt-2 text-base text-gray-500">Schedule your service and enjoy professional assistance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Add any JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const sortSelect = document.getElementById('sort');
        
        // Example of search functionality
        searchInput.addEventListener('input', function(e) {
            // In a real app, you might want to debounce this
            const searchTerm = e.target.value.toLowerCase();
            // Implement search logic or form submission
        });
        
        // Example of sort functionality
        sortSelect.addEventListener('change', function(e) {
            const sortValue = e.target.value;
            // Implement sort logic or form submission
        });
    });
</script>
@endsection