@extends('layouts.app')

<title>BookEase - Sarah Anderson | Professional Cleaner</title>

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
                            
                            <span class="ml-2 text-gray-700"> {{ $averageRating }} ({{ $totalReviews }} reviews)</span>
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
                            <span class="text-green-600 font-medium">Available Today</span>
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
                        <button
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Book Now
                        </button>
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
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                            <h3 class="font-semibold">Deep Cleaning</h3>
                        </div>
                        <p class="text-gray-700 text-sm">
                            Thorough cleaning including hard-to-reach areas, appliances, and detailed sanitization.
                        </p>
                        <div class="mt-2 text-indigo-600 font-medium">From $35/hr</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <h3 class="font-semibold">Move-In/Move-Out Cleaning</h3>
                        </div>
                        <p class="text-gray-700 text-sm">
                            Complete cleaning to prepare a property for new occupants or to leave it in perfect
                            condition.
                        </p>
                        <div class="mt-2 text-indigo-600 font-medium">From $40/hr</div>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <h3 class="font-semibold">Eco-Friendly Cleaning</h3>
                        </div>
                        <p class="text-gray-700 text-sm">
                            Cleaning services using only natural, non-toxic products that are safe for your family and
                            the environment.
                        </p>
                        <div class="mt-2 text-indigo-600 font-medium">From $30/hr</div>
                    </div>
                </div>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-2">Additional Services</h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        @foreach (explode(',', $service->additional_services) as $additional)
                            <li class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ trim($additional) }}
                            </li>
                        @endforeach


                    </ul>
                </div>
            </div>

            <!-- Gallery Section -->
            <div id="gallery" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                <h2 class="text-xl font-bold mb-4">Work Gallery</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @php
                        $galleryImages = json_decode($service->work_gallery, true);
                    @endphp

                    @if (is_array($galleryImages))
                        @foreach ($galleryImages as $galleryImage)
                            <div class="rounded-lg overflow-hidden h-40 mb-4">
                                <img src="{{ asset('storage/' . $galleryImage) }}" alt="Work Gallery Image"
                                    class="w-full h-full object-cover hover:opacity-90 transition-opacity">
                            </div>
                        @endforeach
                    @else
                        <p class="text-sm text-gray-500">No gallery images available.</p>
                    @endif

                </div>
                <div class="mt-4 text-center">
                    <button class="text-indigo-600 hover:text-indigo-800 font-medium">View All Photos</button>
                </div>
            </div>

            <!-- Reviews Section -->
            <div id="reviews" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Client Reviews</h2>
                    <div class="flex items-center">
                        <div class="flex">
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
                        </div>
                        <span class="ml-2 text-gray-700">{{ $averageRating }} ({{ $totalReviews }} reviews)</span>
                    </div>
                </div>

                <!-- Review Items -->
                <div class="space-y-6">
                    @forelse ($service->reviews as $review)
                    @if($review->status==1)
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-center mb-2">
                            <img class="h-10 w-10 rounded-full mr-3"
                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="Customer">
                            <div>
                                <h4 class="font-medium">{{$review->user->first_name}} {{$review->user->last_name}}</h4>
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="flex">
                                        @for($i = 0; $i < $review->rating; $i++)
                                        <svg class="text-yellow-400 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700">
                           {{$review->review_text}}
                        </p>
                    </div>
                    @endif
