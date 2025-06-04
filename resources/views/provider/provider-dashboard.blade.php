@extends('layouts.app')
<!-- In your blade layout file -->
@vite(['resources/js/bookease.js', 'resources/js/sidebar.js'])

@section('style')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Clamps to 2 lines */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Adds the '...' at the end */
        }
    </style>
@endsection
@section('content')
    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">

        @include('navigation.sidebar')
        @include('services.add-new-service')
        @include('services.edit-service')

        <!-- Main Content -->
        <div class="flex-1 p-4">
            <!-- Top Header -->
            @include('navigation.UserHeader')
            <!-- Dashboard Content -->
            <main class="p-4 md:p-6 lg:p-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Total Clients</h2>
                                <p class="text-lg font-semibold text-gray-800">{{ $totalClients }}</p>
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
                                <p class="text-lg font-semibold text-gray-800">{{ $providerCompletedBookings }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Pending Bookings</h2>
                                <p class="text-lg font-semibold text-gray-800">{{ $providerUpComingBooking }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-sm font-medium text-gray-600">Total Earnings</h2>
                                <p class="text-lg font-semibold text-gray-800">${{ $totalEarning }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Requests Section -->
                <div class="bg-white rounded-lg shadow-sm mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Recent Booking Requests</h2>
                            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View
                                All</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Client</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Service</th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time</th>
                                    <th scope="col"
                                        class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th scope="col"
                                        class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-1 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment Status</th>
                                    <th scope="col"
                                        class="px-2 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($ProviderBookings as $booking)
                                    <tr>
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-sm font-medium">
                                                    {{ strtoupper(substr($booking->provider->first_name, 0, 1) . substr($booking->provider->last_name, 0, 1)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $booking->user->first_name }} {{ $booking->user->first_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @php
                                                    $offering = $booking->service->getOfferingById(
                                                        $booking->service_offering_id,
                                                    );
                                                @endphp

                                                @if ($offering)
                                                    <p>{{ $offering['service_name'] }}</p>
                                                @endif



                                            </div>
                                            <div class="text-sm text-gray-500">{{ $booking->duration }} hours</div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $booking->start_time->format('F j, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->start_time->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-1 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ $booking->total_amount }}
                                        </td>
                                        <td class="px-2 py-4 whitespace-nowrap">
                                            @if ($booking->status == 'pending')
                                                <span
                                                    class="px-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $booking->status }}
                                                </span>
                                            @elseif($booking->status == 'canceled')
                                                <span
                                                    class="px-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    {{ $booking->status }}
                                                </span>
                                                @else
                                                <span
                                                    class="px-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $booking->status }}
                                                </span>
                                            @endif

                                        </td>
                                        <td class="px-2 py-4 whitespace-nowrap">
                                            @if ($booking->payment_status == 'pending')
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $booking->payment_status }}
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    {{ $booking->payment_status }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('booking.accept', $booking->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Accept</button>
                                            </form>
                                            
                                            <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to cancel?')">Delete</button>
                                            </form>
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <p class="text-center text-gray-500">No Booking Found!</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Services Management Section -->
                <div class="bg-white rounded-lg shadow-sm mb-8" id="my_services">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">My Services</h2>
                            <!-- Add New Service Button -->
                            <button id="openServiceModal" type="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add New Service
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Service Card 1 -->
                            @foreach ($services as $service)
                                <div class="border rounded-lg overflow-hidden shadow-sm">
                                    <div class="h-48 bg-gray-200 relative">
                                        <img src="{{ asset('storage/' . $service->service_image) }}"
                                            alt="Regular Home Cleaning" class="w-full h-full object-cover">
                                        <div class="absolute top-2 right-2">
                                            @if ($service->service_status == 1)
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $service->service_name }}
                                        </h3>
                                        <div class="flex items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-sm text-gray-600 ml-1">4.8 (24 reviews)</span>
                                        </div>
                                        <p class="line-clamp-2 text-sm text-gray-600 mb-4">
                                            {{ $service->service_description }}
                                        </p>

                                        <div class="flex justify-between items-center mb-4">
                                            <div>
                                                <span
                                                    class="text-lg font-bold text-gray-900">${{ $service->service_price }}</span>
                                                <span class="text-sm text-gray-600">/hour</span>
                                            </div>
                                            <div class="text-sm text-gray-600">
                                                <span>Duration: 1-8 hours</span>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <!-- Edit Service Button -->
                                            <button {{-- data-service-id="{{ $service->id }}"  --}} id="openEditServiceModal" type="button"
                                                class="edit-service-btn flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                Edit
                                            </button>
                                            <button
                                                class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>




                <!-- Calendar Section -->
                <div class="bg-white rounded-lg shadow-sm mb-8">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800">Upcoming Schedule</h2>
                            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View Full
                                Calendar</a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col space-y-4">
                            <!-- Today's Schedule -->

                            @php
                                use Illuminate\Support\Carbon;

                                $colorSchemes = [
                                    [
                                        'bg' => 'bg-green-50',
                                        'border' => 'border-green-100',
                                        'text' => 'text-green-600',
                                        'badgeBg' => 'bg-green-100',
                                    ],
                                    [
                                        'bg' => 'bg-purple-50',
                                        'border' => 'border-purple-100',
                                        'text' => 'text-purple-600',
                                        'badgeBg' => 'bg-purple-100',
                                    ],
                                    [
                                        'bg' => 'bg-blue-50',
                                        'border' => 'border-blue-100',
                                        'text' => 'text-blue-600',
                                        'badgeBg' => 'bg-blue-100',
                                    ],
                                    [
                                        'bg' => 'bg-indigo-50',
                                        'border' => 'border-indigo-100',
                                        'text' => 'text-indigo-600',
                                        'badgeBg' => 'bg-indigo-100',
                                    ],
                                ];

                                // Group bookings by date
                                $groupedBookings = $upcomingBookings->groupBy(function ($booking) {
                                    return $booking->start_time->toDateString();
                                });

                                $today = Carbon::today();
                            @endphp

                            <div class="space-y-6">
                                @forelse($groupedBookings as $date => $bookings)
                                    @php
                                        $dateObj = Carbon::parse($date);
                                        if ($dateObj->isToday()) {
                                            $label = 'Today – ' . $dateObj->format('F j, Y');
                                        } elseif ($dateObj->isTomorrow()) {
                                            $label = 'Tomorrow – ' . $dateObj->format('F j, Y');
                                        } elseif ($dateObj->isCurrentWeek()) {
                                            $label = 'This Week – ' . $dateObj->format('F j, Y');
                                        } elseif ($dateObj->isNextWeek()) {
                                            $label = 'Next Week – ' . $dateObj->format('F j, Y');
                                        } else {
                                            $label = $dateObj->format('F j, Y');
                                        }

                                    @endphp

                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">
                                            {{ $label }}</h3>

                                        <div class="space-y-3">
                                            @foreach ($bookings as $booking)
                                                @php
                                                    $color = $colorSchemes[array_rand($colorSchemes)];
                                                @endphp

                                                <div class="{{ $color['bg'] }} {{ $color['border'] }} rounded-lg p-4">
                                                    <div class="flex justify-between items-start">
                                                        <div>
                                                            <span
                                                                class="text-xs font-semibold {{ $color['text'] }} {{ $color['badgeBg'] }} px-2 py-1 rounded-full">
                                                                {{ $booking->start_time->format('g:i A') }} -
                                                                {{ $booking->end_time->format('g:i A') }}
                                                            </span>
                                                            <p class="text-xs px-2 py-1 text-gray-400">
                                                                {{ $booking->start_time->format('F j, Y') }}</p>
                                                            <h4 class="text-sm font-medium text-gray-900 mt-2">
                                                                {{ $booking->service->getOfferingById($booking->service_offering_id)['service_name'] ?? 'N/A' }}
                                                            </h4>

                                                            <div class="flex items-center mt-1">
                                                                <div
                                                                    class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-medium mr-2">
                                                                    {{ strtoupper(substr($booking->user->first_name, 0, 1) . substr($booking->user->last_name, 0, 1)) }}
                                                                </div>
                                                                <span class="text-sm text-gray-600">
                                                                    {{ $booking->user->first_name }}
                                                                    {{ $booking->user->last_name }}
                                                                </span>
                                                            </div>

                                                            <p class="text-sm text-gray-500 mt-1">
                                                                {{ $booking->billingInformation->address }}</p>
                                                        </div>

                                                        <div class="flex space-x-2">
                                                            <button class="text-gray-400 hover:text-gray-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274
                                                                                    4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                            </button>
                                                            <button class="text-gray-400 hover:text-gray-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0
                                                                                    00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-gray-500">No Upcoming Bookings!</p>
                                @endforelse
                            </div>


                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
