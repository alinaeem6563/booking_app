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
            <div id='calendar'></div>

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
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                 timeZone: 'local',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                slotMinTime: "08:00:00",
                slotMaxTime: "18:00:00",
                allDaySlot: false,
                height: 'auto',

                eventSources: [
                    {
                        url: '/calendar/daysoff',
                        display: 'background'
                    },
                    {
                        url: '/calendar/slots'
                    }
                ],

                selectOverlap: function (event) {
                    return event.display !== 'background';
                },

                eventDidMount: function (info) {
                    if (info.event.title === "Booked") {
                        info.el.style.pointerEvents = 'none';
                        info.el.style.opacity = '0.6';
                    }
                },

                eventClick: function (info) {
                    if (info.event.title === "Available") {
                        alert(`Book slot:\n${info.event.start.toLocaleTimeString()} - ${info.event.end.toLocaleTimeString()}`);
                    }
                }
            });

            calendar.render();
        });
    </script>


   
@endsection
