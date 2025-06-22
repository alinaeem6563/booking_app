@extends('layouts.app')
<title>BookEase - Find and Book Service Providers</title>
@section('style')
    <style>
        /* Additional responsive styles */
        @media (max-width: 768px) {
            .grid-cols-1.gap-8.md\:grid-cols-2.lg\:grid-cols-3 {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .grid-cols-1.gap-8.md\:grid-cols-2.lg\:grid-cols-3 {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }

        @media (min-width: 1024px) {
            .grid-cols-1.gap-8.md\:grid-cols-2.lg\:grid-cols-3 {
                grid-template-columns: repeat(3, 1fr);
                gap: 2rem;
            }
        }

        /* Smooth hover effects */
        .bg-white.p-6.rounded-xl.shadow-md {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .bg-white.p-6.rounded-xl.shadow-md:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
@endsection
@section('content')

    <!-- Header -->
    @include('navigation.Header')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
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
                    <form method="GET" action="{{ route('/') }}" class="mb-8 flex flex-col sm:flex-row gap-4">

                        <!-- The input with icon inside -->
                        <div class="relative mx-auto min-w-full sm:w-1/3">
                            <!-- Text input with padding left so text doesn't overlap icon -->
                            <input type="text" name="location" value="{{ request('location') }}"
                                placeholder="Enter location..."
                                class="pl-3 w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <!-- Search Icon (clickable) -->
                            <button type="submit"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-indigo-600 focus:outline-none"
                                aria-label="Search">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-7 h-7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0
                                                                  1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>


                        </div>

                        <!-- Optional other inputs/buttons, e.g. -->
                        {{-- <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            Search
                        </button> --}}

                    </form>



                    <form method="GET" action="{{ route('/') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div>
                            <label for="provider_id" class="block text-sm font-medium text-gray-700">Service
                                Providers</label>
                            <select id="provider_id" name="provider_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                onchange="updateLocation()">
                                <option value="">All Service Providers</option>
                                @foreach ($allProviders as $provider)
                                    @php
                                        $location = optional($provider->services->first())->service_location;
                                    @endphp
                                    <option value="{{ $provider->id }}" data-location="{{ $location }}">
                                        {{ $provider->first_name }} {{ $provider->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" id="location" placeholder="Enter your location"
                                value="{{ request('location') }}"
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                readonly>
                        </div>

                        <div class="flex items-end">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Search
                            </button>
                            <a href="{{ route('/') }}"
                                class="bg-gray-300 text-gray-600 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm  hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mx-2">
                                Reset
                            </a>
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
                @if (request('provider_id') || request('location'))
                    <div class="col-span-full text-center mb-6">
                        <h2 class="text-xl font-semibold text-indigo-600">Filtered Results</h2>
                        <p class="text-sm text-gray-500">
                            @if (request('provider_id'))
                                Provider:
                                {{ optional($allProviders->firstWhere('id', request('provider_id')))->first_name }}
                                {{ optional($allProviders->firstWhere('id', request('provider_id')))->last_name }}
                            @endif
                            @if (request('location'))
                                | Location: {{ request('location') }}
                            @endif
                        </p>
                    </div>
                @endif

                <!-- Provider Card 1 -->
                @forelse($recommendedServices as $recommendedService)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="relative">
                            <img class="h-48 w-full object-cover"
                                src="{{ asset('storage/' . $recommendedService->service_image) }}" alt="Provider profile">
                            <div class="absolute top-0 right-0 m-2">

                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800
                                    @if ($recommendedService->availability_status === 'Available') bg-green-100 text-green-800
                                    @elseif($recommendedService->availability_status === 'Fully Booked') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $recommendedService->availability_status }}
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
                    <div class="col-span-full text-center">
                        <p class="text-gray-500 text-lg">No service available in this area.</p>
                    </div>
                @endforelse
                @if ($allProvidersCount > 4)
                    <div class="mt-12 text-center">
                        <a href="{{ route('providers.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View All Providers
                        </a>
                    </div>
                @endif
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

    <!-- Testimonials Carousel Section -->
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

            @if ($topReviews->count() > 0)
                <div x-data="testimonialCarousel()" class="relative">
                    <!-- Carousel Container -->
                    <div class="overflow-hidden">
                        <div class="flex transition-transform duration-500 ease-in-out"
                            :style="`transform: translateX(-${currentSlide * 100}%)`">
                            @foreach ($topReviews->chunk(3) as $chunkIndex => $reviewChunk)
                                <div class="w-full flex-shrink-0">
                                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                                        @foreach ($reviewChunk as $topReview)
                                            <div class="bg-white p-6 rounded-xl shadow-md">
                                                <div class="flex items-center mb-4">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                                            {{ strtoupper(substr($topReview->user->first_name, 0, 1) . substr($topReview->user->last_name, 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <h4 class="text-lg font-bold">{{ $topReview->user->first_name }}
                                                            {{ $topReview->user->last_name }}</h4>
                                                        <div class="flex items-center">
                                                            @for ($i = 0; $i < 5; $i++)
                                                                <svg class="text-yellow-400 h-4 w-4" fill="currentColor"
                                                                    viewBox="0 0 20 20" aria-hidden="true">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                                </svg>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-gray-600">
                                                    {{ $topReview->review_text }}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Dots Navigation -->
                    @if ($topReviews->chunk(3)->count() > 1)
                        <div class="flex justify-center mt-8 space-x-3">
                            @foreach ($topReviews->chunk(3) as $chunkIndex => $reviewChunk)
                                <button @click="goToSlide({{ $chunkIndex }})"
                                    :class="currentSlide === {{ $chunkIndex }} ? 'bg-indigo-600 scale-110' :
                                        'bg-gray-300 hover:bg-gray-400'"
                                    class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.476L3 21l2.476-5.094A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Testimonials Available</h3>
                    <p class="text-gray-500">Check back later for customer reviews and testimonials.</p>
                </div>
            @endif
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
        // Function to update location input when a provider is selected
        function updateLocation() {
            const providerSelect = document.getElementById('provider_id');
            const selectedOption = providerSelect.options[providerSelect.selectedIndex];
            const location = selectedOption.getAttribute('data-location') || '';
            document.getElementById('location').value = location;
        }

        // Alpine.js testimonial carousel component
        function testimonialCarousel() {
            return {
                currentSlide: 0,
                totalSlides: {{ $topReviews->chunk(3)->count() }},
                autoplayInterval: null,

                init() {
                    if (this.totalSlides > 1) {
                        this.startAutoplay();
                    }

                    // Pause autoplay on hover
                    this.$el.addEventListener('mouseenter', () => this.stopAutoplay());
                    this.$el.addEventListener('mouseleave', () => this.startAutoplay());
                },

                goToSlide(slideIndex) {
                    this.currentSlide = slideIndex;
                    this.resetAutoplay();
                },

                nextSlide() {
                    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                },

                startAutoplay() {
                    if (this.totalSlides > 1) {
                        this.autoplayInterval = setInterval(() => {
                            this.nextSlide();
                        }, 4000); // Change slide every 4 seconds
                    }
                },

                stopAutoplay() {
                    if (this.autoplayInterval) {
                        clearInterval(this.autoplayInterval);
                        this.autoplayInterval = null;
                    }
                },

                resetAutoplay() {
                    this.stopAutoplay();
                    this.startAutoplay();
                }
            }
        }
    </script>
@endsection
