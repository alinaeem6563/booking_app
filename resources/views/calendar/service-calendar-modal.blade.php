<!-- Service Calendar Modal Overlay -->

<div id="serviceCalendarModalOverlay"
    class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center opacity-0 invisible transition-all duration-300 ease-in-out">
    <!-- Modal Container -->

    <div id="serviceCalendarModalContainer"
        class="bg-white rounded-lg shadow-xl w-full max-w-6xl mx-4 transform scale-95 transition-all duration-300 ease-in-out">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Service Calendar</h3>
            <button type="button" id="closeServiceCalendarModalBtn"
                class="text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full p-1">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 max-h-[60vh] overflow-y-auto">
            <!-- Add this wherever your calendar appears, maybe inside a modal -->
            <div id="calendar" data-service-id="{{ $service->id }}">

            </div>

        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 p-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
            <button type="button" id="cancelServiceCalendarBtn"
                class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Cancel
            </button>
            {{-- <button type="submit" id="confirmServiceCalendarBtn"
                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save Changes
            </button> --}}
        </div>
    </div>
</div>

<script>
    // Get DOM elements
    const openServiceCalendarModalBtn = document.getElementById('openServiceCalendarModalBtn');
    const serviceCalendarModalOverlay = document.getElementById('serviceCalendarModalOverlay');
    const serviceCalendarModalContainer = document.getElementById('serviceCalendarModalContainer');
    const closeServiceCalendarModalBtn = document.getElementById('closeServiceCalendarModalBtn');
    const cancelServiceCalendarBtn = document.getElementById('cancelServiceCalendarBtn');
    const confirmServiceCalendarBtn = document.getElementById('confirmServiceCalendarBtn');

    // Function to open the modal
    function openServiceCalendarModal() {
        // Make modal visible
        serviceCalendarModalOverlay.classList.remove('invisible', 'opacity-0');
        serviceCalendarModalOverlay.classList.add('opacity-100');

        // Scale up the modal
        serviceCalendarModalContainer.classList.remove('scale-95');
        serviceCalendarModalContainer.classList.add('scale-100');

        // Prevent scrolling on the body
        document.body.classList.add('overflow-hidden');
    }

    // Function to close the modal
    function closeServiceCalendarModal() {
        // Fade out the modal
        serviceCalendarModalOverlay.classList.remove('opacity-100');
        serviceCalendarModalOverlay.classList.add('opacity-0');

        // Scale down the modal
        serviceCalendarModalContainer.classList.remove('scale-100');
        serviceCalendarModalContainer.classList.add('scale-95');

        // Hide the modal after animation completes
        setTimeout(() => {
            serviceCalendarModalOverlay.classList.add('invisible');
            // Re-enable scrolling on the body
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // Event listeners
    if (openServiceCalendarModalBtn) {
        openServiceCalendarModalBtn.addEventListener('click', openServiceCalendarModal);
    }

    closeServiceCalendarModalBtn.addEventListener('click', closeServiceCalendarModal);
    cancelServiceCalendarBtn.addEventListener('click', closeServiceCalendarModal);

    // Example action for confirm button
    confirmServiceCalendarBtn.addEventListener('click', () => {
    Swal.fire({
        icon: 'success',
        title: 'Saved!',
        text: 'Service calendar changes saved successfully.',
        timer: 2000,
        showConfirmButton: false
    });

    closeServiceCalendarModal();
});


    // Close modal when clicking outside
    serviceCalendarModalOverlay.addEventListener('click', (e) => {
        if (e.target === serviceCalendarModalOverlay) {
            closeServiceCalendarModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !serviceCalendarModalOverlay.classList.contains('invisible')) {
            closeServiceCalendarModal();
        }
    });
</script>
{{-- calendar script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const serviceId = calendarEl.dataset.serviceId;
        let selectedSlots = [];

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
            selectable: false,
            eventSources: [{
                    url: '/calendar/daysoff',
                    method: 'GET',
                    extraParams: {
                        service_id: serviceId
                    },
                    failure: () => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to Fetch Days Off',
                            text: 'There was an error while fetching days off!',
                        });
                    },
                    color: '#ef4444',
                    textColor: '#000',
                    display: 'background',
                },
                {
                    url: '/calendar/slots',
                    method: 'GET',
                    extraParams: {
                        service_id: serviceId
                    },
                    failure: () => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to Fetch Slots',
                            text: 'There was an error while fetching time slots!',
                        });
                    },
                }
            ],

            selectOverlap: function(event) {
                return event.display !== 'background';
            },

            eventDidMount: function(info) {
                if (info.event.title === "Booked") {
                    info.el.style.pointerEvents = 'none';
                    info.el.style.opacity = '0.6';
                }
            },

            eventClick: function(info) {
                if (info.event.title !== "Available") return;

                const clickedStart = info.event.start;
                const clickedEnd = info.event.end;
                const slotId = info.event.id; // slot id comes here
                console.log('Clicked slot ID:', slotId);

                if (!slotId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Slot',
                        text: 'Selected slot ID is invalid or missing.',
                    });
                    return;
                }

                // Prevent booking for past dates
                const now = new Date();
                const clickedDate = new Date(clickedStart);
                clickedDate.setHours(0, 0, 0, 0);
                now.setHours(0, 0, 0, 0);
                if (clickedDate < now) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Date',
                        text: 'You cannot book slots from past dates.',
                    });
                    return;
                }

                // Deselect previously selected slots
                selectedSlots.forEach(slot => {
                    const prevEvent = calendar.getEventById(slot.id?.toString());
                    if (prevEvent) {
                        const prevEl = prevEvent._def.ui?.el || calendarEl.querySelector(
                            `[data-event-id="${prevEvent.id}"]`);
                        if (prevEl) {
                            prevEl.style.backgroundColor = '';
                            prevEl.style.color = '';
                        }
                    }
                });

                // Select new slot
                selectedSlots = [{
                    id: slotId,
                    start: clickedStart,
                    end: clickedEnd
                }];
                markSelected(info.el);
                updateFormFields();
            },

            eventDataTransform: function(eventData) {
                if (eventData.slot_id) {
                    eventData.id = eventData.slot_id
                        .toString(); // assign id from slot_id for FullCalendar
                }
                return eventData;
            }
        });

        calendar.render();

        function markSelected(el) {
            el.style.backgroundColor = '#ef4444'; // Indigo
            el.style.color = 'white';
        }

        function updateFormFields() {
            if (selectedSlots.length === 0) return;

            const slot = selectedSlots[0];
            console.log('Slot object:', slot);

            const durationMinutes = (new Date(slot.end) - new Date(slot.start)) / (1000 * 60);
            const durationInHours = durationMinutes / 60;
            const roundedDuration = Math.round(durationInHours);

            const slotIdInput = document.getElementById('selected_slot_id');
            if (slotIdInput) {
                slotIdInput.value = slot.id;
                console.log('Updated form slot_id value:', slotIdInput.value);
            } else {
                console.warn('Hidden input field for selected_slot_id not found!');
            }

            const slotTimeInput = document.getElementById('selected_slot_time');
            if (slotTimeInput) {
                slotTimeInput.value = `${formatTime(slot.start)} - ${formatTime(slot.end)}`;
            }

            const startTimeInput = document.getElementById('selected_start_time');
            if (startTimeInput) {
                startTimeInput.value = slot.start.toISOString();
            }

            const endTimeInput = document.getElementById('selected_end_time');
            if (endTimeInput) {
                endTimeInput.value = slot.end.toISOString();
            }

            const durationInput = document.getElementById('duration');
            if (durationInput) {
                durationInput.value = roundedDuration;
            }

            const timeSummary = document.getElementById('time-summary');
            if (timeSummary) {
                timeSummary.innerHTML = `
                <strong>Selected Time:</strong><br>
                ${slot.start.toLocaleString()} - ${slot.end.toLocaleString()}<br>
                Duration: ${roundedDuration} hour(s)
            `;
            }

            if (typeof updateTotalPrice === 'function') updateTotalPrice();
        }

        function formatTime(dateObj) {
            return dateObj.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    });
</script>
