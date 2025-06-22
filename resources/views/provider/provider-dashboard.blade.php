@extends('layouts.app')
@section('style')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Sidebar responsive adjustments */
        @media (min-width: 768px) {
            .sidebar-collapsed .main-content {
                margin-left: 4rem;
                /* 64px for collapsed sidebar */
            }

            .sidebar-expanded .main-content {
                margin-left: 16rem;
                /* 256px for expanded sidebar */
            }
        }
    </style>
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
        @include('services.add-new-service')
        @include('services.edit-service')

        <!-- Main Content -->
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64"
            :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">

            <!-- Top Header -->
            @include('navigation.UserHeader')

            <!-- Dashboard Content -->
            <main class="p-4 md:p-6" x-data="{ showAddModal: false }">
                <!-- Welcome Section -->
                <div class="mb-6">
                    <div
                        class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 rounded-xl p-6 md:p-8 text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10"></div>
                        <div
                            class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white opacity-5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 w-24 h-24 md:w-48 md:h-48 bg-white opacity-5 rounded-full -ml-12 md:-ml-24 -mb-12 md:-mb-24">
                        </div>
                        <div class="relative z-10">
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">
                                Welcome back, {{ Auth::user()->first_name }}! 👋
                            </h1>
                            <p class="text-indigo-100 text-sm md:text-lg">Here's what's happening with your services today.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-6">
                    <!-- Total Clients Card -->
                    <div
                        class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-4 md:p-6 border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Total Clients</p>
                                <p class="text-xl md:text-3xl font-bold text-gray-900 mb-2">{{ $totalClients }}</p>
                                <div class="flex items-center text-xs md:text-sm">
                                    <span class="text-green-600 font-medium">+12%</span>
                                    <span class="text-gray-500 ml-1 hidden sm:inline">vs last month</span>
                                </div>
                            </div>
                            <div
                                class="p-3 md:p-4 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                <svg class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Bookings Card -->
                    <div
                        class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-4 md:p-6 border border-gray-100 hover:border-green-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Completed</p>
                                <p class="text-xl md:text-3xl font-bold text-gray-900 mb-2">{{ $providerCompletedBookings }}
                                </p>
                                <div class="flex items-center text-xs md:text-sm">
                                    <span class="text-green-600 font-medium">+8%</span>
                                    <span class="text-gray-500 ml-1 hidden sm:inline">vs last month</span>
                                </div>
                            </div>
                            <div
                                class="p-3 md:p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-xl group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                <svg class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Bookings Card -->
                    <div
                        class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-4 md:p-6 border border-gray-100 hover:border-yellow-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Pending</p>
                                <p class="text-xl md:text-3xl font-bold text-gray-900 mb-2">{{ $providerUpComingBooking }}
                                </p>
                                <div class="flex items-center text-xs md:text-sm">
                                    <span class="text-yellow-600 font-medium">Attention</span>
                                </div>
                            </div>
                            <div
                                class="p-3 md:p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                <svg class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Earnings Card -->
                    <div
                        class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 p-4 md:p-6 border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs md:text-sm font-medium text-gray-600 mb-1">Earnings</p>
                                <p class="text-xl md:text-3xl font-bold text-gray-900 mb-2">
                                    ${{ number_format($totalEarning, 2) }}</p>
                                <div class="flex items-center text-xs md:text-sm">
                                    <span class="text-green-600 font-medium">+15%</span>
                                    <span class="text-gray-500 ml-1 hidden sm:inline">vs last month</span>
                                </div>
                            </div>
                            <div
                                class="p-3 md:p-4 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                <svg class="h-6 w-6 md:h-8 md:w-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Charts and Filters -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Earnings Chart -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Earnings Overview</h3>
                            <select id="chart-period" class="rounded-md border-gray-300 text-sm">
                                <option value="7">Last 7 days</option>
                                <option value="30">Last 30 days</option>
                                <option value="90">Last 3 months</option>
                                <option value="365">Last year</option>
                            </select>
                        </div>
                        <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                            <canvas id="earnings-chart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    


                    <!-- Service Breakdown -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Earnings by Service</h3>
                        <div class="space-y-4">
                            @forelse($earningsByService as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-{{ $item['color'] }}-500 rounded-full mr-3"></div>
                                        <span class="text-sm text-gray-700">{{ $item['name'] }}</span>
                                    </div>
                                    <span
                                        class="text-sm font-medium text-gray-900">${{ number_format($item['total'], 2) }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No earnings yet.</p>
                            @endforelse
                        </div>
                    </div>

                </div>
                <!-- Enhanced Booking Requests Section -->
                <div class="bg-white rounded-xl shadow-sm mb-6 border border-gray-100">
                    <div class="px-4 md:px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-2 sm:mb-0">Recent Booking Requests
                            </h2>
                            <button
                                class="inline-flex items-center px-3 md:px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span class="hidden sm:inline">View All</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Cards View -->
                    <div class="block lg:hidden p-4 md:p-6 space-y-4">
                        @forelse ($providerAllBookings as $booking)
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div
                                        class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($booking->user->first_name, 0, 1) . substr($booking->user->last_name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 text-sm md:text-base truncate">
                                            {{ $booking->user->first_name }} {{ $booking->user->last_name }}
                                        </h3>
                                        <p class="text-xs md:text-sm text-gray-500 truncate">{{ $booking->user->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    @php
                                        $offering = $booking->service->getOfferingById($booking->service_offering_id);
                                    @endphp
                                    <p class="text-sm font-medium text-gray-900">{{ $offering['service_name'] ?? 'N/A' }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $booking->start_time->format('M j, Y g:i A') }} •
                                        {{ $booking->duration }} hours</p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2 md:space-x-4">
                                        <span
                                            class="text-base md:text-lg font-bold text-gray-900">${{ number_format($booking->total_amount, 2) }}</span>
                                        @if ($booking->status == 'pending')
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                        @elseif($booking->status == 'canceled')
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Canceled</span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <form action="{{ route('booking.accept', $booking->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="text-green-600 hover:text-green-800 text-xs md:text-sm font-medium">Accept</button>
                                        </form>
                                        <button type="button" onclick="confirmCancel({{ $booking->id }})"
                                            class="text-red-600 hover:text-red-800 text-xs md:text-sm font-medium">Cancel</button>
                                        <form id="cancel-booking-form-{{ $booking->id }}"
                                            action="{{ route('booking.cancel', $booking->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500">No booking requests found!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Client</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Service</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Date & Time</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Price</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Payment</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($providerAllBookings as $booking)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm">
                                                    {{ strtoupper(substr($booking->user->first_name, 0, 1) . substr($booking->user->last_name, 0, 1)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $booking->user->first_name }} {{ $booking->user->last_name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $booking->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $offering = $booking->service->getOfferingById(
                                                    $booking->service_offering_id,
                                                );
                                            @endphp
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $offering['service_name'] ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->duration }} hours</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $booking->start_time->format('M j, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->start_time->format('g:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-lg font-bold text-gray-900">
                                                ${{ number_format($booking->total_amount, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($booking->status == 'pending')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($booking->status == 'canceled')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Canceled</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ ucfirst($booking->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($booking->payment_status == 'pending')
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('booking.accept', $booking->id) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-green-600 hover:text-green-900 mr-4 font-medium">Accept</button>
                                            </form>
                                            <button type="button" onclick="confirmCancel({{ $booking->id }})"
                                                class="text-red-600 hover:text-red-900 font-medium">Cancel</button>
                                            <form id="cancel-booking-form-{{ $booking->id }}"
                                                action="{{ route('booking.cancel', $booking->id) }}" method="POST"
                                                class="hidden">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <p class="text-gray-500">No booking requests found!</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Enhanced Services Management Section -->
                <div class="bg-white rounded-xl shadow-sm mb-6 border border-gray-100" id="my_services">
                    <div class="px-4 md:px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-4 sm:mb-0">My Services</h2>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                <button
                                    class="inline-flex items-center px-3 md:px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="hidden sm:inline">View All</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 md:p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6">
                            @foreach ($services as $service)
                                <div
                                    class="group bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                    <div class="relative h-40 md:h-48 bg-gradient-to-br from-gray-200 to-gray-300">
                                        <img src="{{ asset('storage/' . $service->service_image) }}"
                                            alt="{{ $service->service_name }}" class="w-full h-full object-cover">
                                        <div class="absolute top-3 right-3">
                                            @if ($service->service_status == 1)
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="p-4 md:p-6">
                                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2 line-clamp-1">
                                            {{ $service->service_name }}</h3>

                                        <div class="flex items-center mb-3">
                                            <div class="flex items-center">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-3 h-3 md:w-4 md:h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                        </path>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-xs md:text-sm text-gray-600 ml-2">4.8 (24)</span>
                                        </div>

                                        <p class="line-clamp-2 text-xs md:text-sm text-gray-600 mb-4">
                                            {{ $service->service_description }}</p>

                                        <div class="flex justify-between items-center mb-4">
                                            <div>
                                                <span
                                                    class="text-lg md:text-2xl font-bold text-gray-900">${{ number_format($service->service_price, 2) }}</span>
                                                <span class="text-xs md:text-sm text-gray-600">/hour</span>
                                            </div>
                                            <div class="text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded-full">
                                                1-8 hours
                                            </div>
                                        </div>


                                        <!-- Actions -->
                                        <div class="flex space-x-2">
                                            <button @click="openEditServiceModal({{ $service->id }})" type="button"
                                                class="edit-service-btn flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-xs md:text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1 md:mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Enhanced Calendar Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="px-4 md:px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-2 sm:mb-0">Upcoming Schedule</h2>
                            <a href="{{ route('calendar.create') }}"
                                class="inline-flex items-center px-3 md:px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors duration-200">
                                <span class="hidden sm:inline">View Full Calendar</span>
                                <span class="sm:hidden">Calendar</span>
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="p-4 md:p-6">
                        @php
                            use Illuminate\Support\Carbon;
                            $colorSchemes = [
                                ['bg' => 'bg-gradient-to-br from-green-400 to-green-600', 'text' => 'text-green-700'],
                                [
                                    'bg' => 'bg-gradient-to-br from-purple-400 to-purple-600',
                                    'text' => 'text-purple-700',
                                ],
                                ['bg' => 'bg-gradient-to-br from-blue-400 to-blue-600', 'text' => 'text-blue-700'],
                                [
                                    'bg' => 'bg-gradient-to-br from-indigo-400 to-indigo-600',
                                    'text' => 'text-indigo-700',
                                ],
                            ];
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
                                    <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-4">{{ $label }}
                                    </h3>

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                        @foreach ($bookings as $booking)
                                            @php
                                                $color = $colorSchemes[array_rand($colorSchemes)];
                                            @endphp
                                            <div
                                                class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors duration-200">
                                                <div class="flex justify-between items-start mb-3">
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center mb-2 space-x-2">
                                                            <span
                                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                                {{ $booking->start_time->format('g:i A') }} -
                                                                {{ $booking->end_time->format('g:i A') }}
                                                            </span>
                                                            <span
                                                                class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full">
                                                                {{ $booking->duration }}h
                                                            </span>
                                                        </div>

                                                        <h4
                                                            class="text-sm md:text-lg font-semibold text-gray-900 mb-2 line-clamp-1">
                                                            {{ $booking->service->getOfferingById($booking->service_offering_id)['service_name'] ?? 'N/A' }}
                                                        </h4>

                                                        <div class="flex items-center mb-2">
                                                            <div
                                                                class="w-6 h-6 md:w-8 md:h-8 {{ $color['bg'] }} rounded-lg flex items-center justify-center text-white text-xs font-bold mr-2 md:mr-3 flex-shrink-0">
                                                                {{ strtoupper(substr($booking->user->first_name, 0, 1) . substr($booking->user->last_name, 0, 1)) }}
                                                            </div>
                                                            <div class="min-w-0 flex-1">
                                                                <p
                                                                    class="text-xs md:text-sm font-medium text-gray-900 truncate">
                                                                    {{ $booking->user->first_name }}
                                                                    {{ $booking->user->last_name }}
                                                                </p>
                                                                <p class="text-xs text-gray-600 truncate">
                                                                    {{ $booking->user->email }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center text-xs md:text-sm text-gray-600">
                                                            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1 md:mr-2 flex-shrink-0"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                                </path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                                                                </path>
                                                            </svg>
                                                            <span
                                                                class="truncate">{{ $booking->billingInformation->address ?? 'Address not provided' }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="text-right flex-shrink-0 ml-4">
                                                        <div class="text-sm md:text-lg font-bold text-gray-900">
                                                            ${{ number_format($booking->total_amount, 2) }}</div>
                                                        <div class="text-xs text-gray-500">Total</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <h3 class="text-lg md:text-xl font-medium text-gray-900 mb-2">No upcoming bookings
                                        </h3>
                                        <p class="text-gray-500 mb-6 text-sm md:text-base">You don't have any scheduled
                                            appointments at the moment.</p>
                                        <button id="openServiceModal" type="button"
                                            class="inline-flex items-center px-4 md:px-6 py-2 md:py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors duration-200">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add New Service
                                        </button>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function confirmCancel(bookingId) {
            Swal.fire({
                title: 'Cancel Booking?',
                text: "This action cannot be undone. The booking will be cancelled and the client will be notified.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, cancel booking',
                cancelButtonText: 'Keep booking',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-3',
                    cancelButton: 'rounded-xl px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancel-booking-form-' + bookingId).submit();

                    Swal.fire({
                        title: 'Booking Cancelled',
                        text: 'The booking has been successfully cancelled.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    });
                }
            });
        }
    </script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const rawData = @json($revenueChartDataForProvider);
        let chartInstance;

        function renderChart(data) {
            const ctx = document.getElementById("earnings-chart").getContext("2d");

            const labels = data.map(item => item.date);
            const totals = data.map(item => item.total);

            if (chartInstance) chartInstance.destroy();

            chartInstance = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Total Earnings",
                        data: totals,
                        borderColor: "rgba(99,102,241,1)",
                        backgroundColor: "rgba(99,102,241,0.1)",
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => '$' + value
                            }
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: context => '$' + context.formattedValue
                            }
                        }
                    }
                }
            });
        }

        renderChart(rawData); // initial chart

        // Optional: if you're dynamically updating chart data
        document.getElementById('chart-period').addEventListener('change', function () {
            const days = this.value;

            fetch(`/provider/revenue-chart-data?days=${days}`)
                .then(res => res.json())
                .then(data => renderChart(data))
                .catch(err => console.error('Chart update failed:', err));
        });
    });
</script>
