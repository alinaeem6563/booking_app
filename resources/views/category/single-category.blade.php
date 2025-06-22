@extends('layouts.app')

@section('title', $category->category_name . ' - Category Details')

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
    }" class="min-h-screen bg-gray-50"
        :class="sidebarCollapsed ? 'sidebar-collapsed' : 'sidebar-expanded'">
        @include('navigation.sidebar')

        <!-- Main Content -->
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64"
            :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">
            <!-- Top Header -->
            @include('navigation.UserHeader')

            <!-- Enhanced Header with Gradient -->
            <div class="mb-6">
                <div
                    class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 md:p-8 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div
                        class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white opacity-5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-24 h-24 md:w-48 md:h-48 bg-white opacity-5 rounded-full -ml-12 md:-ml-24 -mb-12 md:-mb-24">
                    </div>
                    <div class="relative z-10">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <!-- Category Info -->
                            <div class="flex items-center">
                                <!-- Back Button -->
                                <a href="{{ auth()->user()->account_type === 'admin' ? route('categories.index') : route('all-categories') }}"
                                    class="mr-4 p-3 rounded-xl bg-white/20 backdrop-blur-sm hover:bg-white/30 transition-all duration-200 border border-white/30">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </a>

                                <!-- Category Icon -->
                                <div
                                    class="h-16 w-16 md:h-20 md:w-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white mr-6 shadow-lg border border-white/30">
                                    @if (str_starts_with($category->category_icon_link, '<svg'))
                                        {!! $category->category_icon_link !!}
                                    @elseif(str_starts_with($category->category_icon_link, 'http'))
                                        <img src="{{ $category->category_icon_link }}" alt="Icon"
                                            class="h-10 w-10 md:h-12 md:w-12 object-contain">
                                    @else
                                        <svg class="h-10 w-10 md:h-12 md:w-12" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    @endif
                                </div>

                                <!-- Category Details -->
                                <div>
                                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">
                                        {{ $category->category_name }}</h1>
                                    <p class="text-purple-100 text-sm md:text-lg mb-3">{{ $category->category_slug }}</p>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $category->category_status === 'active' ? 'bg-green-100/20 text-green-100 border-green-200/30' : 'bg-red-100/20 text-red-100 border-red-200/30' }}">
                                            <span
                                                class="{{ $category->category_status === 'active' ? 'bg-green-400' : 'bg-red-400' }} w-2 h-2 rounded-full mr-2"></span>
                                            {{ ucfirst($category->category_status) }}
                                        </span>
                                        <span class="text-sm text-purple-200 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Created {{ $category->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Actions -->
                            @if (auth()->user()->account_type === 'admin')
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                        class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-lg hover:bg-white/30 transition-all duration-200 border border-white/30">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Category
                                    </a>
                                    <button onclick="deleteCategory({{ $category->id }})"
                                        class="inline-flex items-center px-6 py-3 bg-red-500/20 backdrop-blur-sm text-white font-medium rounded-lg hover:bg-red-500/30 transition-all duration-200 border border-red-400/30">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto" x-data="categoryDetails()">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Description -->
                        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-4">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-900">About This Category</h2>
                            </div>
                            <p class="text-gray-700 leading-relaxed text-lg">{{ $category->category_description }}</p>
                        </div>

                        <!-- Services in this Category -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 md:p-8 border-b border-gray-100">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-4">
                                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0v2a2 2 0 002 2h4a2 2 0 002-2V6m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-8V6a2 2 0 012 2v6a2 2 0 01-2 2h-2">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="text-xl font-semibold text-gray-900">
                                                Services in {{ $category->category_name }}
                                            </h2>
                                            <p class="text-sm text-gray-600 mt-1">{{ $categoryServices->count() }} services
                                                available</p>
                                        </div>
                                    </div>

                                    <!-- Service Filters -->
                                    <div class="flex items-center gap-3">
                                        <select x-model="serviceSort" @change="sortServices()"
                                            class="text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                            <option value="name">Sort by Name</option>
                                            <option value="price">Sort by Price</option>
                                            <option value="rating">Sort by Rating</option>
                                            <option value="newest">Newest First</option>
                                        </select>

                                        <button @click="serviceView = serviceView === 'grid' ? 'list' : 'grid'"
                                            class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                            <svg x-show="serviceView === 'grid'" class="h-5 w-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                            </svg>
                                            <svg x-show="serviceView === 'list'" class="h-5 w-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 md:p-8">
                                @if ($categoryServices->count() > 0)
                                    <!-- Grid View -->
                                    <div x-show="serviceView === 'grid'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <template x-for="service in sortedServices" :key="service.id">
                                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-indigo-200 transition-all duration-300 cursor-pointer transform hover:-translate-y-1"
                                                @click="viewService(service.id)">
                                                <div class="flex items-start justify-between mb-4">
                                                    <h3 class="font-semibold text-gray-900 line-clamp-2 flex-1"
                                                        x-text="service.service_name"></h3>
                                                    <span class="text-xl font-bold text-indigo-600 ml-3 flex-shrink-0"
                                                        x-text="'$' + service.service_price"></span>
                                                </div>

                                                <p class="text-gray-600 text-sm mb-4 line-clamp-2"
                                                    x-text="service.service_description"></p>

                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center">
                                                        <div class="flex items-center">
                                                            <template x-for="i in 5" :key="i">
                                                                <svg :class="i <= (service.avg_rating || 0) ? 'text-yellow-400' :
                                                                    'text-gray-300'"
                                                                    class="h-4 w-4" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            </template>
                                                            <span class="ml-2 text-sm font-medium text-gray-700"
                                                                x-text="{{ number_format($averageRating, 1) }}"></span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- List View -->
                                    <div x-show="serviceView === 'list'" class="space-y-4">
                                        <template x-for="service in sortedServices" :key="service.id">
                                            <div class="border border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-indigo-200 transition-all duration-300 cursor-pointer"
                                                @click="viewService(service.id)">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center justify-between mb-3">
                                                            <h3 class="font-semibold text-gray-900 truncate"
                                                                x-text="service.service_name"></h3>
                                                            <span class="text-xl font-bold text-indigo-600 ml-4"
                                                                x-text="'$' + service.service_price"></span>
                                                        </div>
                                                        <p class="text-gray-600 text-sm mb-3 line-clamp-1"
                                                            x-text="service.service_description"></p>
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center">
                                                                <template x-for="i in 5" :key="i">
                                                                    <svg :class="i <= (service.avg_rating || 0) ? 'text-yellow-400' :
                                                                        'text-gray-300'"
                                                                        class="h-4 w-4" fill="currentColor"
                                                                        viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                    </svg>
                                                                </template>
                                                                <span class="ml-2 text-sm font-medium text-gray-700"
                                                                    x-text="{{ number_format($averageRating, 1) }}"></span>
                                                            </div>
                                                            <span
                                                                class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full"
                                                                x-text="service.provider_name"></span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-6">
                                                        <svg class="h-5 w-5 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                @else
                                    <!-- Empty State -->
                                    <div class="text-center py-16">
                                        <div
                                            class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0v2a2 2 0 002 2h4a2 2 0 002-2V6m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-8V6a2 2 0 012 2v6a2 2 0 01-2 2h-2" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No services available</h3>
                                        <p class="text-gray-600 mb-6">There are currently no services in this category.</p>
                                        @if (Auth::user()->account_type === 'provider')
                                            <a href="{{ route('services.create') }}"
                                                class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add First Service
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Related Categories -->
                        @if ($relatedCategories->count() > 0)
                            <div class="bg-white rounded-xl shadow-sm p-6 md:p-8 border border-gray-100">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-4">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </div>
                                    <h2 class="text-xl font-semibold text-gray-900">Related Categories</h2>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach ($relatedCategories as $relatedCategory)
                                        <a href="{{ route('categories.show', $relatedCategory->id) }}"
                                            class="flex items-center p-4 border border-gray-200 rounded-xl hover:shadow-lg hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                                            <div
                                                class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mr-4 flex-shrink-0">
                                                @if (str_starts_with($relatedCategory->category_icon_link, '<svg'))
                                                    {!! $relatedCategory->category_icon_link !!}
                                                @elseif(str_starts_with($relatedCategory->category_icon_link, 'http'))
                                                    <img src="{{ $relatedCategory->category_icon_link }}" alt="Icon"
                                                        class="h-6 w-6 object-contain">
                                                @else
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                        </path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="font-medium text-gray-900 truncate">
                                                    {{ $relatedCategory->category_name }}</h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ $relatedCategory->services_count ?? 0 }} services</p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Category Stats -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-3">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Category Statistics</h3>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-gray-600 font-medium">Total Services</span>
                                    <span class="font-bold text-gray-900 text-lg">{{ $categoryServices->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-gray-600 font-medium">Active Providers</span>
                                    <span class="font-bold text-gray-900 text-lg">{{ $activeProviders }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-gray-600 font-medium">Average Rating</span>
                                    <div class="flex items-center">
                                        <span
                                            class="font-bold text-gray-900 text-lg mr-2">{{ number_format($averageRating, 1) }}</span>
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-gray-600 font-medium">Price Range</span>
                                    <span class="font-bold text-gray-900 text-lg">
                                        @if ($priceRange['min'] && $priceRange['max'])
                                            ${{ number_format($priceRange['min']) }} -
                                            ${{ number_format($priceRange['max']) }}
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-3">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            </div>
                            <div class="space-y-3">
                                @if (Auth::user()->account_type === 'provider')
                                    <a href="{{ route('services.create', ['category' => $category->id]) }}"
                                        class="w-full inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add Service
                                    </a>
                                @endif

                                <button @click="shareCategory()"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                    </svg>
                                    Share Category
                                </button>

                                <a href="{{ route('all-categories') }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Browse All Categories
                                </a>
                            </div>
                        </div>

                        <!-- Category Details -->
                        @if (Auth::user()->account_type === 'admin')
                            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mr-3">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Category Details</h3>
                                </div>
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-gray-600 font-medium">ID:</span>
                                        <span class="font-mono text-gray-900">{{ $category->id }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-gray-600 font-medium">Slug:</span>
                                        <span class="font-mono text-gray-900">{{ $category->category_slug }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-gray-600 font-medium">Created:</span>
                                        <span class="text-gray-900">{{ $category->created_at->format('M j, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <span class="text-gray-600 font-medium">Updated:</span>
                                        <span class="text-gray-900">{{ $category->updated_at->format('M j, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function categoryDetails() {
            return {
                services: @json($categoryServices),
                sortedServices: [],
                serviceSort: 'name',
                serviceView: 'grid',

                init() {
                    this.sortedServices = [...this.services];
                    this.sortServices();
                },

                sortServices() {
                    this.sortedServices.sort((a, b) => {
                        switch (this.serviceSort) {
                            case 'name':
                                return a.service_name.localeCompare(b.service_name);
                            case 'price':
                                return parseFloat(a.service_price) - parseFloat(b.service_price);
                            case 'rating':
                                return (b.avg_rating || 0) - (a.avg_rating || 0);
                            case 'newest':
                                return new Date(b.created_at) - new Date(a.created_at);
                            default:
                                return 0;
                        }
                    });
                },

                viewService(serviceId) {
                    window.location.href = `/services/${serviceId}`;
                },

                shareCategory() {
                    if (navigator.share) {
                        navigator.share({
                            title: '{{ $category->category_name }}',
                            text: '{{ $category->category_description }}',
                            url: window.location.href
                        });
                    } else {
                        // Fallback to copying URL
                        navigator.clipboard.writeText(window.location.href).then(() => {
                            this.showNotification('Category URL copied to clipboard!', 'success');
                        }).catch(() => {
                            this.showNotification('Failed to copy URL', 'error');
                        });
                    }
                },

                showNotification(message, type) {
                    const notification = document.createElement('div');
                    notification.className =
                        `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
                    notification.textContent = message;
                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }
            }
        }


        function deleteCategory(categoryId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure you want to delete this category? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EC3A45', // Custom red
                cancelButtonColor: '#d3d3d3',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/categories/${categoryId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json',
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = '{{ route('categories.index') }}';
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error deleting category. Please try again.',
                                    confirmButtonColor: '#4338CA',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error deleting category. Please try again.',
                                confirmButtonColor: '#4338CA',
                            });
                        });
                }
            });

        }
    </script>

    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
