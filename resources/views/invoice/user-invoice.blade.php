@extends('layouts.app')

@section('title', 'Invoices')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        
        #printable-invoice,
        #printable-invoice * {
            visibility: visible;
        }
        
        #printable-invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: white !important;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .print-header {
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .print-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        .print-table th,
        .print-table td {
            border: 1px solid #e5e7eb;
            padding: 8px 12px;
            text-align: left;
        }
        
        .print-table th {
            background-color: #f9fafb !important;
            font-weight: 600;
        }
        
        .print-total {
            background-color: #f0f9ff !important;
            border: 2px solid #4f46e5 !important;
            padding: 15px;
            margin-top: 20px;
        }
        
        @page {
            margin: 0.5in;
            size: A4;
        }
    }
    </style>
@section('content')
<div x-data="{ 
    sidebarOpen: false, 
    sidebarCollapsed: window.innerWidth >= 768 ? false : true,
    toggleSidebar() {
        if (window.innerWidth >= 768) {
            this.sidebarCollapsed = !this.sidebarCollapsed;
        } else {
            this.sidebarOpen = !this.sidebarOpen;
        }
    }
}" 
class="min-h-screen bg-gray-50"
:class="sidebarCollapsed ? 'sidebar-collapsed' : 'sidebar-expanded'">
        @include('navigation.sidebar')
        <!-- Main Content -->
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64 pb-12" 
             :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">
             <!-- Top Header -->
             @include('navigation.UserHeader')
        
           <!-- Modern Gradient Header -->
           <div class="relative overflow-hidden bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-xl mt-6 mb-8">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>
            
            <div class="relative px-8 py-12">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8">
                    <div class="text-white">
                        <h1 class="text-4xl font-bold mb-3"> Invoice Management</h1>
                        <p class="text-indigo-100 text-lg font-medium mb-6">Track and manage your billing records</p>
                        
                        <!-- Quick Stats -->
                        <div class="grid grid-cols-2 gap-6">
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                                <div class="text-2xl font-bold" id="paid-amount">${{$totalConfirmedAmount ?? '0.00'}}</div>
                                <div class="text-indigo-100 text-sm font-medium"> Paid Invoices</div>
                                <div class="text-indigo-200 text-xs">{{$confirmedCount ?? 0}} invoices</div>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 border border-white/30">
                                <div class="text-2xl font-bold" id="pending-amount">${{$totalPendingAmount ?? '0.00'}}</div>
                                <div class="text-indigo-100 text-sm font-medium"> Pending</div>
                                <div class="text-indigo-200 text-xs">{{$pendingCount ?? 0}} invoices</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search -->
                    <div class="w-full lg:w-96">
                        <div class="relative">
                            <input type="text" id="search-invoices" placeholder="Search invoices..." 
                                class="w-full px-5 py-4 text-gray-900 bg-white/95 backdrop-blur-sm border border-white/30 rounded-xl focus:ring-2 focus:ring-white/50 focus:border-white/50 transition-all duration-200 placeholder-gray-500 shadow-lg">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Filters -->
        <div class="bg-white rounded-2xl shadow-sm p-8 mb-8 border border-gray-100">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900">Smart Filters</h3>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3"> Status</label>
                    <select id="status-filter" class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="">All Status</option>
                        <option value="confirmed"> Paid</option>
                        <option value="pending"> Pending</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3"> Date Range</label>
                    <select id="date-filter" class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="">All Time</option>
                        <option value="this-month">This Month</option>
                        <option value="last-month">Last Month</option>
                        <option value="this-quarter">This Quarter</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3"> Sort By</label>
                    <select id="sort-filter" class="w-full px-4 py-3 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="date-desc">Latest First</option>
                        <option value="date-asc">Oldest First</option>
                        <option value="amount-desc">High Amount</option>
                        <option value="amount-asc">Low Amount</option>
                    </select>
                </div>
            </div>
        </div>


        <!-- Clean Responsive Table/Cards -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <!-- Mobile Card View -->
            <div class="block lg:hidden" id="mobile-invoices">
                <!-- Mobile cards will be inserted here by JavaScript -->
            </div>
            
            <!-- Desktop Table View -->
            <div class="hidden lg:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Invoice
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Client
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Amount
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody id="invoices-tbody" class="divide-y divide-gray-100">
                            <!-- Desktop table rows will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="invoice-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div id="modal-title">
                    <!-- Dynamic title content -->
                </div>
                <button onclick="closeInvoiceModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div id="modal-content" class="p-6">
            <!-- Dynamic invoice content will be inserted here -->
        </div>
    </div>
</div>

{{-- Print-only Invoice Template --}}
<div id="printable-invoice" class="hidden print:block">
    <!-- This will be populated dynamically for printing -->
</div>

@endsection
<script>
    const invoices = @json($invoices ?? []);
</script>
@vite('resources/js/invoices.js')