@endforeach
                    <div class="border-b border-gray-200 pb-6">
                        <div class="flex items-center mb-2">
                            <img class="h-10 w-10 rounded-full mr-3"
                                src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="Customer">
                            <div>
                                <h4 class="font-medium">Michael Roberts</h4>
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="flex">
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
                                    <span class="ml-2">1 month ago</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700">
                            I hired Sarah for a move-out cleaning and she exceeded all expectations. The property
                            manager was impressed with how clean everything was. Sarah is professional, punctual, and
                            does an outstanding job. Highly recommend!
                        </p>
                    </div>

                    <div>
                        <div class="flex items-center mb-2">
                            <img class="h-10 w-10 rounded-full mr-3"
                                src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="Customer">
                            <div>
                                <h4 class="font-medium">Emily Thompson</h4>
                                <div class="flex items-center text-sm text-gray-500">
                                    <div class="flex">
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
                                    <span class="ml-2">2 months ago</span>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-700">
                            I've been using Sarah's cleaning services for the past 6 months and couldn't be happier.
                            She's reliable, trustworthy, and does an exceptional job every time. Her eco-friendly
                            cleaning products leave my home smelling fresh without harsh chemicals. Definitely worth
                            every penny!
                        </p>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button class="text-indigo-600 hover:text-indigo-800 font-medium">Read All 128 Reviews</button>
                </div>
            </div>
            <!-- Add Review Form -->
            <div id="add-review" class="bg-white rounded-xl shadow-sm overflow-hidden mt-6 p-6">
                <h2 class="text-xl font-bold mb-6">Write a Review</h2>
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
                <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Rating Selection -->
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <div x-data="{ rating: 0 }" class="flex items-center" id="rating-stars">
                        <template x-for="i in 5" :key="i">
                            <button type="button" class="rating-star p-1 focus:outline-none"
                                @click="rating = i; document.getElementById('rating-value').value = rating; document.getElementById('submit-review-btn').disabled = false">
                                <svg :class="rating >= i ? 'text-yellow-400' : 'text-gray-300'"
                                    class="h-8 w-8 hover:text-yellow-400 transition-colors" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </template>
                        <input type="hidden" name="rating" id="rating-value" x-model="rating">
                    </div>

                    <!-- Review Text -->
                    <div>
                        <label for="review-text" class="block text-sm font-medium text-gray-700 mb-2">Your
                            Review</label>
                        <textarea id="review-text" name="review_text" rows="4"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="Share your experience with this service provider..." required></textarea>
                    </div>

                    <!-- Service Details (Optional) -->
                    <div>
                        <label for="service-details" class="block text-sm font-medium text-gray-700 mb-2">Service
                            Details (Optional)</label>
                        <input type="text" id="service-details" name="service_details"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                            placeholder="What service did you receive? (e.g., Deep Cleaning, Move-out Cleaning)">
                    </div>

                    <!-- Submit Button -->
                    @auth
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                id="submit-review-btn" disabled>
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


            <!-- FAQ Section -->
            <div id="faq" class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                <h2 class="text-xl font-bold mb-4">Frequently Asked Questions</h2>
                <div class="space-y-4" x-data="{ selected: null }">
                    <div class="border border-gray-200 rounded-lg">
                        <button @click="selected !== 1 ? selected = 1 : selected = null"
                            class="flex justify-between items-center w-full px-4 py-3 text-left">
                            <span class="font-medium">What cleaning supplies do you bring?</span>
                            <svg class="h-5 w-5 text-gray-500" :class="{ 'transform rotate-180': selected == 1 }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="selected == 1" class="px-4 py-3 border-t border-gray-200 text-gray-700">
                            I bring all necessary cleaning supplies and equipment, including eco-friendly cleaning
                            products. If you have specific products you prefer, please let me know in advance, and I'll
                            be happy to use them.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button @click="selected !== 2 ? selected = 2 : selected = null"
                            class="flex justify-between items-center w-full px-4 py-3 text-left">
                            <span class="font-medium">How long does a typical cleaning session take?</span>
                            <svg class="h-5 w-5 text-gray-500" :class="{ 'transform rotate-180': selected == 2 }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="selected == 2" class="px-4 py-3 border-t border-gray-200 text-gray-700">
                            The duration depends on the size of your home and the type of cleaning service. A standard
                            cleaning for a 2-bedroom apartment typically takes 2-3 hours, while a deep cleaning may take
                            4-5 hours.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button @click="selected !== 3 ? selected = 3 : selected = null"
                            class="flex justify-between items-center w-full px-4 py-3 text-left">
                            <span class="font-medium">Do I need to be home during the cleaning?</span>
                            <svg class="h-5 w-5 text-gray-500" :class="{ 'transform rotate-180': selected == 3 }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="selected == 3" class="px-4 py-3 border-t border-gray-200 text-gray-700">
                            It's entirely up to you. Many clients provide a key or access code for entry. If you prefer
                            to be present, that's fine too. We can discuss what works best for your situation.
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-lg">
                        <button @click="selected !== 4 ? selected = 4 : selected = null"
                            class="flex justify-between items-center w-full px-4 py-3 text-left">
                            <span class="font-medium">What is your cancellation policy?</span>
                            <svg class="h-5 w-5 text-gray-500" :class="{ 'transform rotate-180': selected == 4 }"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="selected == 4" class="px-4 py-3 border-t border-gray-200 text-gray-700">
                            I request at least 24 hours' notice for cancellations. Cancellations with less than 24
                            hours' notice may be subject to a cancellation fee of 50% of the service cost.
                        </div>
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
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Available today
                        </div>
                    </div>
                    <div class="p-6">
                        <form>
                            <!-- Service Type -->
                            <div class="mb-4">
                                <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service
                                    Type</label>
                                <select id="service" name="service"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    @php
                                        $offerings = json_decode($service->service_offerings, true);
                                    @endphp

                                    @if (is_array($offerings))
                                        @foreach ($offerings as $offering)
                                            <option>{{ $offering['service_name'] }}</option>
                                        @endforeach
                                    @endif


                                </select>
                            </div>

                            <!-- Date -->
                            <div class="mb-4">
                                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                <input type="date" id="date" name="date"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Time -->
                            <div class="mb-4">
                                <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                                <select id="time" name="time"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option>8:00 AM</option>
                                    <option>9:00 AM</option>
                                    <option>10:00 AM</option>
                                    <option>11:00 AM</option>
                                    <option>12:00 PM</option>
                                    <option>1:00 PM</option>
                                    <option>2:00 PM</option>
                                    <option>3:00 PM</option>
                                    <option>4:00 PM</option>
                                </select>
                            </div>

                            <!-- Duration -->
                            <div class="mb-4">
                                <label for="duration"
                                    class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                                <select id="duration" name="duration"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option>2 hours</option>
                                    <option>3 hours</option>
                                    <option>4 hours</option>
                                    <option>5 hours</option>
                                    <option>6 hours</option>
                                    <option>7 hours</option>
                                    <option>8 hours</option>
                                </select>
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" id="address" name="address" placeholder="Enter your address"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <!-- Special Requests -->
                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Special
                                    Requests</label>
                                <textarea id="notes" name="notes" rows="3" placeholder="Any special instructions or requests?"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            </div>

                            <!-- Additional Services -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Services</label>
                                <div class="space-y-2">
                                    @php
                                        $offerings = json_decode($service->service_offerings, true);
                                    @endphp

                                    @if (is_array($offerings))
                                        @foreach ($offerings as $offering)
                                            <label class="flex items-center">
                                                <input type="checkbox"
                                                    class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                                <span class="ml-2 text-sm text-gray-700">
                                                    {{ $offering['service_name'] }} (+${{ $offering['price'] }})
                                                </span>
                                            </label>
                                        @endforeach
                                    @endif

                                </div>
                            </div>

                            <!-- Price Summary -->
                            <div class="border-t border-gray-200 pt-4 mb-6">
                                @php
                                    $offerings = json_decode($service->service_offerings, true);
                                @endphp

                                @if (is_array($offerings))
                                    @foreach ($offerings as $offering)
                                        <div class="flex justify-between mb-2">
                                            <span class="text-gray-600">{{ $offering['service_name'] }}
                                                ({{ $service->service_duration }} hours)
                                            </span>
                                            <span
                                                class="text-gray-900">${{ $offering['price'] * $service->service_duration }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-gray-500">No service offerings available.</div>
                                @endif

                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Service Fee</span>
                                    <span class="text-gray-900">$10.00</span>
                                </div>
                                <div class="flex justify-between font-bold text-lg mt-4">
                                    <span>Total</span>
                                    <span>$85.00</span>
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
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Available today
                            </div>
                        </div>
                        <div class="p-6">
                            <form>
                                <!-- Service Type -->
                                <div class="mb-4">
                                    <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service
                                        Type</label>
                                    <select id="service" name="service"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        @foreach (json_decode($service->service_offerings, true) as $offering)
                                            <option>{{ $offering['service_name'] }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <!-- Date -->
                                <div class="mb-4">
                                    <label for="date"
                                        class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                                    <input type="date" id="date" name="date"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Time -->
                                <div class="mb-4">
                                    <label for="time"
                                        class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                                    <select id="time" name="time"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option>8:00 AM</option>
                                        <option>9:00 AM</option>
                                        <option>10:00 AM</option>
                                        <option>11:00 AM</option>
                                        <option>12:00 PM</option>
                                        <option>1:00 PM</option>
                                        <option>2:00 PM</option>
                                        <option>3:00 PM</option>
                                        <option>4:00 PM</option>
                                    </select>
                                </div>

                                <!-- Duration -->
                                <div class="mb-4">
                                    <label for="duration"
                                        class="block text-sm font-medium text-gray-700 mb-1">Duration</label>
                                    <select id="duration" name="duration"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option>2 hours</option>
                                        <option>3 hours</option>
                                        <option>4 hours</option>
                                        <option>5 hours</option>
                                        <option>6 hours</option>
                                        <option>7 hours</option>
                                        <option>8 hours</option>
                                    </select>
                                </div>

                                <!-- Address -->
                                <div class="mb-4">
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" id="address" name="address" placeholder="Enter your address"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                <!-- Special Requests -->
                                <div class="mb-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Special
                                        Requests</label>
                                    <textarea id="notes" name="notes" rows="3" placeholder="Any special instructions or requests?"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>

                                <!-- Additional Services -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Additional Services</label>
                                    <div class="space-y-2">
                                        @foreach (json_decode($service->service_offerings, true) as $offering)
                                            <label class="flex items-center">
                                                <input type="checkbox"
                                                    class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                                                <span class="ml-2 text-sm text-gray-700">{{ $offering['service_name'] }}
                                                    (+${{ $offering['price'] }})
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Price Summary -->
                                <div class="border-t border-gray-200 pt-4 mb-6">
                                    @foreach (json_decode($service->service_offerings, true) as $offering)
                                        <div class="flex justify-between mb-2">
                                            <span class="text-gray-600">{{ $offering['service_name'] }}
                                                ({{ $service->service_duration }} hours)
                                            </span>
                                            <span
                                                class="text-gray-900">${{ $offering['price'] * $service->service_duration }}</span>
                                        </div>
                                    @endforeach
                                    <div class="flex justify-between mb-2">
                                        <span class="text-gray-600">Service Fee</span>
                                        <span class="text-gray-900">$10.00</span>
                                    </div>
                                    <div class="flex justify-between font-bold text-lg mt-4">
                                        <span>Total</span>
                                        <span>$85.00</span>
                                    </div>
                                </div>

                                <!-- Book Now Button -->
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
            <!-- Provider Card 1 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative">
                    <img class="h-48 w-full object-cover"
                        src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60"
                        alt="Provider profile">
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
                                LM
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Lisa Martinez</h3>
                            <p class="text-sm text-gray-500">Professional Cleaner</p>
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
                            <svg class="text-gray-300 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="ml-2 text-sm text-gray-500">4.8 (96 reviews)</span>
                        </div>
                    </div>
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Starting from</p>
                                <p class="text-lg font-semibold text-gray-900">$28/hr</p>
                            </div>
                            <div>
                                <span class="inline-flex rounded-md shadow-sm">
                                    <a href="#"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View Profile
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Provider Card 2 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative">
                    <img class="h-48 w-full object-cover"
                        src="https://images.unsplash.com/photo-1542206395-9feb3edaa68d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60"
                        alt="Provider profile">
                    <div class="absolute top-0 right-0 m-2">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Available Tomorrow
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div
                                class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                JW
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">James Wilson</h3>
                            <p class="text-sm text-gray-500">Professional Cleaner</p>
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
                            <span class="ml-2 text-sm text-gray-500">4.9 (112 reviews)</span>
                        </div>
                    </div>
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Starting from</p>
                                <p class="text-lg font-semibold text-gray-900">$30/hr</p>
                            </div>
                            <div>
                                <span class="inline-flex rounded-md shadow-sm">
                                    <a href="#"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View Profile
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Provider Card 3 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="relative">
                    <img class="h-48 w-full object-cover"
                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=60"
                        alt="Provider profile">
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
                                AT
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-gray-900">Amy Taylor</h3>
                            <p class="text-sm text-gray-500">Professional Cleaner</p>
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
                            <svg class="text-gray-300 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="ml-2 text-sm text-gray-500">4.7 (89 reviews)</span>
                        </div>
                    </div>
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Starting from</p>
                                <p class="text-lg font-semibold text-gray-900">$27/hr</p>
                            </div>
                            <div>
                                <span class="inline-flex rounded-md shadow-sm">
                                    <a href="#"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        View Profile
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
@include('navigation.Footer')
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-star');
            const ratingInput = document.getElementById('rating-value');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const selectedRating = parseInt(this.dataset.value);
                    ratingInput.value = selectedRating;

                    // Update all stars
                    stars.forEach(s => {
                        const svg = s.querySelector('svg');
                        if (parseInt(s.dataset.value) <= selectedRating) {
                            svg.classList.remove('text-gray-300');
                            svg.classList.add('text-yellow-400');
                        } else {
                            svg.classList.remove('text-yellow-400');
                            svg.classList.add('text-gray-300');
                        }
                    });
                });
            });
        });
    </script>
@endsection
