// Reschedule Modal JavaScript
document.addEventListener("DOMContentLoaded", () => {
    // Create modal HTML and append to body
    createRescheduleModal();
});

// Global function to handle reschedule booking
window.rescheduleBooking = async (bookingId) => {
    try {
        showLoadingState();

        // Fetch booking details and available slots
        const response = await fetch(`/bookings/${bookingId}/reschedule`, {
            method: "GET",
            headers: {
                Accept: "application/json",
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content || "",
            },
        });

        const data = await response.json();
        hideLoadingState();

        if (!response.ok) {
            throw new Error(data.message || "Failed to fetch booking details");
        }

        // Check if same-day booking
        const bookingDate = new Date(data.booking.start_time);
        const today = new Date();
        const isToday = bookingDate.toDateString() === today.toDateString();

        if (isToday) {
            showSameDayError(data.booking);
        } else {
            showRescheduleModal(data.booking, data.availableSlots);
        }
    } catch (error) {
        hideLoadingState();
        showErrorMessage(
            "Error",
            error.message || "Failed to load booking details"
        );
    }
};

// Create modal HTML structure
function createRescheduleModal() {
    const modalHTML = `
        <!-- Reschedule Modal -->
        <div id="rescheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRescheduleModal()"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full sm:p-6">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Reschedule Booking</h3>
                        </div>
                        <button onclick="closeRescheduleModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Content -->
                    <div id="modalContent">
                        <!-- Content will be dynamically loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div id="loadingOverlay" class="fixed inset-0 z-60 hidden bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
                <span class="text-gray-700">Loading...</span>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML("beforeend", modalHTML);
}

// Show same-day error message
function showSameDayError(booking) {
    const content = `
        <div class="space-y-6">
            <!-- Error Card -->
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 sm:p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-red-800">Cannot Reschedule</h4>
                        <p class="text-sm text-red-600">This booking is scheduled for today</p>
                    </div>
                </div>
                
                <!-- Booking Details -->
                <div class="bg-white rounded-lg p-4 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Service:</span>
                        <span class="font-medium text-gray-800">${
                            booking.service_name || "N/A"
                        }</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Date:</span>
                        <span class="font-medium text-gray-800">${formatDate(
                            booking.start_time
                        )}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Time:</span>
                        <span class="font-medium text-gray-800">${formatTime(
                            booking.start_time
                        )}</span>
                    </div>
                </div>
            </div>

            <!-- Policy Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-medium text-blue-800 text-sm">Alternative Options</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            Same-day bookings cannot be rescheduled. You may cancel this booking and create a new one for a different date.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="cancelBooking(${
                    booking.id
                })" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Cancel Booking</span>
                </button>
                <button onclick="closeRescheduleModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    `;

    document.getElementById("modalContent").innerHTML = content;
    showModal();
}

// Show reschedule modal with available slots
function showRescheduleModal(booking, availableSlots) {
    const slotsHTML = generateSlotsHTML(availableSlots);

    const content = `
        <div class="space-y-6">
            <!-- Current Booking Info -->
            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Current Booking</h4>
                        <p class="text-sm text-gray-600">Select a new time slot below</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-3 grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                    <div>
                        <span class="text-gray-600">Service:</span>
                        <div class="font-medium text-gray-800">${
                            booking.service_name || "N/A"
                        }</div>
                    </div>
                    <div>
                        <span class="text-gray-600">Current Date:</span>
                        <div class="font-medium text-gray-800">${formatDate(
                            booking.start_time
                        )}</div>
                    </div>
                    <div>
                        <span class="text-gray-600">Current Time:</span>
                        <div class="font-medium text-gray-800">${formatTime(
                            booking.start_time
                        )}</div>
                    </div>
                </div>
            </div>

            <!-- Available Slots -->
            <div class="bg-white border border-gray-200 rounded-xl p-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Available Time Slots
                </h4>
                
                <form id="rescheduleForm">
                    <input type="hidden" name="booking_id" value="${
                        booking.id
                    }">
                    ${slotsHTML}
                </form>
            </div>

            <!-- Selected Slot Summary -->
            <div id="selectedSlotSummary" class="hidden bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center space-x-2 mb-2">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-800">Selected Time Slot</span>
                </div>
                <div id="selectedSlotDetails" class="text-sm text-green-700"></div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="submitReschedule()" id="rescheduleBtn" class="flex-1 bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-400 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Reschedule Booking</span>
                </button>
                <button onclick="closeRescheduleModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                    Cancel
                </button>
            </div>
        </div>
    `;

    document.getElementById("modalContent").innerHTML = content;
    showModal();
    setupSlotSelection();
}

