@include('booking.reschedule-modal')
<!-- Modern Booking Card -->
<div class="group relative bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
    <!-- Status Banner -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r 
        @if($booking->payment_status === 'confirmed') from-green-400 to-green-600
        @else from-yellow-400 to-orange-500 @endif">
    </div>
    
    <div class="p-6">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-6">
            <div class="flex-1 mb-4 lg:mb-0">
                <div class="flex items-start space-x-4">
                    <!-- Service Icon -->
                    <div class="flex-shrink-0">
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Service Details -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200">
                            {{ $booking->service->service_name }}
                        </h3>
                        
                        <!-- Provider Info -->
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                                {{ strtoupper(substr($booking->provider->first_name, 0, 1) . substr($booking->provider->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $booking->provider->first_name }} {{ $booking->provider->last_name }}
                                </p>
                                <p class="text-xs text-gray-500">Service Provider</p>
                            </div>
                        </div>
                        
                        <!-- Booking ID -->
                        <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                            Booking #{{ $booking->id }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Status and Payment Info -->
            <div class="flex flex-col items-start lg:items-end space-y-3">
                <!-- Payment Status -->
                @if ($booking->payment_status === 'confirmed')
                    <div class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                        Payment Confirmed
                    </div>
                @else
                    <div class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-100 to-orange-100 text-orange-800 border border-orange-200">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mr-2 animate-pulse"></div>
                        Payment Pending
                    </div>
                @endif
                
                <!-- Price -->
                <div class="text-right">
                    <p class="text-2xl font-bold text-gray-900">${{ number_format($booking->total_amount, 2) }}</p>
                    <p class="text-sm text-gray-500">Total Amount</p>
                </div>
            </div>
        </div>
        
        <!-- Date and Time Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $booking->start_time->format('F j, Y') }}</p>
                    <p class="text-xs text-gray-500">Service Date</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-900">
                        {{ $booking->start_time->format('h:i A') }} - {{ $booking->end_time->format('h:i A') }}
                    </p>
                    <p class="text-xs text-gray-500">Service Time</p>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
            @if ($booking->payment_status === 'confirmed' && ($booking->status == 'confirmed' || $booking->status == 'pending'))
                <button onclick="rescheduleBooking({{$booking->id}})" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Reschedule
                </button>
                
                <form id="cancel-form-{{ $booking->id }}" action="{{ route('update-status', $booking->id) }}" method="POST" class="flex-1">
                    @csrf
                    <input type="hidden" name="status" value="canceled">
                    <button type="button" onclick="confirmCancel({{ $booking->id }})" 
                        class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel Booking
                    </button>
                </form>
                
            @elseif($booking->status == 'canceled')
                <div class="flex-1 inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Booking Canceled
                </div>
                
            @elseif($booking->payment_status === 'pending')
                <a href="{{ route('payment.show', $booking->id) }}" 
                    class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Complete Payment
                </a>
                @elseif($booking->status === 'completed')
                <div class="flex-1 inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-emerald-100 text-emerald-500 cursor-not-allowed">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 mr-2">
                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                      </svg>
                      
                    Booking Is Completed
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function confirmCancel(bookingId) {
    Swal.fire({
        title: 'Cancel Booking?',
        text: "This action cannot be undone. Are you sure you want to cancel this booking?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Cancel It',
        cancelButtonText: 'Keep Booking',
        customClass: {
            popup: 'rounded-xl',
            confirmButton: 'rounded-lg px-6 py-2',
            cancelButton: 'rounded-lg px-6 py-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('cancel-form-' + bookingId);
            const formData = new FormData(form);

            // Show loading state
            Swal.fire({
                title: 'Canceling...',
                text: 'Please wait while we process your request.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
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
        }
    });
}
</script>
@vite('resources/js/reschedule-modal.js')