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
            <div class="max-w-3xl mx-auto mt-10 p-4 bg-white shadow rounded-lg">
                <h2 class="text-2xl font-semibold mb-4">Check Available Time Slots</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Service Dropdown -->
                    <div>
                        <label for="main-service" class="block text-sm font-medium text-gray-700">Select Service</label>
                        <select id="main-service"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500  focus:border-indigo-500 ">
                            <option value="">-- Select --</option>
                        </select>
                    </div>

                    <!-- Date Picker -->
                    <div>
                        <label for="selected-date" class="block text-sm font-medium text-gray-700">Select Date</label>
                        <input type="date" id="selected-date"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500  focus:border-indigo-500 ">
                    </div>

                    <!-- Search Button -->
                    <div class="flex items-end">
                        <button id="search-button"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Search Slots
                        </button>
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
                    resultBox.innerHTML =
                        `<div class="text-red-600 font-medium">Please select both service and date.</div>`;
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
                            dayOffMessage.className = 'text-yellow-600 font-medium mb-2';
                            dayOffMessage.textContent = 'This is a day off.';
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
                                    msg.className = 'text-gray-600 font-medium';
                                    msg.textContent = 'No slots added for this date.';
                                    resultBox.appendChild(msg);
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
                                    li.className =
                                        `p-3 rounded shadow text-white ${slot.title === 'Booked' ? 'bg-red-500' : 'bg-green-500'}`;
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
