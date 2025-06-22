@extends('layouts.app')

@section('title', 'Admin Calendar Management')

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
                                     Admin Calendar Management
                                </h1>
                                <p class="text-indigo-100 text-sm md:text-lg">Monitor and manage provider schedules and
                                    availability</p>
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

            <!-- Provider Slot Checker Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                             Check Provider Time Slots
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Search and view provider availability for specific dates and
                            services</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Provider Dropdown -->
                    <div>
                        <label for="provider-select" class="block text-sm font-medium text-gray-700 mb-2">
                             Select Provider
                        </label>
                        <select id="provider-select"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                            <option value="">-- Select Provider --</option>
                        </select>
                    </div>

                    <!-- Service Dropdown -->
                    <div>
                        <label for="service-select" class="block text-sm font-medium text-gray-700 mb-2">
                             Select Service
                        </label>
                        <select id="service-select"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                            disabled>
                            <option value="">-- Select Service --</option>
                        </select>
                    </div>

                    <!-- Date Picker -->
                    <div>
                        <label for="slot-date" class="block text-sm font-medium text-gray-700 mb-2">
                             Select Date
                        </label>
                        <input type="date" id="slot-date"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                    </div>

                    <!-- Search Button -->
                    <div class="flex items-end">
                        <button id="admin-search-button"
                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-indigo-600  text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                             Search Slots
                        </button>
                    </div>
                </div>

                <!-- Results -->
                <div id="admin-slot-results" class="mt-6"></div>
            </div>

            <!-- Modal Add Time Slots -->
            @include('calendar.admin-add-time-slot-modal')

            <!-- Modal Add Day Off-->
            @include('calendar.admin-add-day-off-modal')
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const providerSelect = document.getElementById('provider-select');
            const serviceSelect = document.getElementById('service-select');
            const resultBox = document.getElementById('admin-slot-results');

            // Load all providers
            fetch('/admin/providers')
                .then(res => res.json())
                .then(providers => {
                    providers.forEach(provider => {
                        const option = document.createElement('option');
                        option.value = provider.id;
                        option.textContent = provider.name;
                        providerSelect.appendChild(option);
                    });
                })
                .catch(err => {
                    console.error('Failed to load providers:', err);
                    resultBox.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-800 font-medium"> Failed to load providers.</span>
                            </div>
                        </div>
                    `;
                });

            // Load services when provider is selected
            providerSelect.addEventListener('change', function() {
                const providerId = this.value;
                serviceSelect.innerHTML = '<option value="">-- Select Service --</option>';
                serviceSelect.disabled = true;
                resultBox.innerHTML = ''; // Clear previous results

                if (!providerId) return;

                // Show loading state
                serviceSelect.innerHTML = '<option value="">Loading services...</option>';

                fetch(`/provider/services/${providerId}`)
                    .then(res => res.json())
                    .then(services => {
                        serviceSelect.innerHTML = '<option value="">-- Select Service --</option>';
                        services.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service.id;
                            option.textContent = service.service_name;
                            serviceSelect.appendChild(option);
                        });
                        serviceSelect.disabled = false;
                    })
                    .catch(err => {
                        console.error('Failed to load services:', err);
                        serviceSelect.innerHTML = '<option value="">Failed to load services</option>';
                    });
            });

            // Search button click
            document.getElementById('admin-search-button').addEventListener('click', function() {
                const serviceId = serviceSelect.value;
                const date = document.getElementById('slot-date').value;
                const providerName = providerSelect.options[providerSelect.selectedIndex].text;
                const serviceName = serviceSelect.options[serviceSelect.selectedIndex].text;

                resultBox.innerHTML = ''; // Clear previous results

                if (!serviceId || !date) {
                    resultBox.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-800 font-medium"> Please select provider, service, and date.</span>
                            </div>
                        </div>
                    `;
                    return;
                }

                // Show loading state
                resultBox.innerHTML = `
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <svg class="animate-spin w-5 h-5 text-indigo-500 mr-3" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-indigo-800 font-medium"> Searching slots...</span>
                        </div>
                    </div>
                `;

                // First check if it's a day off
                fetch(`/calendar/daysoff?service_id=${serviceId}`)
                    .then(res => res.json())
                    .then(dayOffs => {
                        const selectedDate = new Date(date);
                        const dayIndex = selectedDate.getDay(); // 0 (Sun) to 6 (Sat)
                        const formattedDate = selectedDate.toISOString().split('T')[0];

                        const isDayOff = dayOffs.some(off => {
                            if (off.daysOfWeek && off.daysOfWeek.includes(dayIndex)) {
                                return true;
                            }
                            if (off.start && off.end) {
                                const startDate = new Date(off.start);
                                const endDate = new Date(off.end);
                                return selectedDate >= startDate && selectedDate < endDate;
                            }
                            return false;
                        });

                        // Clear loading state
                        resultBox.innerHTML = '';

                        // Add search summary
                        const summaryDiv = document.createElement('div');
                        summaryDiv.className = 'bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4';
                        summaryDiv.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-gray-900"> Search Results</h3>
                                    <p class="text-sm text-gray-600">Provider: <span class="font-medium">${providerName}</span> | Service: <span class="font-medium">${serviceName}</span> | Date: <span class="font-medium">${new Date(date).toLocaleDateString()}</span></p>
                                </div>
                            </div>
                        `;
                        resultBox.appendChild(summaryDiv);

                        if (isDayOff) {
                            const dayOffNotice = document.createElement('div');
                            dayOffNotice.className =
                                'bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4';
                            dayOffNotice.innerHTML = `
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <span class="text-yellow-800 font-medium"> This date is marked as a Day Off for the provider.</span>
                                </div>
                            `;
                            resultBox.appendChild(dayOffNotice);
                        }

                        // Now fetch slots even if it's a day off (for admin visibility)
                        const start = `${date}T00:00:00`;
                        const end = `${date}T23:59:59`;

                        fetch(`/calendar/slots?service_id=${serviceId}&start=${start}&end=${end}`)
                            .then(res => res.json())
                            .then(data => {
                                if (!data.length) {
                                    const noSlotsMsg = document.createElement('div');
                                    noSlotsMsg.className =
                                        'bg-gray-50 border border-gray-200 rounded-lg p-8 text-center';
                                    noSlotsMsg.innerHTML = `
                                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Time Slots Available</h3>
                                        <p class="text-gray-600">No slots have been added for this date.</p>
                                    `;
                                    resultBox.appendChild(noSlotsMsg);
                                    return;
                                }

                                const slotsContainer = document.createElement('div');
                                slotsContainer.innerHTML = `
                                    <h3 class="text-lg font-medium text-gray-900 mb-4"> Available Time Slots</h3>
                                `;

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

                                slotsContainer.appendChild(ul);
                                resultBox.appendChild(slotsContainer);
                            })
                            .catch(err => {
                                console.error('Failed to load slots:', err);
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
                        console.error('Failed to check day off status:', err);
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
@endsection
@vite('resources/js/admin-calendar.js')