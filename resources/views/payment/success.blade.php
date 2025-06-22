@extends('layouts.app')
<title>BookEase - Payment Successful</title>

@section('content')
    <!-- Header -->
    @include('navigation.Header')

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-3xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                @if (session('success'))
                    <div class="alert alert-success mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger mb-4">
                        {{ session('error') }}
                    </div>
                @endif


                <!-- Success Header -->
                <div class="bg-green-50 p-6 border-b border-green-100">
                    <div class="flex items-center justify-center mb-4">
                        <div class="h-16 w-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 text-center mb-2">
                        <p>{{ $message }}</p>
                    </h1>
                    <p class="text-gray-600 text-center">Your booking is pending for confirmation from service provider once
                        confirmed you will get email and your payment has been processed successfully.</p>
                </div>

                <!-- Booking Details -->
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold mb-4">Booking Details</h2>

                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-sm text-gray-500">Booking Reference</div>
                                <div class="text-lg font-semibold text-gray-900">
                                    #BE-{{ now()->year }}-{{ str_pad($billingInfo['id'], 5, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                            <div class="border-t border-gray-200 pt-4">
                                <div class="text-sm text-gray-500 mb-1">A confirmation email has been sent to:</div>
                                <div class="font-medium">{{ $billingInfo['email'] }}</div>
                            </div>
                        </div>

                        <!-- Provider Info -->
                        <div class="flex items-center mb-6">
                            <div
                                class="h-16 w-16 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold mr-4">
                                {{ strtoupper(substr($booking->provider->first_name, 0, 1) . substr($booking->provider->last_name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $booking->provider->first_name ?? 'N/A' }}
                                    {{ $booking->provider->last_name ?? 'N/A' }}</h3>
                                <p class="text-sm text-gray-500">{{ $booking->service->service_name ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <!-- Service Details -->
                        <div class="mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Service:</span>
                                <span class="text-gray-900 font-medium">{{ $serviceOfferingName ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Date:</span>
                                <span class="text-gray-900 font-medium">{{ $booking->start_time->format('Y-m-d') }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Time:</span>
                                <span class="text-gray-900 font-medium">{{ $booking->start_time->format('h:i A') }} -
                                    {{ $booking->end_time->format('h:i A') }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Duration:</span>
                                <span class="text-gray-900 font-medium">{{ $booking->duration }} hours</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Address:</span>
                                <span class="text-gray-900 font-medium">{{ $billingInfo['address'] }},
                                    {{ $billingInfo['city'] }}, {{ $billingInfo['province'] }},
                                    {{ $billingInfo['zip_code'] }}, {{ $billingInfo['country'] }}</span>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="border-t border-gray-200 pt-4 mb-6">

                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">{{ $serviceOfferingName }}
                                    ({{ $booking->duration }}
                                    hour{{ $booking->duration > 1 ? 's' : '' }})</span>
                                <span
                                    class="text-gray-900">${{ number_format($servicePrice * $booking->duration, 2) }}</span>
                            </div>

                            @foreach ($selectedAdds as $name)
                                @php $name = trim($name); @endphp
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">{{ $name }}</span>
                                    <span class="text-gray-900">
                                        ${{ number_format($additionalServicePrices[$name] ?? 0, 2) }}
                                    </span>
                                </div>
                            @endforeach


                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Service Fee</span>
                                <span class="text-gray-900">${{ $booking->service->service_fee }}</span>
                            </div>

                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Tax
                                    ({{ number_format($booking->service->tax), 2 }}%)</span>
                                <span
                                    class="text-gray-900">${{ ($booking->total_amount * $booking->service->tax) / (100 + $booking->service->tax) }}</span>
                            </div>

                            <div class="flex justify-between font-bold text-lg mt-4 pt-4 border-t border-gray-200">
                                <span>Total</span>
                                <span>${{ $booking->total_amount }}</span>
                            </div>

                        </div>


                        <!-- Payment Method -->
                        <div class="mb-6">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="text-gray-900 font-medium">{{ strtoupper($booking->payment->card_brand ??'Card') }} ending in {{ $booking->payment->card_last4 ??'****'}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Payment Date:</span>
                                <span
                                    class="text-gray-900 font-medium">{{ $booking->payment->updated_at->format('F d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="bg-indigo-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-indigo-800 mb-2">What's Next?</h3>
                        <ul class="space-y-2 text-sm text-indigo-700">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2 flex-shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Sarah will contact you before the appointment to confirm details.</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2 flex-shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>You can manage your booking through your account dashboard.</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2 flex-shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>After the service, you'll be able to leave a review for Sarah.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('upcoming-bookings') }}"
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            View My Bookings
                        </a>
                        <a href="{{ route('receipt.show', $booking->id) }}"
                            class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Receipt
                        </a>
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden p-6">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mr-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="font-semibold text-gray-900">Need help with your booking?</h3>
                </div>
                <p class="text-gray-600 mb-4">If you have any questions or need to make changes to your booking, our
                    support team is here to help.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="mailto:support@example.com"
                        class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email Support
                    </a>

                    <a href="{{ route('support') }}"
                        class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Call Support
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('navigation.Footer')
@endsection
