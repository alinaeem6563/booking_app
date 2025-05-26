@extends('layouts.app')
<title>BookEase - Find and Book Service Providers</title>
@section('content')

<!-- Header -->
@include('navigation.Header')

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="container mx-auto px-4 py-16 sm:px-6 sm:py-24 lg:px-8 relative z-10">
        <div class="max-w-3xl">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl">
                Book services with confidence
            </h1>
            <p class="mt-6 text-xl max-w-2xl">
                Find and book the best service providers in your area. From home services to personal care, we've got
                you covered.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4">
                <a href="{{ route('providers.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-gray-50">
                    Find a Provider
                </a>
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center px-5 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-indigo-500">
                    Become a Provider
                </a>
            </div>
        </div>
    </div>
    <div class="absolute inset-0 bg-pattern opacity-10"></div>
</section>

<!-- Search Section -->
<section class="py-6 bg-white shadow-md relative -mt-8 rounded-t-3xl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-4">
                <form class="grid grid-cols-1 gap-4 sm:grid-cols-3" method="GET" action="{{ route('/') }}">
                    <div>
                        <label for="service" class="block text-sm font-medium text-gray-700">Service Providers</label>
                        <select id="provider_id" name="provider_id"
            onchange="this.form.submit()"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option value="">All Service Providers</option>
            @foreach ($allProviders as $provider)
                <option value="{{ $provider->id }}" {{ request('provider_id') == $provider->id ? 'selected' : '' }}>
                    {{ $provider->first_name }} {{ $provider->last_name }}
                </option>
            @endforeach
        </select>
                    </div>
                    
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" placeholder="Enter your location"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" readonly>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Featured Providers Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                Featured Service Providers
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Discover top-rated professionals ready to help you today
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <!-- Provider Card 1 -->
            @forelse($recommendedServices as $recommendedService)
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="relative">
                        <img class="h-48 w-full object-cover"
                            src="{{ asset('storage/' . $recommendedService->service_image) }}" alt="Provider profile">
                        <div class="absolute top-0 right-0 m-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Available Today
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div
                                    class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr($recommendedService->provider->first_name, 0, 1) . substr($recommendedService->provider->last_name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $recommendedService->provider->first_name }}
                                    {{ $recommendedService->provider->last_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $recommendedService->service_name }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center">
                                @php
                                    $avgRating = round($recommendedService->reviews->avg('rating'), 1);
                                    $totalReviews = $recommendedService->reviews->count();
                                    $fullStars = floor($avgRating);
                                    $hasHalfStar = $avgRating - $fullStars >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                                @endphp

                                {{-- ⭐ Render star icons --}}
                                <div class="flex items-center">
                                    {{-- Full Stars --}}
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <svg class="text-yellow-400 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path> {{-- Use your full star path --}}
                                        </svg>
                                    @endfor

                                    {{-- Half Star (optional) --}}
                                    @if ($hasHalfStar)
                                        <svg class="text-yellow-400 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <defs>
                                                <linearGradient id="halfGrad">
                                                    <stop offset="50%" stop-color="currentColor" />
                                                    <stop offset="50%" stop-color="lightgray" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#halfGrad)"
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path> {{-- Use same path as full star --}}
                                        </svg>
                                    @endif

                                    {{-- Empty Stars --}}
                                    @for ($i = 0; $i < $emptyStars; $i++)
                                        <svg class="text-gray-300 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path> {{-- Use same path as full star --}}
                                        </svg>
                                    @endfor

                                    {{-- 📊 Average & count --}}
                                    <span class="text-sm text-gray-600 ml-2">
                                        {{ $avgRating ?: 'N/A' }} ({{ $totalReviews }}
                                        {{ Str::plural('review', $totalReviews) }})
                                    </span>
                                </div>

                            </div>
                        </div>
                        <div class="mt-4 border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-500">Starting from</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        ${{ $recommendedService->service_price }}/hr</p>
                                </div>
                                <div>
                                    <span class="inline-flex rounded-md shadow-sm">
                                        <a href="{{ route('providers.show', $recommendedService->id) }}"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Book Now
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">No Services Providers Available At The Moment!</p>
            @endforelse
            @forelse($recommendedServices as $recommendedService)
    {{-- Card --}}
@empty
    <p>No Service Providers Found.</p>
@endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('providers.index') }}"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                View All Providers
            </a>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                How It Works
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Book your service in 3 simple steps
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <div class="relative text-center">
                <div
                    class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto mb-4">
                    <span class="text-2xl font-bold">1</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Search</h3>
                <p class="text-gray-500">
                    Browse through our extensive list of qualified service providers in your area.
                </p>
            </div>

            <div class="relative text-center">
                <div
                    class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto mb-4">
                    <span class="text-2xl font-bold">2</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Book</h3>
                <p class="text-gray-500">
                    Select a time slot that works for you and book your appointment instantly.
                </p>
            </div>

            <div class="relative text-center">
                <div
                    class="flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 text-indigo-600 mx-auto mb-4">
                    <span class="text-2xl font-bold">3</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Relax</h3>
                <p class="text-gray-500">
                    Sit back and relax while our professionals take care of your needs.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                What Our Customers Say
            </h2>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                Don't just take our word for it
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12 rounded-full"
                            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="">
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold">Sarah Thompson</h4>
                        <div class="flex items-center">
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
                            <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">
                    "I was amazed by how easy it was to book a cleaning service. The cleaner arrived on time and did an
                    exceptional job. Will definitely use this platform again!"
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12 rounded-full"
                            src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="">
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold">Robert Johnson</h4>
                        <div class="flex items-center">
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
                            <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">
                    "Had a plumbing emergency and needed someone fast. Found a great plumber through this app who came
                    within the hour. The service was excellent and reasonably priced."
                </p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0">
                        <img class="h-12 w-12 rounded-full"
                            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                            alt="">
                    </div>
                    <div class="ml-4">
                        <h4 class="text-lg font-bold">Jennifer Lee</h4>
                        <div class="flex items-center">
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
                            <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">
                    "I've tried several booking platforms, but this one stands out. The massage therapist I booked was
                    professional and skilled. The whole experience was seamless from booking to payment."
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-12 bg-indigo-600">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            Ready to book your service?
        </h2>
        <p class="mt-4 text-xl text-indigo-100 max-w-2xl mx-auto">
            Join thousands of satisfied customers who have found the perfect service provider.
        </p>
        <div class="mt-8 flex justify-center">
            <div class="inline-flex rounded-md shadow">
                <a href="{{ route('providers.index') }}"
                    class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50">
                    Get Started
                </a>
            </div>
            <div class="ml-3 inline-flex">
                <a href="#"
                    class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-700 hover:bg-indigo-800">
                    Learn More
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
@include('navigation.Footer')
@endsection
@section('script')
<script>
    document.getElementById('service').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const location = selectedOption.getAttribute('data-location') || '';
        document.getElementById('location').value = location;
    });
</script>
@endsection