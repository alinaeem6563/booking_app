@extends('layouts.app')

@section('title', 'Booking Requests')

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
            

            <!-- Main Content Area -->
            <main class="p-4 md:p-6">
                <!-- Enhanced Header with Gradient -->
                <div class="mb-6">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 md:p-8 text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10"></div>
                        <div class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white opacity-5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 md:w-48 md:h-48 bg-white opacity-5 rounded-full -ml-12 md:-ml-24 -mb-12 md:-mb-24"></div>
                        <div class="relative z-10">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                                <div>
                                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">
                                         Booking Requests
                                    </h1>
                                    <p class="text-indigo-100 text-sm md:text-lg">Manage your incoming service requests</p>
                                </div>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                                    <!-- Quick Stats -->
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold">{{$bookingsTotal}}</div>
                                                <div class="text-xs text-indigo-100">Total</div>
                                            </div>
                                        </div>
                                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold text-yellow-300">{{$bookingsPending}}</div>
                                                <div class="text-xs text-indigo-100">Pending</div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Status Badge -->
                                    <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-400/20 text-yellow-100 border border-yellow-400/30">
                                        <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></span>
                                       {{$bookingsPending}} Pending Requests
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Filters Section -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                             Filters & Search
                        </h3>
                        <button id="clear-filters" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                            Clear All
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>
                            <select id="status-filter" 
                                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                <option value="">All Requests</option>
                                <option value="pending">Pending</option>
                                <option value="accepted"> Accepted</option>
                                <option value="declined" >Declined</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>

                        <!-- Service Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Service Type
                            </label>
                            <select id="service-filter" 
                                    class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                <option value="">All Services</option>
                                @foreach ($categories as $category)
                                    
                                <option value="{{$category->category_name}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                 Date
                            </label>
                            <input type="date" id="date-filter" 
                                   class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                        </div>

                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                 Search
                            </label>
                            <div class="relative">
                                <input type="text" id="search-requests" 
                                       placeholder="Search requests..." 
                                       class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
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
<script>
    window.bookingRequests = @json($bookingRequests);
</script>

@vite(['resources/js/booking-requests.js']);

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
