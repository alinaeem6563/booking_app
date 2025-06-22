@extends('layouts.app')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title', 'Saved Providers')

@section('content')
<div x-data="{ 
    sidebarOpen: false, 
    sidebarCollapsed: window.innerWidth >= 768 ? false : true,
    toggleSidebar() {
        if (window.innerWidth >= 768) {
            this.sidebarCollapsed = !this.sidebarCollapsed;
        } else {
            this.sidebarOpen = !this.sidebarOpen;
        }
    }
}" 
class="min-h-screen bg-gray-50"
:class="sidebarCollapsed ? 'sidebar-collapsed' : 'sidebar-expanded'">
        @include('navigation.sidebar')
        <!-- Main Content -->
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64" 
             :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">
             <!-- Top Header -->
             @include('navigation.UserHeader')

            <!-- Filters -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-sm p-6 mx-2 my-2 mb-6">
                <h1 class="text-2xl font-bold text-white">Saved Providers</h1>
                <div class="flex flex-col sm:flex-row gap-4">
                    <select id="category-filter"
                        class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Categories</option>
                        @forelse($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @empty
                            <option value="">No Categories Found</option>
                        @endforelse

                    </select>
                    <select id="rating-filter"
                        class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Ratings</option>
                        <option value="5">5 Stars</option>
                        <option value="4">4+ Stars</option>
                        <option value="3">3+ Stars</option>
                    </select>
                    <select id="sort-filter"
                        class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="recent">Recently Saved</option>
                        <option value="rating">Highest Rated</option>
                        <option value="name">Name A-Z</option>
                    </select>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" id="search-providers" placeholder="Search saved providers..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Providers Grid -->
            <div id="providers-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mx-2">
                <!-- Provider cards will be inserted here by JavaScript -->
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="text-center py-12 hidden">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No saved providers</h3>
                <p class="mt-1 text-sm text-gray-500">Start saving providers you'd like to work with again.</p>
            </div>
        </div>
    </div>
@endsection

@vite(['resources/js/get-all-providers.js']);

