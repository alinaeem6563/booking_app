@extends('layouts.app')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BookEase - Sarah Anderson | Professional Cleaner</title>
    <style>
        #calendar {
            max-width: 900px;
            margin: 40px auto;
        }
    </style>
@endsection
<!-- Header -->
@include('navigation.Header')

<!-- Breadcrumbs -->
<div class="bg-white border-b">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="#" class="text-gray-500 hover:text-gray-700 text-sm">Home</a>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('providers.index') }}"
                        class="ml-2 text-gray-500 hover:text-gray-700 text-sm">Providers</a>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <a href="#" class="ml-2 text-gray-500 hover:text-gray-700 text-sm">Home Cleaning</a>
                </li>
                <li class="flex items-center">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2 text-indigo-600 text-sm font-medium">{{ $service->provider->first_name }}
                        {{ $service->provider->last_name }}</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Main Content -->
<main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if ($errors->any())
        <div class="mb-4 p-4 rounded-md bg-red-100 text-red-800 border border-red-300">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 p-4 rounded-md bg-gray-100 text-gray-800 border border-gray-300">
            {{ session('success') }}
        </div>
    @endif
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Left Column - Provider Details -->
        <div class="w-full lg:w-2/3">
            <!-- Provider Header -->

            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="relative h-64">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $service->service_image) }}"
                        alt="Home cleaning service">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 flex items-end">
                        <div class="mr-4">
                            <div
                                class="h-20 w-20 rounded-full border-4 border-white bg-indigo-600 flex items-center justify-center text-white text-2xl font-bold">
                                {{ strtoupper(substr($service->provider->first_name, 0, 1) . substr($service->provider->last_name, 0, 1)) }}

                            </div>
                        </div>
                        <div class="text-white">
                            <h1 class="text-2xl sm:text-3xl font-bold">{{ $service->provider->first_name }}
                                {{ $service->provider->last_name }}</h1>
                            <p class="text-lg">{{ $service->service_name }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-wrap items-center gap-4">
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

                            <span class="ml-2 text-gray-700"> {{ $averageRating }} ({{ $totalReviews }}
                                reviews)</span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ ucwords($service->service_location) }}

                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <span
                                class="text-green-600 font-medium
                                    @if ($service->availability_status === 'Available') text-green-600
                                    @elseif($service->availability_status === 'Fully Booked') text-red-600
                                    @else text-gray-600 @endif">
                                {{ $service->availability_status }}
                            </span>
                        </div>
                        <div class="flex items-center text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Verified Provider
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-4 mb-6">
                        <a href="#about" class="text-indigo-600 hover:text-indigo-800 font-medium">About</a>
                        <a href="#services" class="text-indigo-600 hover:text-indigo-800 font-medium">Services</a>
                        <a href="#reviews" class="text-indigo-600 hover:text-indigo-800 font-medium">Reviews</a>
                        <a href="#faq" class="text-indigo-600 hover:text-indigo-800 font-medium">FAQ</a>
                        <a href="#gallery" class="text-indigo-600 hover:text-indigo-800 font-medium">Gallery</a>
                    </div>
                    <div class="flex flex-wrap gap-4">

                        <a href="tel:{{ $service->provider->phone }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            Contact
                        </a>

                        <button
                            class="save-provider-btn inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            data-service-id="{{ $service->id }}" data-is-saved="{{ $isSavedByUser ? '1' : '0' }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6 heart-icon transition duration-300 ease-in-out {{ $isSavedByUser ? 'text-red-500 fill-red-500' : 'text-gray-400 fill-none' }}"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            Save
                        </button>


                        <button
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                            Share
                        </button>
                    </div>
                </div>
            </div>

            <!-- About Section -->
            <div id="about" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                <h2 class="text-xl font-bold mb-4">About Sarah</h2>
                <p class="text-gray-700 mb-4">
                    {{ $service->service_description }}
                </p>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">Qualifications & Certifications</h3>
                    <ul class="list-disc list-inside text-gray-700 space-y-1">
                        @foreach (explode(',', $service->qualifications_certifications) as $qualification_certification)
                            <li>
                                {{ trim($qualification_certification) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Services Section -->
            <div id="services" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                <h2 class="text-xl font-bold mb-4">Services Offered</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @php
                        $offerings = json_decode($service->service_offerings, true);
                    @endphp
                    @if (is_array($offerings))
                        @foreach ($offerings as $offering)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <h3 class="font-semibold">{{ $offering['service_name'] }}</h3>
                                </div>
                                <p class="text-gray-700 text-sm">
                                    {{ $offering['description'] }}
                                </p>
                                <div class="mt-2 text-indigo-600 font-medium">From ${{ $offering['price'] }}/hr</div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-500 text-sm">No offerings available.</p>
                    @endif
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">Additional Services</h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach (json_decode($service->additional_services, true) ?? [] as $additional)
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ $additional['name'] }}
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <!-- Gallery Section -->
            <div id="gallery" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                <h2 class="text-xl font-bold mb-4">Work Gallery</h2>

                @php
                    $galleryImages = json_decode($service->work_gallery, true);
                @endphp

                @if (is_array($galleryImages) && count($galleryImages) > 0)
                    <div id="galleryGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($galleryImages as $index => $galleryImage)
                            <div
                                class="rounded-lg overflow-hidden h-40 mb-4 {{ $index >= 6 ? 'hidden extra-image' : '' }}">
                                <img src="{{ asset('storage/' . $galleryImage) }}" alt="Work Gallery Image"
                                    class="w-full h-full object-cover hover:opacity-90 transition-opacity">
                            </div>
                        @endforeach
                    </div>

                    @if (count($galleryImages) > 6)
                        <div class="mt-4 text-center">
                            <button id="viewAllBtn" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                View All Photos
                            </button>
                        </div>
                    @endif
                @else
                    <p class="text-sm text-gray-500">No gallery images available.</p>
                @endif
            </div>


            <!-- Reviews Section -->
            <!-- Add Review Form -->
            <div id="add-review" class="bg-white rounded-xl shadow-sm overflow-hidden mt-6 p-6">
                <h2 class="text-xl font-bold mb-6">Write a Review</h2>

                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">

                    <!-- Rating Selection -->
                    <div x-data="{ rating: 0 }" class="flex items-center space-x-1" id="rating-stars">
                        <template x-for="i in 5" :key="i">
                            <button type="button" class="rating-star p-1 focus:outline-none" @click="rating = i"
                                :aria-label="'Rate ' + i + ' stars'">
                                <svg :class="i <= rating ? 'text-yellow-400' : 'text-gray-300'"
                                    class="h-8 w-8 hover:text-yellow-400 transition-colors" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </template>
                        <input type="hidden" name="rating" :value="rating" x-model.number="rating">
                    </div>

                    <!-- Review Text -->
                    <div>
                        <label for="review-text" class="block text-sm font-medium text-gray-700 mb-2">Your
                            Review</label>
                        <textarea id="review-text" name="review_text" rows="4"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Share your experience with this service provider..." required></textarea>
                    </div>

                    <!-- Submit Button -->
                    @auth
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                :disabled="rating === 0" :class="{ 'opacity-50 cursor-not-allowed': rating === 0 }"
                                id="submit-review-btn">
                                Submit Review
                            </button>
                        </div>
                    @endauth

                    @guest
                        <div class="flex justify-end">
                            <a href="{{ route('login') }}"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Login To Submit Review
                            </a>
                        </div>
                    @endguest
                </form>

            </div>
            <div id="reviews" class="bg-white rounded-xl shadow-sm overflow-hidden mt-6 p-6">
                <h2 class="text-xl font-bold mb-4">Customer Reviews</h2>

                @if ($service->reviews->count() > 0)
                    <div id="reviewList" class="space-y-6">
                        @foreach ($service->reviews as $index => $review)
                            <div class="{{ $index >= 3 ? 'hidden extra-review' : '' }} border-b pb-4">
                                <div class="flex items-center mb-2">
                                    <div class="font-semibold text-gray-800">{{ $review->user->first_name ?? 'User' }}
                                        {{ $review->user->last_name ?? 'Name' }}</div>
                                    <div class="ml-4 text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="inline-block w-4 h-4 {{ $review->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->review_text }}</p>
                                @if ($review->service_details)
                                    <p class="text-sm text-gray-500 mt-1">Service: {{ $review->service_details }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if ($service->reviews->count() > 3)
                        <div class="mt-4 text-center">
                            <button id="viewAllReviewsBtn" class="text-indigo-600 hover:text-indigo-800 font-medium">
                                View All Reviews
                            </button>
                        </div>
                    @endif
                @else
                    <p class="text-sm text-gray-500">No reviews yet.</p>
                @endif
            </div>



            <!-- FAQ Section -->
            <div id="faq" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                <h2 class="text-xl font-bold mb-4">Frequently Asked Questions</h2>
                <div class="space-y-4" x-data="{ selected: null }">
                    @php
                        $faqs = $service->faqs ?? [];
                    @endphp

                    <div x-data="{ selected: null }" class="space-y-4">
                        @foreach ($faqs as $index => $faq)
                            <div class="border border-gray-200 rounded-lg">
                                <button
                                    @click="selected !== {{ $index }} ? selected = {{ $index }} : selected = null"
                                    class="flex justify-between items-center w-full px-4 py-3 text-left">
                                    <span class="font-medium">{{ $faq['questions'] }}</span>
                                    <svg class="h-5 w-5 text-gray-500"
                                        :class="{ 'transform rotate-180': selected == {{ $index }} }"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="selected == {{ $index }}"
                                    class="px-4 py-3 border-t border-gray-200 text-gray-700">
                                    {{ $faq['answers'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Booking Form -->
        @guest
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-24">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold mb-4">Book {{ $service->provider->first_name }}'s Services</h2>
                        <div class="flex items-center mb-4">
                            <div class="text-2xl font-bold text-gray-900">${{ $service->service_price }}</div>
                            <div class="text-gray-500 ml-2">/ hour</div>
                        </div>
                        @if ($service->availability_status === 'Available')
                            <div class="flex items-center text-sm text-green-500 mb-4">
                                <svg class="h-5 w-5 text-green-500 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $service->availability_status }}
                            </div>
                        @elseif($service->availability_status === 'Fully Booked')
                            <div class="flex items-center text-sm text-red-500 mb-4">
                                <svg class="h-5 w-5 text-red-500 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 9.75l4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $service->availability_status }}
                            </div>
                        @else
                            <div class="flex items-center text-sm text-yellow-500 mb-4">
                                <svg class="h-5 w-5 text-yellow-500 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v3.75m0 3.75h.008v.008H12v-.008M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $service->availability_status }}
                            </div>
                        @endif

                    </div>
                    <div class="p-6">

                        @if (session('success'))
                            <div class="alert alert-success mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="list-disc pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('booking-store') }}" method="POST">
                            @csrf

                            <!-- Service Type -->
                            <div class="mb-4">
                                <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service
                                    Type</label>
                                <select id="service" name="service_offering_id"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @foreach (json_decode($service->service_offerings, true) as $offering)
                                        <option value="{{ $offering['service_id'] }}"
                                            data-price="{{ $offering['price'] }}">
                                            {{ $offering['service_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hidden inputs -->
                            <input type="hidden" name="provider_id" value="{{ $service->provider->id }}">
                            <input type="hidden" name="service_id" value="{{ $service->id }}">

                            <!-- Date/Booking Slots -->
                            <div class="mb-4">
                                <label for="selected_slot_id"
                                    class="block text-sm font-medium text-gray-700 mb-1">Date</label>

                                <!-- Hidden inputs updated by calendar script -->
                                <input type="hidden" name="slot_id" id="selected_slot_id">
                                <input type="hidden" name="start_time" id="selected_start_time">
                                <input type="hidden" name="end_time" id="selected_end_time">
                                <input type="hidden" name="duration" id="duration">
                                <input type="hidden" name="slot_time" id="selected_slot_time">


                                <!-- Modal trigger button -->
                                <button type="button" id="openServiceCalendarModalBtn"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full ">
                                    Available Dates
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>

                                <!-- Calendar modal (included from Blade partial) -->
                                @include('calendar.service-calendar-modal')
                            </div>

                            <!-- Additional Services -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Services</label>
                                <div class="space-y-2">

                                    @foreach (json_decode($service->additional_services, true) ?? [] as $additional)
                                        <label class="flex items-center">
                                            <input type="checkbox"
                                                class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4 additional-service"
                                                data-price="{{ $additional['price'] }}" name="additional_services[]"
                                                value="{{ $additional['name'] }}">
                                            <span class="ml-2 text-sm text-gray-700">
                                                {{ $additional['name'] }} (+${{ $additional['price'] }})
                                            </span>
                                        </label>
                                    @endforeach

                                </div>
                            </div>

                            <div class="text-sm text-gray-600 mb-4" id="time-summary">
                                <!-- Will be populated by JS -->
                            </div>

                            <!-- Price Summary -->
                            <div class="border-t border-gray-200 pt-4 mb-6">

                                <div id="price-summary">
                                    <!-- Dynamically updated via JavaScript -->
                                </div>

                                <div class="flex justify-between font-bold text-lg mt-4">
                                    <span>Total</span>
                                    <input type="hidden" name="total_amount" id="total_amount_input" value="0">
                                    <span id="total-amount">$00.00</span>
                                </div>
                            </div>

                            <!-- Book Now Button -->
                            @auth
                                <button type="submit"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Book Now
                                </button>
                            @endauth

                            @guest
                                <a href="{{ route('login') }}"
                                    class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Login to Book
                                </a>
                            @endguest

                        </form>
                    </div>

                </div>
            </div>
        @endguest
        @auth
            @if (auth()->user()->account_type === 'user')
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-24">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-bold mb-4">Book {{ $service->provider->first_name }}'s Services</h2>
                            <div class="flex items-center mb-4">
                                <div class="text-2xl font-bold text-gray-900">${{ $service->service_price }}</div>
                                <div class="text-gray-500 ml-2">/ hour</div>
                            </div>
                            @if ($service->availability_status === 'Available')
                                <div class="flex items-center text-sm text-green-500 mb-4">
                                    <svg class="h-5 w-5 text-green-500 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $service->availability_status }}
                                </div>
                            @elseif($service->availability_status === 'Fully Booked')
                                <div class="flex items-center text-sm text-red-500 mb-4">
                                    <svg class="h-5 w-5 text-red-500 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.75 9.75l4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $service->availability_status }}
                                </div>
                            @else
                                <div class="flex items-center text-sm text-yellow-500 mb-4">
                                    <svg class="h-5 w-5 text-yellow-500 mr-1" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v3.75m0 3.75h.008v.008H12v-.008M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $service->availability_status }}
                                </div>
                            @endif

                        </div>
                        <div class="p-6">

                            @if (session('success'))
                                <div class="alert alert-success mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif


                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="list-disc pl-5">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('booking-store') }}" method="POST">
                                @csrf

                                <!-- Service Type -->
                                <div class="mb-4">
                                    <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service
                                        Type</label>
                                    <select id="service" name="service_offering_id"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        @foreach (json_decode($service->service_offerings, true) as $offering)
                                            <option value="{{ $offering['service_id'] }}"
                                                data-price="{{ $offering['price'] }}">
                                                {{ $offering['service_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Hidden inputs -->
                                <input type="hidden" name="provider_id" value="{{ $service->provider->id }}">
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                                <!-- Date/Booking Slots -->
                                <div class="mb-4">
                                    <label for="selected_slot_id"
                                        class="block text-sm font-medium text-gray-700 mb-1">Date</label>

                                    <!-- Hidden inputs updated by calendar script -->
                                    <input type="hidden" name="slot_id" id="selected_slot_id">
                                    <input type="hidden" name="start_time" id="selected_start_time">
                                    <input type="hidden" name="end_time" id="selected_end_time">
                                    <input type="hidden" name="duration" id="duration">
                                    <input type="hidden" name="slot_time" id="selected_slot_time">


                                    <!-- Modal trigger button -->
                                    <button type="button" id="openServiceCalendarModalBtn"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full ">
                                        Available Dates
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </button>

                                    <!-- Calendar modal (included from Blade partial) -->
                                    @include('calendar.service-calendar-modal')
                                </div>

                                <!-- Additional Services -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Additional Services</label>
                                    <div class="space-y-2">

                                        @foreach (json_decode($service->additional_services, true) ?? [] as $additional)
                                            <label class="flex items-center">
                                                <input type="checkbox"
                                                    class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4 additional-service"
                                                    data-price="{{ $additional['price'] }}" name="additional_services[]"
                                                    value="{{ $additional['name'] }}">
                                                <span class="ml-2 text-sm text-gray-700">
                                                    {{ $additional['name'] }} (+${{ $additional['price'] }})
                                                </span>
                                            </label>
                                        @endforeach

                                    </div>
                                </div>
                                <!-- Additional Information -->
                                <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                                    <h2 class="text-xl font-bold mb-4">Additional Information</h2>

                                    <div class="mb-4">
                                        <label for="special_instruction"
                                            class="block text-sm font-medium text-gray-700 mb-1">Special
                                            Instructions
                                            <span class="text-gray-400">(optional)</span></label>
                                        <textarea id="special_instruction" name="special_instruction" rows="3"
                                            placeholder="Any special requests or information for the service provider?"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-control"></textarea>
                                    </div>

                                    <div class="flex items-start mb-4">
                                        <div class="flex items-center h-5">
                                            <input id="terms" name="terms" type="checkbox"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="terms" class="font-medium text-gray-700">I agree to the <a
                                                    href="#" class="text-indigo-600 hover:text-indigo-500">Terms of
                                                    Service</a> and <a href="#"
                                                    class="text-indigo-600 hover:text-indigo-500">Privacy
                                                    Policy</a></label>
                                        </div>
                                    </div>

                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="marketing" name="marketing" type="checkbox"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="marketing" class="font-medium text-gray-700">Email me about
                                                special
                                                pricing
                                                and updates</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-sm text-gray-600 mb-4" id="time-summary">
                                    <!-- Will be populated by JS -->
                                </div>

                                <!-- Price Summary -->
                                <div class="border-t border-gray-200 pt-4 mb-6">

                                    <div id="price-summary">
                                        <!-- Dynamically updated via JavaScript -->
                                    </div>

                                    <div class="flex justify-between font-bold text-lg mt-4">
                                        <span>Total</span>
                                        <input type="hidden" name="total_amount" id="total_amount_input"
                                            value="0">
                                        <span id="total-amount">$00.00</span>
                                    </div>
                                </div>

                                <!-- Book Now Button -->
                                @auth
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Book Now
                                    </button>
                                @endauth

                                @guest
                                    <a href="{{ route('login') }}"
                                        class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Login to Book
                                    </a>
                                @endguest

                            </form>
                        </div>

                    </div>
                </div>
            @endif
        @endauth
    </div>

    <!-- Similar Providers Section -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold mb-6">Similar Providers You Might Like</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($suggestedProviders as $sp)
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="relative">
                        <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $service->service_image) }}"
                            alt="{{ $sp->first_name }}">
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
                                    {{ strtoupper(substr($sp->first_name, 0, 1)) }}{{ strtoupper(substr($sp->last_name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">{{ $sp->first_name }}
                                    {{ $sp->last_name }}</h3>
                                <p class="text-sm text-gray-500">{{ $service->service_name ?? 'Service Provider' }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="h-5 w-5 {{ $i < round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            @endfor
                            <span class="ml-2 text-sm text-gray-500">{{ $averageRating }} ({{ $totalReviews }}
                                reviews)</span>
                        </div>
                        <div class="mt-4 border-t border-gray-200 pt-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Starting from</p>
                                <p class="text-lg font-semibold text-gray-900">
                                    ${{ $service->service_price ?? 'N/A' }}/hr</p>
                            </div>
                            <a href="{{ route('providers.show', $service->id) }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                                View Profile
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No similar providers found.</p>
            @endforelse
        </div>
    </div>

</main>

<!-- Footer -->
@include('navigation.Footer')
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const serviceSelect = document.getElementById('service');
            const durationInput = document.getElementById('duration'); // Hidden input updated by calendar
            const serviceFee = {{ $service->service_fee ?? 0 }};
            const tax = {{ $service->tax ?? 0 }}; // tax percentage
            const totalAmountEl = document.getElementById('total-amount');
            const priceSummaryEl = document.getElementById('price-summary');
            const additionalCheckboxes = document.querySelectorAll('.additional-service');

            function formatCurrency(amount) {
                return `$${amount.toFixed(2)}`;
            }

            function updateTotalPrice() {
                const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
                const serviceName = selectedOption.textContent.trim();
                const servicePrice = parseFloat(selectedOption.dataset.price) || 0;
                const duration = parseFloat(durationInput.value) || 0;

                let subtotal = servicePrice * duration;
                let summaryHTML = `
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">${serviceName} (${duration} hour${duration !== 1 ? 's' : ''})</span>
                    <span class="text-gray-900">${formatCurrency(subtotal)}</span>
                </div>
            `;

                // Additional services
                additionalCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        const label = cb.closest('label').textContent.trim();
                        const price = parseFloat(cb.dataset.price) || 0;
                        subtotal += price;
                        summaryHTML += `
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">${label}</span>
                            <span class="text-gray-900">${formatCurrency(price)}</span>
                        </div>
                    `;
                    }
                });

                // Add service fee
                subtotal += serviceFee;

                // Calculate tax as percentage
                const taxAmount = (subtotal * tax) / 100;

                // Final total
                const total = subtotal + taxAmount;

                summaryHTML += `
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Service Fee</span>
                    <span class="text-gray-900">${formatCurrency(serviceFee)}</span>
                </div>
                        <div class="flex justify-between font-bold mt-2 border-t border-b py-2">
                    <span class="text-gray-900">Sub Total</span>
                    <span class="text-gray-900">${formatCurrency(subtotal)}</span>
                </div>
                <div class="flex justify-between mb-2 pt-2">
                    <span class="text-gray-600">Tax (${tax}%)</span>
                    <span class="text-gray-900">${formatCurrency(taxAmount)}</span>
                </div>
        
            `;

                // Update hidden input value for total_amount so it's submitted
                document.getElementById('total_amount_input').value = total.toFixed(2);

                // Update UI
                priceSummaryEl.innerHTML = summaryHTML;
                totalAmountEl.textContent = formatCurrency(total);
            }

            // Expose globally for calendar script to call
            window.updateTotalPrice = updateTotalPrice;

            // Bind change event to all additional services
            additionalCheckboxes.forEach(cb => cb.addEventListener('change', updateTotalPrice));
        });
    </script>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/js/save-provider.js', 'resources/js/review.js', 'resources/js/booking-slot-alert.js']);
@endsection
