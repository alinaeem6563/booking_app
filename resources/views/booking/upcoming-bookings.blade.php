@extends('layouts.app')

@section('title', 'Upcoming Bookings')
<meta name="csrf-token" content="{{ csrf_token() }}">

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
             @include('booking.reschedule-modal')
            <!-- Header -->
            <div class=" rounded-t-lg bg-gradient-to-r from-indigo-500 to-purple-600  text-white shadow mt-4 mx-2">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h1 class="text-2xl font-bold text-white">Upcoming Bookings</h1>
                        <div class="flex items-center space-x-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                                {{ count($bookingUpcoming) }} Upcoming
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-b-lg  shadow-sm p-6 mb-6 mx-2">
                <div class="flex flex-col sm:flex-row gap-4">
                    <select id="time-filter"
                        class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="all">All Time</option>
                        <option value="today">Today</option>
                        <option value="tomorrow">Tomorrow</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                    <select id="service-filter"
                        class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Services</option>
                        @foreach ($upcomingBookings->pluck('category')->unique() as $category)
                            @if ($category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="text" id="search-bookings" placeholder="Search by name..."
                        class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <!-- Bookings Timeline -->
            <div id="bookings-timeline" class="space-y-6 mx-2 ">
                <!-- Bookings will be inserted here by JavaScript -->
            </div>
        </div>
    </div>
@endsection
<script>
    const upcomingBookings = @json($upcomingBookings);
    const accountType = @json(auth()->user()->account_type);

    
</script>
@vite(['resources/js/upcoming-bookings.js']);
