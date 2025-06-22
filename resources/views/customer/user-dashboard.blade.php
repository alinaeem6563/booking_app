@extends('layouts.app')
@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
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
            


            <!-- Dashboard Content -->
            <main class="p-4 md:p-6 lg:p-8">
                <!-- Welcome Banner -->
                <div class="mb-8">
                    <div
                        class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 rounded-2xl p-8 text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10"></div>
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
                        <div class="relative z-10">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="mb-4 md:mb-0">
                                    <h2 class="text-3xl md:text-4xl font-bold mb-2">Welcome back,
                                        {{ auth()->user()->first_name }}! 👋</h2>
                                    <p class="text-indigo-100 text-lg">Here's what's happening with your bookings today.</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('providers.index') }}"
                                        class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 text-sm font-semibold rounded-xl hover:bg-indigo-50 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Book a Service
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Upcoming Bookings Card -->
                    <div
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Upcoming Bookings</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $upComingBooking }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="text-indigo-600 font-medium">Next: Today</span>
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Bookings Card -->
                    <div
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Completed Bookings</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $completedBookings }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">All time</span>
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Saved Providers Card -->
                    <div
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-pink-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Saved Providers</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $savedProviders }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="text-pink-600 font-medium">Favorites</span>
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Spent Card -->
                    <div
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Spent</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">${{ number_format($totalSpent, 2) }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="text-indigo-600 font-medium">This year</span>
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Bookings Section -->
                <div class="bg-white rounded-2xl shadow-sm mb-8 border border-gray-100" x-data="{ showAll: false }">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2 sm:mb-0">Upcoming Bookings</h2>
                            @if ($bookings && $bookings->count() > 2)
                                <button @click="showAll = !showAll"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-700 text-sm font-medium rounded-xl hover:bg-indigo-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span x-text="showAll ? 'Show Less' : 'View All'"></span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        @if ($bookings && $bookings->count())
                            <div class="space-y-4">
                                @foreach ($bookings->take(2) as $index => $booking)
                                    <div x-show="!showAll || {{ $index < 2 ? 'true' : 'false' }}"
                                        class="bg-gradient-to-r from-gray-50 to-indigo-50 rounded-xl p-6 border border-gray-100 hover:border-indigo-200 transition-all duration-200">
                                        @include('components.booking-card', ['booking' => $booking])
                                    </div>
                                @endforeach

                                <template x-if="showAll">
                                    <div class="space-y-4">
                                        @foreach ($bookings->slice(2) as $booking)
                                            <div
                                                class="bg-gradient-to-r from-gray-50 to-indigo-50 rounded-xl p-6 border border-gray-100 hover:border-indigo-200 transition-all duration-200">
                                                @include('components.booking-card', [
                                                    'booking' => $booking,
                                                ])
                                            </div>
                                        @endforeach
                                    </div>
                                </template>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div
                                    class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-12 h-12 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No upcoming bookings</h3>
                                <p class="text-gray-500 mb-4">Book your first service to get started!</p>
                                <a href="{{ route('providers.index') }}"
                                    class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                                    Browse Services
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recommended Services Section -->
                <div class="bg-white rounded-2xl shadow-sm mb-8 border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900">Recommended Services</h2>
                            <span
                                class="px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-medium rounded-full">Trending</span>
                        </div>
                    </div>
                    <div class="p-6">
                        @if ($recommendedServices->count())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($recommendedServices as $sp)
                                    <div
                                        class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                        <div class="relative h-48 bg-gray-200 overflow-hidden">
                                            <img src="{{ asset('storage/' . $sp->service_image) }}" alt="Service Image"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent">
                                            </div>

                                            @php
                                                $isSaved = false;
                                                if (Auth::check()) {
                                                    $isSaved = \App\Models\SavedProvider::where('user_id', Auth::id())
                                                        ->where('service_id', $sp->id)
                                                        ->exists();
                                                }
                                            @endphp

                                            <button
                                                class="save-provider-btn absolute top-3 right-3 p-2 bg-white/90 backdrop-blur-sm rounded-xl shadow-sm hover:bg-white transition-all duration-200"
                                                data-service-id="{{ $sp->id }}"
                                                data-is-saved="{{ $isSaved ? '1' : '0' }}">
                                                <svg class="h-5 w-5 heart-icon transition-all duration-200 {{ $isSaved ? 'text-red-500 fill-red-500' : 'text-gray-600 fill-none' }}"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="p-6">
                                            <h3
                                                class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200">
                                                {{ $sp->service_name }}</h3>

                                            <div class="flex items-center mb-3">
                                                <div class="flex items-center">
                                                    @php
                                                        $avgRating = round($sp->reviews->avg('rating'), 1);
                                                        $totalReviews = $sp->reviews->count();
                                                    @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="h-4 w-4 {{ $i <= $avgRating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="text-sm text-gray-600 ml-2">
                                                    {{ $avgRating ?: 'N/A' }} ({{ $totalReviews }}
                                                    {{ Str::plural('review', $totalReviews) }})
                                                </span>
                                            </div>

                                            <div class="flex items-center justify-between mb-4">
                                                <div class="flex items-baseline">
                                                    <span
                                                        class="text-2xl font-bold text-gray-900">${{ $sp->service_price ?? 'N/A' }}</span>
                                                    <span class="text-sm text-gray-600 ml-1">/hour</span>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $sp->provider->first_name ?? 'N/A' }}
                                                        {{ $sp->provider->last_name ?? 'N/A' }}</p>
                                                    <p class="text-xs text-gray-500">Service Provider</p>
                                                </div>
                                            </div>

                                            <a href="{{ route('providers.show', $sp->id) }}"
                                                class="w-full inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-indigo-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Book Now
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div
                                    class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-12 h-12 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No services available</h3>
                                <p class="text-gray-500">Check back later for recommended services.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Reviews Section -->
                <div class="bg-white rounded-2xl shadow-sm mb-8 border border-gray-100" x-data="{ showAll: false }">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2 sm:mb-0">Your Recent Reviews</h2>
                            @if ($reviews->count() > 2)
                                <button @click="showAll = !showAll"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-100 text-indigo-700 text-sm font-medium rounded-xl hover:bg-indigo-200 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span x-text="showAll ? 'Show Less' : 'View All'"></span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        @if ($reviews->count())
                            <div class="space-y-4">
                                @foreach ($reviews as $index => $review)
                                    <div class="bg-gradient-to-r from-gray-50 to-purple-50 rounded-xl p-6 border border-gray-100 hover:border-purple-200 transition-all duration-200"
                                        x-show="showAll || {{ $index }} < 2" x-transition>
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4">
                                            <div class="flex items-center mb-3 sm:mb-0">
                                                <div
                                                    class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl flex items-center justify-center text-white font-semibold">
                                                    {{ strtoupper(substr($review->service->provider->first_name, 0, 1) . substr($review->service->provider->last_name, 0, 1)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <h3 class="text-sm font-semibold text-gray-900">
                                                        {{ $review->service->provider->first_name }}
                                                        {{ $review->service->provider->last_name }}
                                                    </h3>
                                                    <p class="text-xs text-gray-500">{{ $review->service->service_name }}
                                                        • {{ $review->created_at->format('F j, Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <div class="flex">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                @if ($review->status === 1)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Approved
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Pending
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-700 leading-relaxed">{{ $review->review_text }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div
                                    class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-12 h-12 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No reviews yet</h3>
                                <p class="text-gray-500">Complete a booking to leave your first review!</p>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Reschedule Modal -->
                <div x-data="{ open: false }" id="rescheduleModalWrapper">
                    <!-- Triggered via JS -->
                    <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50"
                        x-transition x-cloak>
                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                            <h2 class="text-xl font-semibold mb-4">Reschedule Booking</h2>

                            <form id="rescheduleForm" class="space-y-4">
                                @csrf
                                <input type="hidden" name="booking_id" id="modal_booking_id">

                                <div>
                                    <label for="modal_slot_id"
                                        class="block text-sm font-medium text-gray-700 mb-1">Available Slots</label>
                                    <select id="modal_slot_id" name="slot_id"
                                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:outline-none focus:ring focus:border-indigo-500"
                                        required></select>
                                </div>

                                <div class="flex justify-end space-x-2 mt-4">
                                    <button type="button" onclick="closeRescheduleModal()"
                                        class="px-4 py-2 text-sm bg-gray-200 rounded hover:bg-gray-300">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 text-sm bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                        Update Booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced save provider functionality
            const saveButtons = document.querySelectorAll('.save-provider-btn');

            saveButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const serviceId = this.dataset.serviceId;
                    const isSaved = this.dataset.isSaved === '1';
                    const heartIcon = this.querySelector('.heart-icon');

                    // Add loading state
                    this.classList.add('opacity-50', 'pointer-events-none');

                    fetch('/save-provider', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                service_id: serviceId,
                                action: isSaved ? 'remove' : 'add'
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update button state
                                this.dataset.isSaved = isSaved ? '0' : '1';

                                // Update heart icon
                                if (isSaved) {
                                    heartIcon.classList.remove('text-red-500', 'fill-red-500');
                                    heartIcon.classList.add('text-gray-600', 'fill-none');
                                } else {
                                    heartIcon.classList.remove('text-gray-600', 'fill-none');
                                    heartIcon.classList.add('text-red-500', 'fill-red-500');
                                }

                                // Show success feedback
                                this.classList.add('scale-110');
                                setTimeout(() => {
                                    this.classList.remove('scale-110');
                                }, 200);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        })
                        .finally(() => {
                            // Remove loading state
                            this.classList.remove('opacity-50', 'pointer-events-none');
                        });
                });
            });

            
        });
    </script>
@endsection

@section('script')
    @vite(['resources/js/save-provider.js']);
@endsection
