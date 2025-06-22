@extends('layouts.app')

@section('title', 'Time Slots Management')

<!-- FullCalendar CSS -->
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/main.min.css" rel="stylesheet">
    <style>
        .fc .booked-slot {
            cursor: not-allowed;
        }

        .fc .available-slot {
            cursor: pointer;
        }

        /* Custom FullCalendar styling */
        .fc-theme-standard .fc-scrollgrid {
            border-radius: 12px;
            overflow: hidden;
        }

        .fc-theme-standard th {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            color: white;
            font-weight: 600;
        }

        .fc-event {
            border-radius: 8px;
            border: none;
            font-weight: 500;
        }

        .fc-event.available-slot {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .fc-event.booked-slot {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        >

        /* Custom scrollbar for table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(to right, #6366f1, #8b5cf6);
            border-radius: 3px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
        }

        /* Smooth transitions for hover effects */
        .group:hover .group-hover\:shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Mobile touch improvements */
        @media (max-width: 1024px) {
            .delete-day-off-btn {
                min-width: 44px;
                min-height: 44px;
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
        <!-- Main Content -->
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64"
            :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">
            <!-- Top Header -->
            @include('navigation.UserHeader')

            <!-- Enhanced Header with Gradient -->
            <div class="mb-6">
                <div
                    class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 md:p-8 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div
                        class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white opacity-5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-24 h-24 md:w-48 md:h-48 bg-white opacity-5 rounded-full -ml-12 md:-ml-24 -mb-12 md:-mb-24">
                    </div>
                    <div class="relative z-10">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                            <div>
                                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">
                                    Time Slots Management
                                </h1>
                                <p class="text-indigo-100 text-sm md:text-lg">Manage your availability and schedule</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button id="openModalBtn"
                                    class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-lg hover:bg-white/30 transition-all duration-200 border border-white/30">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Time Slots
                                </button>

                                <button id="openAddDayOffModalBtn"
                                    class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-lg hover:bg-white/30 transition-all duration-200 border border-white/30">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728">
                                        </path>
                                    </svg>
                                    Add Day Off
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time Slot Checker Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                            Check Available Time Slots
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Search and view your availability for specific dates</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Service Dropdown -->
                    <div>
                        <label for="main-service" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Service
                        </label>
                        <select id="main-service"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                            <option value="">-- Select --</option>
                        </select>
                    </div>

                    <!-- Date Picker -->
                    <div>
                        <label for="selected-date" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Date
                        </label>
                        <input type="date" id="selected-date"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                    </div>

                    <!-- Search Button -->
                    <div class="flex items-end">
                        <button id="search-button"
                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search Slots
                        </button>
                    </div>
                </div>

               
                <!-- Responsive Day Off Table -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 overflow-hidden">
                    <!-- Table Header -->
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                            </svg>
                            Days Off Schedule
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Manage your unavailable days and dates</p>
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                            </svg>
                                            OffDay By Day
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-purple-600"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                            </svg>
                                            OffDay By Date
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($providerDayOff as $dayOff)
                                    <tr
                                        class="hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 transition-all duration-200 group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                                                    <span class="text-sm font-semibold text-indigo-700">
                                                        {{ strtoupper(substr($dayOff->day_name, 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $dayOff->day_name }}</div>
                                                    <div class="text-xs text-gray-500">Weekly off day</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($dayOff->off_date === 'NULL' || empty($dayOff->off_date))
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                    No specific date
                                                </span>
                                            @else
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 mr-2 text-purple-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                                    </svg>
                                                    <span
                                                        class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($dayOff->off_date)->format('M d, Y') }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form id="cancel-booking-form-{{ $dayOff->id }}"
                                                action="{{ route('dayoffs.destroy', $dayOff->id) }}"
                                                method="POST">
                                              @csrf
                                              @method('DELETE')
                                                <button type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-red-200 text-sm font-medium rounded-lg text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 delete-day-off-btn group-hover:shadow-md"
                                                    data-id="{{ $dayOff->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-12 w-12 text-gray-400 mb-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                                </svg>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No days off scheduled
                                                </h3>
                                                <p class="text-gray-500 text-sm">You haven't set any days off yet. Add some
                                                    to manage your availability.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="lg:hidden">
                        @forelse ($providerDayOff as $dayOff)
                            <div class="border-b border-gray-100 last:border-b-0">
                                <div
                                    class="p-4 hover:bg-gradient-to-r hover:from-indigo-50/50 hover:to-purple-50/50 transition-all duration-200">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <!-- Day Name -->
                                            <div class="flex items-center mb-3">
                                                <div
                                                    class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                                    <span class="text-sm font-bold text-indigo-700">
                                                        {{ strtoupper(substr($dayOff->day_name, 0, 2)) }}
                                                    </span>
                                                </div>
                                                <div class="ml-3">
                                                    <h3 class="text-base font-semibold text-gray-900">
                                                        {{ $dayOff->day_name }}</h3>
                                                    <p class="text-sm text-gray-500">Weekly off day</p>
                                                </div>
                                            </div>

                                            <!-- Date Information -->
                                            <div class="mb-3">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 mr-2 text-purple-600" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-700">Specific Date:</span>
                                                </div>
                                                <div class="mt-1 ml-6">
                                                    @if ($dayOff->off_date === 'NULL' || empty($dayOff->off_date))
                                                        <span
                                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                                            <svg class="w-3 h-3 mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M20 12H4"></path>
                                                            </svg>
                                                            No specific date set
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                                            </svg>
                                                            {{ \Carbon\Carbon::parse($dayOff->off_date)->format('M d, Y') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Button -->
                                        <div class="flex-shrink-0 ml-4">
                                            <form id="cancel-booking-form-{{ $dayOff->id }}"
                                                action="{{ route('dayoffs.destroy', $dayOff->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="inline-flex items-center p-2 border border-red-200 rounded-lg text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 delete-day-off-btn"
                                                    data-id="{{ $dayOff->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                    <span class="sr-only">Remove day off</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-16 h-16 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No days off scheduled</h3>
                                    <p class="text-gray-600 text-sm text-center max-w-sm">You haven't set any days off yet.
                                        Add some to manage your availability and let clients know when you're unavailable.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

 <!-- Results -->

                <div id="slots-result" class="mt-6"></div>
            </div>

            <!-- Modal Add Time Slots -->
            @include('calendar.provider-add-time-slot-modal')

            <!-- Modal Add Day Off-->
            @include('calendar.provider-add-day-off-modal')
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const providerId = '{{ auth()->id() }}'; // Blade injection

            // Load services for the provider
            fetch(`/provider/services/${providerId}`)
                .then(res => res.json())
                .then(services => {
                    const select = document.getElementById('main-service');
                    select.innerHTML = '<option value="">-- Select --</option>';
                    services.forEach(service => {
                        const option = document.createElement('option');
                        option.value = service.id;
                        option.textContent = service.service_name;
                        select.appendChild(option);
                    });
                });

            document.getElementById('search-button').addEventListener('click', function() {
                const serviceId = document.getElementById('main-service').value;
                const date = document.getElementById('selected-date').value;
                const resultBox = document.getElementById('slots-result');

                resultBox.innerHTML = ''; // Clear previous

                if (!serviceId || !date) {
                    resultBox.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-800 font-medium"> Please select both service and date.</span>
                            </div>
                        </div>
                    `;
                    return;
                }

                // Check if selected date is a day off
                fetch(`/calendar/daysoff?service_id=${serviceId}`)
                    .then(res => res.json())
                    .then(dayOffs => {
                        let isDayOff = false;

                        const selectedDate = new Date(date);
                        const selectedDayIndex = selectedDate.getDay(); // 0 = Sunday

                        dayOffs.forEach(off => {
                            if (off.daysOfWeek && off.daysOfWeek.includes(selectedDayIndex)) {
                                isDayOff = true;
                            } else if (off.start) {
                                const offDate = new Date(off.start).toISOString().split('T')[0];
                                if (offDate === date) {
                                    isDayOff = true;
                                }
                            }
                        });

                        if (isDayOff) {
                            const dayOffMessage = document.createElement('div');
                            dayOffMessage.className =
                                'bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4';
                            dayOffMessage.innerHTML = `
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="text-yellow-800 font-medium"> This is a day off.</span>
                                </div>
                            `;
                            resultBox.appendChild(dayOffMessage);
                        }

                        // Now fetch slots
                        const start = `${date}T00:00:00`;
                        const end = `${date}T23:59:59`;

                        fetch(`/calendar/slots?service_id=${serviceId}&start=${start}&end=${end}`)
                            .then(res => res.json())
                            .then(data => {
                                if (!data.length) {
                                    const msg = document.createElement('div');
                                    msg.className =
                                        'bg-gray-50 border border-gray-200 rounded-lg p-8 text-center';
                                    msg.innerHTML = `
                                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Time Slots Available</h3>
                                        <p class="text-gray-600">No slots added for this date.</p>
                                    `;
                                    resultBox.appendChild(msg);
                                    return;
                                }

                                const ul = document.createElement('ul');
                                ul.className = "space-y-3";

                                data.forEach(slot => {
                                    const startTime = new Date(slot.start)
                                        .toLocaleTimeString([], {
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        });
                                    const endTime = new Date(slot.end).toLocaleTimeString(
                                        [], {
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        });
                                    const li = document.createElement('li');

                                    if (slot.title === 'Booked') {
                                        li.className =
                                            'bg-red-50 border border-red-200 rounded-lg p-4';
                                        li.innerHTML = `
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="font-medium text-gray-900"> ${startTime} - ${endTime}</span>
                                                </div>
                                                <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full"> Booked</span>
                                            </div>
                                        `;
                                    } else {
                                        li.className =
                                            'bg-green-50 border border-green-200 rounded-lg p-4';
                                        li.innerHTML = `
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="font-medium text-gray-900"> ${startTime} - ${endTime}</span>
                                                </div>
                                                <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full"> Available</span>
                                            </div>
                                        `;
                                    }
                                    ul.appendChild(li);
                                });

                                resultBox.appendChild(ul);
                            })
                            .catch(err => {
                                console.error(err);
                                resultBox.innerHTML = `
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-red-800 font-medium"> Failed to load slots.</span>
                                        </div>
                                    </div>
                                `;
                            });
                    })
                    .catch(err => {
                        console.error(err);
                        resultBox.innerHTML = `
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-red-800 font-medium"> Failed to check day off status.</span>
                                </div>
                            </div>
                        `;
                    });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle delete day off buttons
            document.querySelectorAll('.delete-day-off-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const dayOffId = this.getAttribute('data-id');
                    const form = document.getElementById(`cancel-booking-form-${dayOffId}`);

                    // Enhanced SweetAlert with modern styling
                    Swal.fire({
                        title: 'Remove Day Off?',
                        text: 'Are you sure you want to remove this day off? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, remove it',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            popup: 'rounded-2xl',
                            confirmButton: 'rounded-lg px-4 py-2',
                            cancelButton: 'rounded-lg px-4 py-2'
                        },
                        buttonsStyling: true,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Removing...',
                                text: 'Please wait while we remove the day off.',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'rounded-2xl'
                                },
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit the form
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>


@endsection
