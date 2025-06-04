@extends('layouts.app')

@section('title', 'Invoice #INV-2024-001')

@section('content')
<div class="bg-gray-50 min-h-screen ">
    <!-- Header -->
    <div class="bg-white shadow print:hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('invoices') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Back to Invoices
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">Invoice #<span id="invoice-number">INV-2024-001</span></h1>
                    <span id="invoice-status-badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        Paid
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <button onclick="sendInvoice()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Send Invoice
                    </button>
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print
                    </button>
                    <button onclick="downloadPDF()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 print:p-0 print:max-w-none">
        <div id="invoice-content" class="bg-white rounded-lg shadow-sm overflow-hidden print:shadow-none print:rounded-none">
            <!-- Invoice Header -->
            <div class="px-8 py-8 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center mb-4">
                            <div class="h-12 w-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-2xl font-bold text-gray-900">ServicePro</h2>
                                <p class="text-sm text-gray-600">Professional Service Platform</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p>123 Business Street</p>
                            <p>City, State 12345</p>
                            <p>Phone: (555) 123-4567</p>
                            <p>Email: support@servicepro.com</p>
                            <p>Website: www.servicepro.com</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">INVOICE</h3>
                        <div class="text-sm space-y-1">
                            <p><span class="font-medium text-gray-700">Invoice #:</span> <span id="invoice-num">INV-2024-001</span></p>
                            <p><span class="font-medium text-gray-700">Issue Date:</span> <span id="issue-date">January 15, 2024</span></p>
                            <p><span class="font-medium text-gray-700">Due Date:</span> <span id="due-date">January 30, 2024</span></p>
                            <p id="payment-date-row" class="hidden"><span class="font-medium text-gray-700">Payment Date:</span> <span id="payment-date">January 15, 2024</span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Provider & Client Info -->
            <div class="px-8 py-6 border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Service Provider</h4>
                        <div class="flex items-start">
                            <img id="provider-avatar" class="h-16 w-16 rounded-full object-cover mr-4" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150" alt="Provider">
                            <div class="text-sm">
                                <p class="font-medium text-gray-900 text-lg" id="provider-name">Sarah Johnson</p>
                                <p class="text-gray-600 mb-2" id="provider-title">Professional Cleaner</p>
                                <p class="text-gray-600" id="provider-email">sarah.johnson@email.com</p>
                                <p class="text-gray-600" id="provider-phone">(555) 987-6543</p>
                                <div class="mt-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Verified Provider
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Bill To</h4>
                        <div class="text-sm">
                            <p class="font-medium text-gray-900 text-lg" id="client-name">Jennifer Wilson</p>
                            <p class="text-gray-600 mb-2" id="client-email">jennifer.wilson@email.com</p>
                            <p class="text-gray-600" id="client-phone">(555) 123-4567</p>
                            <div class="mt-3 text-gray-600" id="client-address">
                                <p>123 Main Street</p>
                                <p>Downtown, City 12345</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Summary -->
            <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Service Summary</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Service Type</p>
                        <p class="text-lg font-semibold text-gray-900" id="service-type">Deep Cleaning Service</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Service Date</p>
                        <p class="text-lg font-semibold text-gray-900" id="service-date">January 15, 2024</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Duration</p>
                        <p class="text-lg font-semibold text-gray-900" id="service-duration">3 hours</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Service Description</p>
                    <p class="text-gray-600" id="service-description">Complete deep cleaning of 2-bedroom apartment including kitchen and bathrooms. Focus on detailed cleaning of all surfaces, appliances, and fixtures.</p>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="px-8 py-6 border-b border-gray-200">
                <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Invoice Items</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 text-sm font-medium text-gray-900">Description</th>
                                <th class="text-center py-3 text-sm font-medium text-gray-900">Qty</th>
                                <th class="text-right py-3 text-sm font-medium text-gray-900">Rate</th>
                                <th class="text-right py-3 text-sm font-medium text-gray-900">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-items">
                            <!-- Items will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="px-8 py-6">
                <div class="flex justify-end">
                    <div class="w-80">
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="text-gray-900 font-medium" id="subtotal">$175.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Platform Fee (5%):</span>
                                <span class="text-gray-900 font-medium" id="platform-fee">$8.75</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax (8.5%):</span>
                                <span class="text-gray-900 font-medium" id="tax">$14.88</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold text-gray-900">Total:</span>
                                    <span class="text-lg font-semibold text-gray-900" id="total">$198.63</span>
                                </div>
                            </div>
                            <div id="amount-paid-row" class="flex justify-between text-green-600">
                                <span class="font-medium">Amount Paid:</span>
                                <span class="font-medium" id="amount-paid">$198.63</span>
                            </div>
                            <div id="amount-due-row" class="flex justify-between text-red-600 hidden">
                                <span class="font-medium">Amount Due:</span>
                                <span class="font-medium" id="amount-due">$0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="px-8 py-6 bg-gray-50 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Payment Information</h4>
                        <div class="text-sm space-y-2" id="payment-info">
                            <p><span class="font-medium text-gray-700">Payment Method:</span> <span id="payment-method">Visa ****1234</span></p>
                            <p><span class="font-medium text-gray-700">Transaction ID:</span> <span id="transaction-id">txn_1234567890</span></p>
                            <p><span class="font-medium text-gray-700">Authorization Code:</span> <span id="auth-code">AUTH123456</span></p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 uppercase tracking-wide mb-4">Additional Notes</h4>
                        <div class="text-sm text-gray-600" id="notes">
                            <p>Service completed successfully. Client was very satisfied with the quality of work. All areas were cleaned thoroughly as requested. Thank you for choosing our services!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-8 py-6 border-t border-gray-200 text-center bg-gray-50">
                <div class="text-sm text-gray-600">
                    <p class="mb-2 font-medium">Thank you for your business!</p>
                    <p>For questions about this invoice, please contact us at support@servicepro.com or (555) 123-4567</p>
                    <p class="mt-4 text-xs">This invoice was generated electronically and is valid without a signature.</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons for Mobile -->
        <div class="mt-6 print:hidden sm:hidden">
            <div class="grid grid-cols-2 gap-3">
                <button onclick="window.print()" class="w-full bg-indigo-600 text-white px-4 py-3 rounded-md text-sm font-medium hover:bg-indigo-700">
                    Print Invoice
                </button>
                <button onclick="downloadPDF()" class="w-full bg-green-600 text-white px-4 py-3 rounded-md text-sm font-medium hover:bg-green-700">
                    Download PDF
                </button>
            </div>
            <div class="grid grid-cols-2 gap-3 mt-3">
                <button onclick="sendInvoice()" class="w-full border border-gray-300 text-gray-700 px-4 py-3 rounded-md text-sm font-medium hover:bg-gray-50">
                    Send Invoice
                </button>
                <button onclick="editInvoice()" class="w-full border border-gray-300 text-gray-700 px-4 py-3 rounded-md text-sm font-medium hover:bg-gray-50">
                    Edit Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Send Invoice Modal -->
<div id="send-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Send Invoice</h3>
            <form id="send-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" id="send-email" value="jennifer.wilson@email.com" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <input type="text" id="send-subject" value="Invoice #INV-2024-001 from ServicePro" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                    <textarea id="send-message" rows="4" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Dear Jennifer,

Please find attached your invoice for the deep cleaning service. Payment is due within 15 days.

Thank you for your business!

Best regards,
Sarah Johnson"></textarea>
                </div>
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeSendModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                        Send Invoice
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
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

        .print\:max-w-none {
            max-width: none !important;
        }

        .print\:shadow-none {
            box-shadow: none !important;
        }

        .print\:rounded-none {
            border-radius: 0 !important;
        }

        #invoice-content {
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        @page {
            margin: 0.5in;
            size: letter;
        }

        .break-inside-avoid {
            break-inside: avoid;
        }
    }
</style>
@vite(['resources/js/single-invoice-page.js'])