// Generate slots HTML
function generateSlotsHTML(availableSlots) {
    if (availableSlots.length === 0) {
        return `
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-gray-500 font-medium">No empty slots available currently</p>
                <p class="text-gray-400 text-sm mt-1">Please try again later or contact support</p>
            </div>
        `;
    }

    // Group slots by date
    const slotsByDate = {};
    availableSlots.forEach((slot) => {
        const date = new Date(slot.date);
        if (!slotsByDate[date]) {
            slotsByDate[date] = [];
        }
        slotsByDate[date].push(slot);
    });

    return `
        <div class="max-h-64 overflow-y-auto space-y-6" id="slotsContainer">
            ${Object.keys(slotsByDate)
                .map((date) => {
                    const dateObj = new Date(date);
                    const dateLabel = formatDateLabel(dateObj);

                    return `
                    <div class="date-group">
                        <h5 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            ${dateLabel}
                        </h5>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            ${slotsByDate[date]
                                .map(
                                    (slot) => `
                                <label class="relative cursor-pointer slot-option" data-slot-id="${
                                    slot.id
                                }">
                                    <input 
                                        type="radio" 
                                        name="slot_id" 
                                        value="${slot.id}" 
                                        class="sr-only slot-radio"
                                        data-start-time="${slot.start_time}"
                                        data-end-time="${slot.end_time}"
                                        data-date="${slot.date}"
                                    >
                                    <div class="slot-card p-3 text-center border border-gray-200 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200">
                                        <div class="text-sm font-medium text-gray-800">
                                            ${formatDate(slot.date)}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            ${slot.duration} Hour
                                        </div>
                                    </div>
                                    <div class="slot-indicator absolute top-2 right-2 w-4 h-4 rounded-full border-2 border-gray-300 transition-all duration-200">
                                        <svg class="slot-checkmark w-2 h-2 text-white absolute top-0.5 left-0.5 opacity-0 transition-opacity duration-200" fill="currentColor" viewBox="0 0 8 8">
                                            <path d="M6.564.75l-3.59 3.612-1.538-1.55L0 4.26l2.974 2.99L8 2.193z"/>
                                        </svg>
                                    </div>
                                </label>
                            `
                                )
                                .join("")}
                        </div>
                    </div>
                `;
                })
                .join("")}
        </div>
    `;
}

