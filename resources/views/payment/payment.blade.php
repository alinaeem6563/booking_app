@extends('layouts.app')
<title>BookEase - Complete Your Booking</title>

@section('content')
    <!-- Header -->
    @include('navigation.Header')

    <!-- Checkout Progress -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-center">
                <ol class="flex items-center w-full max-w-3xl">
                    <li class="flex items-center text-indigo-600 font-medium">
                        <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 rounded-full text-white">1</span>
                        <span class="ml-2">Service Details</span>
                        <svg class="w-6 h-6 mx-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="flex items-center text-indigo-600 font-medium">
                        <span
                            class="flex items-center justify-center w-8 h-8 bg-indigo-600 rounded-full text-white">2</span>
                        <span class="ml-2">Review Booking</span>
                        <svg class="w-6 h-6 mx-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </li>
                    <li class="flex items-center text-indigo-600 font-medium">
                        <span
                            class="flex items-center justify-center w-8 h-8 bg-indigo-600 rounded-full text-white">3</span>
                        <span class="ml-2">Payment</span>
                    </li>
                </ol>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">Complete Your Booking</h1>
            @if (session('error'))
                <div class="mb-4 text-red-800 bg-red-100 border border-red-300 rounded p-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column - Payment Form -->
                <div class="w-full lg:w-2/3">
                    <!-- Payment Methods -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                        <h2 class="text-xl font-bold mb-4">Payment Method</h2>

                        <div class="mb-6" x-data="{ paymentMethod: 'card' }">
                            <div class="flex flex-wrap gap-4 mb-6">
                                <label class="relative flex items-center p-4 border rounded-lg cursor-pointer"
                                    :class="paymentMethod === 'card' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'">
                                    <input type="radio" name="payment-method" value="card" class="sr-only"
                                        x-model="paymentMethod">
                                    <span class="flex items-center">
                                        <span class="w-5 h-5 mr-4 border rounded-full flex items-center justify-center"
                                            :class="paymentMethod === 'card' ? 'border-indigo-600' : 'border-gray-400'">
                                            <span class="w-3 h-3 rounded-full"
                                                :class="paymentMethod === 'card' ? 'bg-indigo-600' : ''"></span>
                                        </span>
                                        <svg class="w-8 h-8 mr-3" viewBox="0 0 40 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="24" rx="4" fill="#E9EFFB" />
                                            <path d="M11.5 16H14.5L15.5 10L12.5 10L11.5 16Z" fill="#4F46E5" />
                                            <path d="M16.5 10L15.5 16H18.5L19.5 10H16.5Z" fill="#4F46E5" />
                                            <path d="M20.5 10L19.5 16H22.5L23.5 10H20.5Z" fill="#4F46E5" />
                                            <path d="M24.5 10L23.5 16H26.5L27.5 10H24.5Z" fill="#4F46E5" />
                                        </svg>
                                        <span class="font-medium">Credit / Debit Card</span>
                                    </span>
                                </label>

                                <label class="relative flex items-center p-4 border rounded-lg cursor-pointer"
                                    :class="paymentMethod === 'paypal' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-200'">
                                    <input type="radio" name="payment-method" value="paypal" class="sr-only"
                                        x-model="paymentMethod">
                                    <span class="flex items-center">
                                        <span class="w-5 h-5 mr-4 border rounded-full flex items-center justify-center"
                                            :class="paymentMethod === 'paypal' ? 'border-indigo-600' : 'border-gray-400'">
                                            <span class="w-3 h-3 rounded-full"
                                                :class="paymentMethod === 'paypal' ? 'bg-indigo-600' : ''"></span>
                                        </span>
                                        <svg class="w-16 h-5 mr-2" viewBox="0 0 124 33" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M46.1695 8.00033H41.6363C41.3445 8.00033 41.0911 8.19255 41.0295 8.47699L38.9345 22.2026C38.8906 22.4024 39.0465 22.5869 39.2511 22.5869H41.4313C41.7231 22.5869 41.9765 22.3947 42.0381 22.1102L42.5667 18.9099C42.6283 18.6254 42.8817 18.4332 43.1735 18.4332H44.7519C47.5502 18.4332 49.1945 17.0949 49.6353 14.4332C49.8349 13.2486 49.6987 12.3254 49.1945 11.6716C48.6366 10.9485 47.6001 10.6254 46.1695 10.6254H46.1695ZM46.7567 14.5793C46.5059 16.0793 45.3213 16.0793 44.1733 16.0793H43.4941L44.0081 13.0254C44.0374 12.8793 44.1659 12.7716 44.3168 12.7716H44.6233C45.3945 12.7716 46.1256 12.7716 46.5059 13.1793C46.7421 13.4178 46.8344 13.8793 46.7567 14.5793Z"
                                                fill="#253B80" />
                                            <path
                                                d="M58.8294 14.5281H56.6419C56.491 14.5281 56.3625 14.6358 56.3332 14.7819L56.2189 15.4665L56.0557 15.2435C55.5955 14.6358 54.6663 14.3896 53.7371 14.3896C51.5935 14.3896 49.7717 15.9973 49.3841 18.2127C49.1846 19.3204 49.3841 20.3742 49.9493 21.1281C50.4681 21.8204 51.2467 22.1281 52.1905 22.1281C53.9537 22.1281 54.9049 21.0127 54.9049 21.0127L54.7905 21.6896C54.7466 21.8896 54.9025 22.0742 55.1071 22.0742H57.0801C57.3719 22.0742 57.6253 21.8819 57.6869 21.5973L58.9323 14.9127C58.9762 14.7127 58.8203 14.5281 58.8294 14.5281ZM55.5809 18.2742C55.3813 19.3281 54.5148 20.0281 53.4346 20.0281C52.8913 20.0281 52.4598 19.8742 52.1825 19.5665C51.9052 19.2588 51.7936 18.8127 51.8859 18.3204C52.0708 17.2742 52.9519 16.5511 54.0102 16.5511C54.5389 16.5511 54.9704 16.7051 55.2551 17.0204C55.5397 17.3358 55.6586 17.7819 55.5809 18.2742Z"
                                                fill="#253B80" />
                                            <path
                                                d="M71.4935 14.5281H69.2987C69.1259 14.5281 68.9605 14.6127 68.8562 14.7511L65.8945 19.0742L64.6491 14.9204C64.5802 14.6819 64.3634 14.5281 64.1199 14.5281H61.9689C61.7424 14.5281 61.5793 14.7511 61.6232 14.9742L63.8741 21.4973L61.7717 24.4358C61.6159 24.6511 61.7717 24.9358 62.0344 24.9358H64.2219C64.3947 24.9358 64.5601 24.8511 64.6644 24.7127L71.7635 14.9973C71.9121 14.7819 71.7562 14.5281 71.4935 14.5281Z"
                                                fill="#253B80" />
                                            <path
                                                d="M79.0557 8.00033H74.5225C74.2307 8.00033 73.9773 8.19255 73.9157 8.47699L71.8207 22.2026C71.7768 22.4024 71.9327 22.5869 72.1373 22.5869H74.5225C74.8143 22.5869 75.0677 22.3947 75.1293 22.1102L75.6579 18.9099C75.7195 18.6254 75.9729 18.4332 76.2647 18.4332H77.8431C80.6414 18.4332 82.2857 17.0949 82.7265 14.4332C82.9261 13.2486 82.7899 12.3254 82.2857 11.6716C81.7278 10.9485 80.6913 10.6254 79.0557 10.6254ZM79.6429 14.5793C79.3921 16.0793 78.2075 16.0793 77.0595 16.0793H76.3803L76.8943 13.0254C76.9236 12.8793 77.0521 12.7716 77.203 12.7716H77.5095C78.2807 12.7716 79.0118 12.7716 79.3921 13.1793C79.6283 13.4178 79.7206 13.8793 79.6429 14.5793Z"
                                                fill="#179BD7" />
                                            <path
                                                d="M91.7156 14.5281H89.5281C89.3772 14.5281 89.2487 14.6358 89.2194 14.7819L89.1051 15.4665L88.9419 15.2435C88.4817 14.6358 87.5525 14.3896 86.6233 14.3896C84.4797 14.3896 82.6579 15.9973 82.2703 18.2127C82.0708 19.3204 82.2703 20.3742 82.8355 21.1281C83.3543 21.8204 84.1329 22.1281 85.0767 22.1281C86.8399 22.1281 87.7911 21.0127 87.7911 21.0127L87.6767 21.6896C87.6328 21.8896 87.7887 22.0742 87.9933 22.0742H89.9663C90.2581 22.0742 90.5115 21.8819 90.5731 21.5973L91.8185 14.9127C91.8624 14.7127 91.7065 14.5281 91.7156 14.5281ZM88.4671 18.2742C88.2675 19.3281 87.401 20.0281 86.3208 20.0281C85.7775 20.0281 85.346 19.8742 85.0687 19.5665C84.7914 19.2588 84.6798 18.8127 84.7721 18.3204C84.957 17.2742 85.8381 16.5511 86.8964 16.5511C87.4251 16.5511 87.8566 16.7051 88.1413 17.0204C88.4259 17.3358 88.5448 17.7819 88.4671 18.2742Z"
                                                fill="#179BD7" />
                                            <path
                                                d="M93.9665 8.47699L91.8569 22.2026C91.813 22.4024 91.9689 22.5869 92.1735 22.5869H94.0246C94.3164 22.5869 94.5698 22.3947 94.6314 22.1102L96.7264 8.38477C96.7703 8.18477 96.6144 8.00033 96.4098 8.00033H94.2809C94.13 8.00033 94.0015 8.10811 93.9665 8.25421V8.47699Z"
                                                fill="#179BD7" />
                                            <path
                                                d="M16.8062 3.95898L16.5216 5.75898C15.3151 11.1051 11.6384 13.2667 7.03562 13.2667H4.99616C4.55686 13.2667 4.18219 13.5974 4.09329 14.0282L2.75342 22.359C2.69178 22.6667 2.92384 22.9513 3.23562 22.9513H7.03562C7.42466 22.9513 7.75918 22.6667 7.83371 22.2821V22.1744L8.53836 17.9513V17.8205C8.61288 17.4359 8.94192 17.1513 9.33644 17.1513H9.79014C13.7973 17.1513 16.9425 15.2667 17.9767 10.5744C18.4014 8.59795 18.1827 6.92308 17.1485 5.75898C17.0596 5.64872 16.9425 5.53846 16.8062 5.45128V3.95898Z"
                                                fill="#253B80" />
                                            <path
                                                d="M15.9 3.53846C15.7637 3.48718 15.6274 3.43589 15.4911 3.38461C15.3548 3.33333 15.2185 3.30769 15.0822 3.28205C14.5211 3.17949 13.9007 3.12821 13.2548 3.12821H8.04822C7.92192 3.12821 7.79562 3.15385 7.69233 3.20513C7.46027 3.30769 7.29781 3.53846 7.25055 3.82051L6.19178 10.1282V10.3077C6.28068 9.87692 6.65534 9.54615 7.09466 9.54615H9.13411C13.7369 9.54615 17.4137 7.38461 18.6201 2.03846L18.6674 1.79487C18.4353 1.53846 18.1507 1.33333 17.8216 1.15385C17.2959 0.769231 16.6501 0.512821 15.9 0.384615V3.53846Z"
                                                fill="#179BD7" />
                                            <path
                                                d="M7.25068 3.82051C7.29794 3.53846 7.46041 3.30769 7.69247 3.20513C7.79576 3.15385 7.92205 3.12821 8.04836 3.12821H13.2549C13.9008 3.12821 14.5212 3.17949 15.0823 3.28205C15.2186 3.30769 15.3549 3.33333 15.4912 3.38461C15.6275 3.43589 15.7638 3.48718 15.9001 3.53846V0.384615C15.1501 0.25641 14.3527 0.179487 13.5079 0.179487H8.04836C7.16973 0.179487 6.39521 0.794872 6.21836 1.66667L4.67973 11.1538L4.65684 11.2564L6.19247 10.1282V3.82051H7.25068Z"
                                                fill="#222D65" />
                                            <path
                                                d="M17.1484 5.75898C18.1826 6.92308 18.4013 8.59795 17.9766 10.5744C16.9424 15.2667 13.7972 17.1513 9.79 17.1513H9.3363C8.94178 17.1513 8.61274 17.4359 8.53822 17.8205L7.83356 22.1744V22.2821C7.75904 22.6667 7.42452 22.9513 7.03548 22.9513H3.23548C2.9237 22.9513 2.69164 22.6667 2.75329 22.359L4.09315 14.0282C4.18206 13.5974 4.55672 13.2667 4.99603 13.2667H7.03548C11.6383 13.2667 15.315 11.1051 16.5214 5.75898H17.1484Z"
                                                fill="#253B80" />
                                        </svg>
                                        <span class="font-medium">PayPal</span>
                                    </span>
                                </label>
                            </div>


                            <!-- Credit Card Form -->
                            <div x-show="paymentMethod === 'card'" class="mt-6 p-4 bg-blue-50 rounded-lg"">
                                <div class="flex items-center mb-4">
                                    <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-700">You will be redirected to Stripe to complete your
                                        payment securely.</p>
                                </div>
                                <p class="text-sm text-gray-600">After clicking "Complete Booking", you'll be taken to

                            </div>
                            <!-- PayPal Info -->
                            <div x-show="paymentMethod === 'paypal'" class="mt-6 p-4 bg-blue-50 rounded-lg">
                                <div class="flex items-center mb-4">
                                    <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-700">You will be redirected to PayPal to complete your
                                        payment securely.</p>
                                </div>
                                <p class="text-sm text-gray-600">After clicking "Complete Booking", you'll be taken to
                                    PayPal to finalize your payment. Once the payment is processed, you'll be returned
                                    to
                                    BookEase to view your booking confirmation.</p>
                            </div>
                        </div>
                    </div>
                    <form id="payment-form" action="{{ route('payment.process', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" id="booking_id" value="{{ $booking->id }}">
                        <!-- Billing Information -->
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6 p-6">
                            <h2 class="text-xl font-bold mb-4">Billing Information</h2>


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class=" block text-sm font-medium text-gray-700 mb-1">First
                                        Name
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" id="first_name" name="first_name"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-control">
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last
                                        Name
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" id="last_name" name="last_name"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-control">
                                </div>

                                <div class="col-span-2">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                        Address
                                        <span class="text-red-600">*</span></label>
                                    <input type="email" id="email" name="email"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-control">
                                </div>

                                <div class="col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" id="address" name="address"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-control">
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-1">City
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" id="city" name="city"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-control">
                                </div>

                                <div>
                                    <label for="province" class="block text-sm font-medium text-gray-700 mb-1">State /
                                        Province
                                        <span class="text-red-600">*</span></label>
                                    <input type="text" id="province" name="province"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-control">
                                </div>

                                <div>
                                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-1">ZIP /
                                        Postal
                                        Code <span class="text-gray-400">(optional)</span></label>
                                    <input type="text" id="zip_code" name="zip_code"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md form-control">
                                </div>

                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country
                                        <span class="text-red-600">*</span></label>
                                    <select id="country" name="country"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm form-control">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}, {{ $country->iso }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>


                </div>

                <!-- Right Column - Order Summary -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden sticky top-24">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-xl font-bold mb-4">Order Summary</h2>

                            <!-- Provider Info -->
                            <div class="flex items-center mb-6">
                                <div
                                    class="h-16 w-16 rounded-full bg-indigo-600 flex items-center justify-center text-white text-xl font-bold mr-4">
                                    {{ strtoupper(substr($booking->provider->first_name, 0, 1) . substr($booking->provider->last_name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $booking->provider->first_name }}
                                        {{ $booking->provider->last_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $booking->service->service_name }}</p>
                                </div>
                            </div>

                            <!-- Service Details -->
                            <div class="mb-6">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Service:</span>
                                    <span class="text-gray-900 font-medium">{{ $booking->service->service_name }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Date:</span>
                                    <span
                                        class="text-gray-900 font-medium">{{ $booking->start_time->format('Y-m-d') }}</span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Time:</span>
                                    <span
                                        class="text-gray-900 font-medium">{{ $booking->start_time->format('h:i A') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Duration:</span>
                                    <span class="text-gray-900 font-medium">{{ $booking->duration }} hours</span>
                                </div>
                            </div>

                            <!-- Price Breakdown -->
                            <div class="border-t border-gray-200 pt-4 mb-6">

                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">{{ $booking->service->service_name }}
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



                            <!-- Secure Payment Notice -->
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="flex items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span class="font-medium text-gray-700">Secure Payment</span>
                                </div>
                                <p class="text-sm text-gray-600">Your payment information is encrypted and secure. We never
                                    store your full credit card details.</p>
                            </div>

                            <!-- Complete Booking Button -->
                            <button id="pay-button" type="button" disabled
                                class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Complete Booking ${{ number_format($booking->total_amount, 2) }}
                            </button>



                            <!-- Cancel Link -->
                            <div class="text-center mt-4">
                                <a href="#" class="text-sm text-gray-600 hover:text-indigo-600">Cancel and return to
                                    provider</a>
                            </div>
                            <div id="payment-error"
                                style="display: none; color: red; font-weight: bold; margin-top: 1rem;"></div>
                        </div>

                        <!-- Support Section -->
                        <div class="p-6 bg-gray-50">
                            <div class="flex items-center mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="font-medium text-gray-700">Need help?</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Our support team is available 24/7</p>
                            <a href="{{ route('support') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">Contact
                                Support</a>
                        </div>
                    </div>
                </div>
                </form>

            </div>
        </div>
    </main>

    <!-- Footer -->
    @include('navigation.Footer')
@endsection

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const form = document.getElementById('payment-form');
        const payButton = document.getElementById('pay-button');
        const bookingId = document.getElementById('booking_id')?.value;
        const errorDiv = document.getElementById('payment-error');

        function showError(message) {
            errorDiv.innerText = message;
            errorDiv.style.display = 'block';
        }

        function clearError() {
            errorDiv.innerText = '';
            errorDiv.style.display = 'none';
        }

        function validateForm() {
            const requiredFields = ['first_name', 'last_name', 'email', 'address', 'city', 'province'];
            return requiredFields.every(id => {
                const field = document.getElementById(id);
                return field && field.value.trim() !== '';
            });
        }

        form.addEventListener('input', () => {
            payButton.disabled = !validateForm();
        });

        payButton.addEventListener('click', async (e) => {
            e.preventDefault();
            clearError();

            if (!validateForm()) {
                showError('Please fill in all required billing fields.');
                return;
            }

            payButton.disabled = true;
            payButton.innerText = 'Processing...';

            try {
                const billingData = {
                    booking_id: bookingId,
                    first_name: document.getElementById('first_name')?.value,
                    last_name: document.getElementById('last_name')?.value,
                    email: document.getElementById('email')?.value,
                    address: document.getElementById('address')?.value,
                    city: document.getElementById('city')?.value,
                    province: document.getElementById('province')?.value,
                    zip_code: document.getElementById('zip_code')?.value || '',
                    country: document.getElementById('country')?.value || ''
                };

                const response = await fetch(`/payment/${bookingId}/process`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify(billingData)
                });

                const result = await response.json();

                if (!response.ok) {
                    const errorMessage = result?.message || 'An unexpected error occurred during payment.';
                    showError(errorMessage);
                    payButton.disabled = false;
                    payButton.innerText = 'Pay Again';
                    return;
                }

                if (result.url) {
                    // ✅ Redirect to Stripe
                    window.location.href = result.url;
                } else {
                    showError('Payment session could not be created.');
                    payButton.disabled = false;
                    payButton.innerText = 'Pay Again';
                }

            } catch (err) {
                console.error(err);
                showError('Unexpected error: ' + err.message);
                payButton.disabled = false;
                payButton.innerText = 'Pay Again';
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            payButton.disabled = !validateForm();
            clearError();
        });
    </script>
@endsection
