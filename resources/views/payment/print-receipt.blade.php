@extends('layouts.app')

@section('title', 'Print Receipt')

@section('content')
<div class="bg-gray-50 min-h-screen ">
    <!-- Header -->
    <div class="bg-white shadow print:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900">Receipt #INV-2024-001</h1>
                <div class="flex items-center space-x-4">
                    <button onclick="window.print()" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                        Print Receipt
                    </button>
                    <button onclick="downloadPDF()" class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700">
                        Download PDF
                    </button>
                    <button onclick="emailReceipt()" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                        Email Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 print:p-0">
        <div id="receipt-content" class="bg-white rounded-lg shadow-sm overflow-hidden print:shadow-none print:rounded-none">
            <!-- Receipt Header -->
            <div class="px-8 py-6 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">BookEase</h2>
                        <p class="text-sm text-gray-600 mt-1">{{$receipt->service->service_name}}</p>
                        <div class="mt-4 text-sm text-gray-600">
                            <p>{{$receipt->billingInformation->address}}</p>
                            <p>{{$receipt->billingInformation->province ??'N/A'}}, {{$receipt->billingInformation->zip_code}}</p>
                            <p>Phone: {{$receipt->user->phone}}</p>
                            <p>Email: {{$receipt->billingInformation->email}}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <h3 class="text-xl font-semibold text-gray-900">RECEIPT</h3>
                        <div class="mt-4 text-sm">
                            <p><span class="font-medium">Receipt #:</span> #BE-{{ now()->year }}-{{ str_pad($receipt->billingInformation->id, 5, '0', STR_PAD_LEFT) }}</p>
                            <p><span class="font-medium">Date:</span> {{($receipt->created_at)->format('F d, Y')}}</p>
                            <p><span class="font-medium">Payment Date:</span>{{($receipt->payment->updated_at)->format('F d, Y')}}</p>
                            <p><span class="font-medium">Payment Method:</span> Credit Card{{ strtoupper($receipt->payment->card_brand ??'Card') }} ****{{ $receipt->payment->card_last4 ??'****'}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Provider & Client Info -->
            <div class="px-8 py-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Service Provider</h4>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium text-gray-900">{{$receipt->provider->first_name}} {{$receipt->provider->last_name}}</p>
                            <p>{{$receipt->service->service_name}}</p>
                            <p>{{$receipt->provider->email}}</p>
                            <p>{{$receipt->provider->phone}}</p>
                            <p class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Verified Provider
                                </span>
                            </p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Bill To</h4>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium text-gray-900">{{$receipt->user->first_name}} {{$receipt->user->last_name}}</p>
                            <p>{{$receipt->billingInformation->email}}</p>
                            <p>{{$receipt->user->phone}}</p>
                            <p class="mt-2">{{$receipt->billingInformation->address}}</p>
                            <p>{{$receipt->billingInformation->province ??'N/A'}}, {{$receipt->billingInformation->zip_code}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="px-8 py-6 border-b border-gray-200">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Service Details</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-2 text-sm font-medium text-gray-900">Service</th>
                                <th class="text-left py-2 text-sm font-medium text-gray-900">Date & Time</th>
                                <th class="text-left py-2 text-sm font-medium text-gray-900">Duration</th>
                                <th class="text-right py-2 text-sm font-medium text-gray-900">Rate</th>
                                <th class="text-right py-2 text-sm font-medium text-gray-900">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-3 text-sm text-gray-900">
                                    <div>
                                        <p class="font-medium">{{ $serviceOfferingName }} </p>
                                        <p class="text-gray-600 text-xs">{{$receipt->special_instruction ??'No Special Instructions' }}</p>
                                    </div>
                                </td>
                                <td class="py-3 text-sm text-gray-600">
                                    {{($receipt->start_time)->format('F d, Y')}}<br>
                                    {{($receipt->start_time)->format('h:i A')}} -  {{($receipt->end_time)->format('h:i A')}}
                                </td>
                                <td class="py-3 text-sm text-gray-600">{{$receipt->duration}} hours</td>
                                <td class="py-3 text-sm text-gray-600 text-right">${{ number_format($servicePrice, 2) }}/hour</td>
                                <td class="py-3 text-sm text-gray-900 text-right font-medium">${{($receipt->duration )* ($servicePrice)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Additional Charges -->
            <div class="px-8 py-6 border-b border-gray-200">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Additional Items</h4>

                    @if (!empty($selectedAdds))

        
                        @foreach ($selectedAdds as $addOn)
                            @php
                                $price = $additionalServicePrices[$addOn] ?? 0;
                            @endphp
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">{{ $addOn }}</span>
                                <span class="text-gray-900">${{ number_format($price, 2) }}</span>
                            </div>
                        @endforeach
                    
                @endif
                
               
                
                    <div class="flex justify-between">
                        <span class="text-gray-600">Service Fee</span>
                        <span class="text-gray-900">${{$receipt->service->service_fee}}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="px-8 py-6">
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="text-gray-900">${{$beforeTaxTotal}}</span>
                            </div>
                            {{-- <div class="flex justify-between">
                                <span class="text-gray-600">Platform Fee (5%):</span>
                                <span class="text-gray-900">$8.75</span>
                            </div> --}}
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax ({{$receipt->service->tax}}%):</span>
                                <span class="text-gray-900">${{$taxAmount}}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-2">
                                <div class="flex justify-between">
                                    <span class="text-base font-semibold text-gray-900">Total:</span>
                                    <span class="text-base font-semibold text-gray-900">${{$receipt->total_amount}}</span>
                                </div>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span class="font-medium">Amount Paid:</span>
                                <span class="font-medium">${{$receipt->total_amount}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Payment Information</h4>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><span class="font-medium">Payment Method:</span> {{ strtoupper($receipt->payment->card_brand ??'Card') }} ****{{ $receipt->payment->card_last4??'****' }}</p>
                            {{-- <p><span class="font-medium">Transaction ID:</span> txn_1234567890</p>
                            <p><span class="font-medium">Authorization Code:</span> AUTH123456</p> --}}
                            <p><span class="font-medium">Status:</span> <span class="text-green-600 font-medium">{{$receipt->payment_status}}</span></p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-3">Notes</h4>
                        <div class="text-sm text-gray-600">
                            <p>Service Provider will contact you shortly.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-8 py-6 border-t border-gray-200 text-center">
                <div class="text-sm text-gray-600">
                    <p class="mb-2">Thank you for using BookEase!</p>
                    <p>For questions about this receipt, please contact us at support@BookEase.com or (555) 123-4567</p>
                    <p class="mt-4 text-xs">This is a computer-generated receipt and does not require a signature.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    body {
        background: white !important;
    }
    
    .print\:hidden {
        display: none !important;
    }
    
    .print\:p-0 {
        padding: 0 !important;
    }
    
    .print\:shadow-none {
        box-shadow: none !important;
    }
    
    .print\:rounded-none {
        border-radius: 0 !important;
    }
    
    #receipt-content {
        box-shadow: none !important;
        border-radius: 0 !important;
    }
    
    @page {
        margin: 0.5in;
        size: letter;
    }
}
</style>
@endsection
@vite(['resources/js/print-receipt.js'])