// Setup slot selection event listeners
function setupSlotSelection() {
    const slotRadios = document.querySelectorAll('input[name="slot_id"]');
    const selectedSummary = document.getElementById("selectedSlotSummary");
    const selectedDetails = document.getElementById("selectedSlotDetails");
    const rescheduleBtn = document.getElementById("rescheduleBtn");

    slotRadios.forEach((radio) => {
        radio.addEventListener("change", function () {
            // Reset all slot cards
            document.querySelectorAll(".slot-card").forEach((card) => {
                card.classList.remove("border-indigo-500", "bg-indigo-50");
                card.classList.add("border-gray-200");
            });

            document
                .querySelectorAll(".slot-indicator")
                .forEach((indicator) => {
                    indicator.classList.remove(
                        "border-indigo-500",
                        "bg-indigo-500"
                    );
                    indicator.classList.add("border-gray-300");
                });

            document
                .querySelectorAll(".slot-checkmark")
                .forEach((checkmark) => {
                    checkmark.classList.add("opacity-0");
                });

            if (this.checked) {
                // Highlight selected slot
                const card =
                    this.closest(".slot-option").querySelector(".slot-card");
                const indicator =
                    this.closest(".slot-option").querySelector(
                        ".slot-indicator"
                    );
                const checkmark =
                    this.closest(".slot-option").querySelector(
                        ".slot-checkmark"
                    );

                card.classList.remove("border-gray-200");
                card.classList.add("border-indigo-500", "bg-indigo-50");

                indicator.classList.remove("border-gray-300");
                indicator.classList.add("border-indigo-500", "bg-indigo-500");

                checkmark.classList.remove("opacity-0");

                // Show selected slot summary
                const date = this.dataset.date; // "2025-06-18"
                const start = this.dataset.startTime; // "10:00:00"
                const end = this.dataset.endTime; // "11:00:00"

                const startTime = new Date(`${date}T${start}`);
                const endTime = new Date(`${date}T${end}`);

                selectedDetails.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Date:</span>
                        <span>${formatDate(date)}</span>
                    </div>
                    <div class="flex items-center justify-between mt-1">
                        <span class="font-medium">Time:</span>
                        <span>${formatTime(startTime)} - ${formatTime(
                    endTime
                )}</span>
                    </div>
                `;

                selectedSummary.classList.remove("hidden");
                rescheduleBtn.disabled = false;
                rescheduleBtn.classList.remove("disabled:bg-gray-400");
            } else {
                selectedSummary.classList.add("hidden");
                rescheduleBtn.disabled = true;
                rescheduleBtn.classList.add("disabled:bg-gray-400");
            }
        });
    });
}

// Submit reschedule request
async function submitReschedule() {
    const form = document.getElementById("rescheduleForm");
    const selectedSlot = form.querySelector('input[name="slot_id"]:checked');

    if (!selectedSlot) {
        showErrorMessage("Error", "Please select a time slot");
        return;
    }

    const bookingId = form.querySelector('input[name="booking_id"]').value;
    const slotId = selectedSlot.value;

    try {
        showLoadingState();

        const response = await fetch(`/bookings/${bookingId}/reschedule`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN":
                    document.querySelector('meta[name="csrf-token"]')
                        ?.content || "",
            },
            body: JSON.stringify({
                slot_id: slotId,
            }),
        });

        const result = await response.json();
        hideLoadingState();

        if (!response.ok) {
            throw new Error(result.message || "Failed to reschedule booking");
        }

        // Show success message
        showSuccessMessage(
            "Booking Rescheduled!",
            "Your booking has been successfully rescheduled."
        );
        closeRescheduleModal();

        // Refresh the page or update the booking list
        setTimeout(() => {
            window.location.reload();
        }, 2000);
    } catch (error) {
        hideLoadingState();
        showErrorMessage(
            "Reschedule Failed",
            error.message || "Failed to reschedule booking. Please try again."
        );
    }
}

// Cancel booking function (placeholder)
function cancelBooking(bookingId) {
    Swal.fire({
        title: "Cancel Booking?",
        text: "This action cannot be undone. Are you sure you want to cancel this booking?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Yes, Cancel It",
        cancelButtonText: "Keep Booking",
        customClass: {
            popup: "rounded-xl",
            confirmButton: "rounded-lg px-6 py-2",
            cancelButton: "rounded-lg px-6 py-2",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/booking/${bookingId}/cancel`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Failed to cancel booking.");
                    }
                    return response.json(); // Expecting JSON? or redirect
                })
                .then((data) =>  {
                    if (data.success) {
                        Swal.fire({
                            title: 'Booking Canceled!',
                            text: data.message || 'Your booking has been successfully canceled.',
                            icon: 'success',
                            confirmButtonColor: '#10b981',
                            confirmButtonText: 'Got it',
                            customClass: {
                                popup: 'rounded-xl',
                                confirmButton: 'rounded-lg px-6 py-2'
                            }
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Something went wrong. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#ef4444',
                            customClass: {
                                popup: 'rounded-xl',
                                confirmButton: 'rounded-lg px-6 py-2'
                            }
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire({
                        title: 'Network Error',
                        text: 'Unable to process your request. Please check your connection and try again.',
                        icon: 'error',
                        confirmButtonColor: '#ef4444',
                        customClass: {
                            popup: 'rounded-xl',
                            confirmButton: 'rounded-lg px-6 py-2'
                        }
                    });
                });

            closeRescheduleModal();
        }
    });
}


// Utility functions
function showModal() {
    document.getElementById("rescheduleModal").classList.remove("hidden");
    document.body.style.overflow = "hidden";
}

function closeRescheduleModal() {
    document.getElementById("rescheduleModal").classList.add("hidden");
    document.body.style.overflow = "auto";
}

function showLoadingState() {
    document.getElementById("loadingOverlay").classList.remove("hidden");
}

function hideLoadingState() {
    document.getElementById("loadingOverlay").classList.add("hidden");
}

function showErrorMessage(title, message) {
    Swal.fire({
        icon: "error",
        title: title,
        text: message,
        confirmButtonColor: "#d33",
    });
}

function showSuccessMessage(title, message) {
    Swal.fire({
        icon: "success",
        title: title,
        text: message,
        confirmButtonColor: "#3085d6",
    });
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString("en-US", {
        weekday: "short",
        year: "numeric",
        month: "short",
        day: "numeric",
    });
}

function formatTime(dateString) {
    return new Date(dateString).toLocaleTimeString("en-US", {
        hour: "2-digit",
        minute: "2-digit",
        hour12: true,
    });
}

function formatDateLabel(dateObj) {
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);

    if (dateObj.toDateString() === today.toDateString()) {
        return "Today";
    } else if (dateObj.toDateString() === tomorrow.toDateString()) {
        return "Tomorrow";
    } else {
        return dateObj.toLocaleDateString("en-US", {
            weekday: "long",
            month: "long",
            day: "numeric",
        });
    }
}



// Global functions
window.closeRescheduleModal = closeRescheduleModal;
window.submitReschedule = submitReschedule;
window.cancelBooking = cancelBooking;
