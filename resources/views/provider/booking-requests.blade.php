@extends('layouts.app')

@section('title', 'Booking Requests')

@section('content')
    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
        @include('navigation.sidebar')


        <!-- Main Content -->
        <div class="flex-1 p-4">
            <!-- Top Header -->
            @include('navigation.UserHeader')
            <!-- Header -->
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <h1 class="text-2xl font-bold text-gray-900">Booking Requests</h1>
                        <div class="flex items-center space-x-4">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                3 Pending Requests
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <select id="status-filter"
                        class="rounded-md border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Requests</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="declined">Declined</option>
                    </select>
                    <select id="service-filter"
                        class="rounded-md border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">All Services</option>
                        <option value="cleaning">Home Cleaning</option>
                        <option value="plumbing">Plumbing</option>
                        <option value="electrical">Electrical</option>
                    </select>
                    <input type="date" id="date-filter"
                        class="rounded-md border-gray-300 focus:ring-purple-500 focus:border-purple-500">
                </div>
            </div>

            <!-- Booking Requests List -->
            <div id="requests-container" class="space-y-6">
                <!-- Requests will be inserted here by JavaScript -->
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="text-center py-12 hidden">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No booking requests</h3>
                <p class="mt-1 text-sm text-gray-500">New booking requests will appear here.</p>
            </div>
        </div>
    </div>

    <!-- Response Modal -->
    <div id="response-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modal-title">Respond to Booking Request</h3>
                <div id="modal-content">
                    <!-- Modal content will be inserted here -->
                </div>
            </div>
        </div>
    </div>
@endsection
@vite(['resources/js/booking-requests.js']);