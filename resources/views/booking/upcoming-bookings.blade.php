@extends('layouts.app')

@section('title', 'Upcoming Bookings')

@section('content')
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
    @include('navigation.sidebar')
    

    <!-- Main Content -->
    <div class="flex-1 p-4">
        @include('navigation.UserHeader')

        <!-- Header -->
    <div class="bg-white shadow mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900">Upcoming Bookings</h1>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                        5 Upcoming
                    </span>
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                        View Calendar
                    </button>
                </div>
            </div>
        </div>
    </div>
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Today's Bookings</p>
                        <p class="text-2xl font-semibold text-gray-900">2</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">This Week's Revenue</p>
                        <p class="text-2xl font-semibold text-gray-900">$1,250</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Avg. Rating</p>
                        <p class="text-2xl font-semibold text-gray-900">4.9</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <select id="time-filter" class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="tomorrow">Tomorrow</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
                <select id="service-filter" class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Services</option>
                    <option value="cleaning">Home Cleaning</option>
                    <option value="plumbing">Plumbing</option>
                    <option value="electrical">Electrical</option>
                </select>
                <input type="text" id="search-bookings" placeholder="Search by client name..." 
                    class="rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
        </div>

        <!-- Bookings Timeline -->
        <div id="bookings-timeline" class="space-y-6">
            <!-- Bookings will be inserted here by JavaScript -->
        </div>
    </div>
</div>
@endsection
@vite(['resources/js/upcoming-bookings.js']);