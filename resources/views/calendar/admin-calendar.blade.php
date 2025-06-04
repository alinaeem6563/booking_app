@extends('layouts.app')
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
    </style>
@endsection
@section('content')
    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
        @include('navigation.sidebar')
        <!-- Main Content -->
        <div class="flex-1 p-4">
            <!-- Top Header -->
            @include('navigation.UserHeader')
            <div class="m-2 text-end">
                <!-- Trigger button -->

                <button id="openModalBtn"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Add Time Slots
                </button>
                <!-- Trigger button -->
                <button id="openAddDayOffModalBtn"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Add Day Off
                </button>
            </div>
            <div class="max-w-4xl mx-auto mt-10 p-6 bg-white shadow rounded-lg">
                <h2 class="text-2xl font-semibold mb-6">Admin: Check Provider Slots</h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Provider Dropdown -->
                    <div>
                        <label for="provider-select" class="block text-sm font-medium text-gray-700">Provider</label>
                        <select id="provider-select" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Select Provider</option>
                        </select>
                    </div>

                    <!-- Service Dropdown -->
                    <div>
                        <label for="service-select" class="block text-sm font-medium text-gray-700">Service</label>
                        <select id="service-select" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" disabled>
                            <option value="">Select Service</option>
                        </select>
                    </div>

                    <!-- Date Picker -->
                    <div>
                        <label for="slot-date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" id="slot-date" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <!-- Search Button -->
                    <div class="flex items-end">
                        <button id="admin-search-button"
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
                            Search
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
        document.addEventListener('DOMContentLoaded', function () {
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
                });
    
            // Load services when provider is selected
            providerSelect.addEventListener('change', function () {
                const providerId = this.value;
                serviceSelect.innerHTML = '<option value="">Select Service</option>';
                serviceSelect.disabled = true;
    
                if (!providerId) return;
    
                fetch(`/provider/services/${providerId}`)
                    .then(res => res.json())
                    .then(services => {
                        services.forEach(service => {
                            const option = document.createElement('option');
                            option.value = service.id;
                            option.textContent = service.service_name;
                            serviceSelect.appendChild(option);
                        });
                        serviceSelect.disabled = false;
                    });
            });
    
            // Search button click
            document.getElementById('admin-search-button').addEventListener('click', function () {
                const serviceId = serviceSelect.value;
                const date = document.getElementById('slot-date').value;
    
                resultBox.innerHTML = ''; // Clear
    
                if (!serviceId || !date) {
                    resultBox.innerHTML =
                        `<div class="text-red-600 font-medium">Please select service and date.</div>`;
                    return;
                }
    
                // First check if it’s a day off
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
    
                        if (isDayOff) {
                            const dayOffNotice = document.createElement('div');
                            dayOffNotice.className = "text-red-600 font-semibold mb-3";
                            dayOffNotice.textContent = "This date is marked as a Day Off for the provider.";
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
                                    noSlotsMsg.className = "text-yellow-600 font-medium";
                                    noSlotsMsg.textContent = "No slots added for this date.";
                                    resultBox.appendChild(noSlotsMsg);
                                    return;
                                }
    
                                const ul = document.createElement('ul');
                                ul.className = "space-y-2";
    
                                data.forEach(slot => {
                                    const startTime = new Date(slot.start).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
                                    const endTime = new Date(slot.end).toLocaleTimeString([], {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });
    
                                    const li = document.createElement('li');
                                    li.className = `p-3 rounded shadow text-white ${slot.title === 'Booked' ? 'bg-red-500' : 'bg-green-500'}`;
                                    li.textContent = `${slot.title}: ${startTime} - ${endTime}`;
                                    ul.appendChild(li);
                                });
    
                                resultBox.appendChild(ul);
                            })
                            .catch(err => {
                                console.error(err);
                                resultBox.innerHTML =
                                    `<div class="text-red-600 font-medium">Failed to load slots.</div>`;
                            });
                    })
                    .catch(err => {
                        console.error(err);
                        resultBox.innerHTML =
                            `<div class="text-red-600 font-medium">Failed to check day off status.</div>`;
                    });
            });
        });
    </script>
    
@endsection
