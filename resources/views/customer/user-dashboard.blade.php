@extends('layouts.app')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
        @include('navigation.sidebar')
        <!-- Main Content -->
        <div class="flex-1 p-4">
            <!-- Top Header -->
            @include('navigation.UserHeader')

            <!-- Dashboard Content -->
            <main class="p-4 md:p-6 lg:p-8">
                <!-- Welcome Banner -->
                <div class="bg-indigo-600 rounded-lg shadow-sm mb-8">
                    <div class="px-6 py-8 md:px-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-white">Welcome back, {{ auth()->user()->first_name }}!</h2>
                                <p class="mt-2 text-indigo-100">Here's what's happening with your bookings today.</p>
                            </div>
                            <div class="hidden md:block">
                                <a href="{{ route('providers.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Book a Service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Upcoming Bookings</h2>
                                <p class="text-lg font-semibold text-gray-800">{{ $upComingBooking }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Completed Bookings</h2>
                                <p class="text-lg font-semibold text-gray-800">{{ $completedBookings }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Saved Providers</h2>
                                <p class="text-lg font-semibold text-gray-800">5</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 11V9a2 2 0 00-2-2m2 4v4a2 2 0 104 0v-1m-4-3H9m2 0h4m6 1a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Total Spent</h2>
                                <p class="text-lg font-semibold text-gray-800">${{ $totalSpent }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Bookings Section -->
                <div class="bg-white rounded-lg shadow-sm mb-8" x-data="{ showAll: false }">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Upcoming Bookings</h2>
                            @if ($bookings && $bookings->count() > 2)
                                <button @click="showAll = !showAll"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    <span x-text="showAll ? 'Hide' : 'View All'"></span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            @if ($bookings && $bookings->count())
                                <!-- Show only first 2 bookings -->
                                @foreach ($bookings->take(2) as $index => $booking)
                                    <div x-show="!showAll || {{ $index < 2 ? 'true' : 'false' }}">
                                        @include('components.booking-card', ['booking' => $booking])
                                    </div>
                                @endforeach

                                <!-- Show all bookings when toggled -->
                                <template x-if="showAll">
                                    <div>
                                        @foreach ($bookings->slice(2) as $booking)
                                            @include('components.booking-card', ['booking' => $booking])
                                        @endforeach
                                    </div>
                                </template>
                            @endif
                        </div>
                    </div>
                </div>


                <!-- Recommended Services Section -->
                <div class="bg-white rounded-lg shadow-sm mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Recommended Services</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Service Card 1 -->
                            <!-- Service Cards -->
                            @forelse ($recommendedServices as $sp)
                                <div class="border rounded-lg overflow-hidden shadow-sm">
                                    <div class="h-48 bg-gray-200 relative">
                                        <img src="{{ asset('storage/' . $sp->service_image) }}" alt="Service Image"
                                            class="w-full h-full object-cover">
                                        <div class="absolute top-2 right-2">
                                            @php
                                            $isSaved = false;
                                            if (Auth::check()) {
                                                $isSaved = \App\Models\SavedProvider::where('user_id', Auth::id())
                                                    ->where('service_id', $sp->id)
                                                    ->exists();
                                            }
                                        @endphp
                                        
                                        <button
                                            class="save-provider-btn absolute top-2 right-2 p-1.5 bg-white rounded-full shadow-sm focus:outline-none"
                                            data-service-id="{{ $sp->id }}"
                                            data-is-saved="{{ $isSaved ? '1' : '0' }}"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 heart-icon transition duration-200 ease-in-out {{ $isSaved ? 'text-red-500 fill-red-500' : 'text-gray-400 fill-none' }}"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                        
                                        </div>
                                        
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $sp->service_name }}</h3>
                                        <div class="flex items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            @php
                                                $avgRating = round($sp->reviews->avg('rating'), 1);
                                                $totalReviews = $sp->reviews->count();
                                            @endphp
                                            <span class="text-sm text-gray-600 ml-1">
                                                {{ $avgRating ?: 'N/A' }} ({{ $totalReviews }}
                                                {{ Str::plural('review', $totalReviews) }})
                                            </span>
                                        </div>


                                        <div class="flex justify-between items-center mb-4">
                                            <div>
                                                <span
                                                    class="text-lg font-bold text-gray-900">${{ $sp->service_price ?? 'N/A' }}</span>
                                                <span class="text-sm text-gray-600">/hour</span>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                <span>{{ $sp->provider->first_name ?? 'N/A' }}
                                                    {{ $sp->provider->last_name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('providers.show', $sp->id) }}"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500">No services found.</p>
                            @endforelse

                        </div>
                    </div>
                </div>

                <!-- Recent Reviews Section -->
                <div class="bg-white rounded-lg shadow-sm mb-8" x-data="{ showAll: false }">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Your Recent Reviews</h2>
                            <button @click="showAll = !showAll"
                                class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                <span x-text="showAll ? 'Hide' : 'View All'"></span>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Review cards -->
                            @foreach ($reviews as $index => $review)
                                <div class="border rounded-lg p-4" x-show="showAll || {{ $index }} < 2"
                                    x-transition>
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-sm font-medium">
                                                {{ strtoupper(substr($review->service->provider->first_name, 0, 1) . substr($review->service->provider->last_name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-gray-900">
                                                    {{ $review->service->provider->first_name }}
                                                    {{ $review->service->provider->last_name }}
                                                </h3>
                                                <p class="text-xs text-gray-500">{{ $review->service->service_name }} -
                                                    {{ $review->created_at->format('F j, Y') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            @for ($i = 0; $i < $review->rating; $i++)
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0
                                            00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54
                                            1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8
                                            2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1
                                            1 0 00-.364-1.118L2.98
                                            8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0
                                            00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                            @if ($review->status === 1)
                                                <span
                                                    class="mx-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Approved
                                                </span>
                                            @else
                                                <span
                                                    class="mx-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600">{{ $review->review_text }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
@endsection
@section('script')
@vite(['resources/js/save-provider.js']);
@endsection