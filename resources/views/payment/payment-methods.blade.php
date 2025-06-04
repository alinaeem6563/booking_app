@extends('layouts.app')

@section('title', 'Payment Methods')

@section('content')
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
    @include('navigation.sidebar')
    <!-- Main Content -->
    <div class="flex-1 p-4">
        <!-- Top Header -->
        @include('navigation.UserHeader')
          <!-- Header -->
    <div class="bg-white shadow mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900">Payment Methods</h1>
                <button onclick="addPaymentMethod()" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                    Add Payment Method
                </button>
            </div>
        </div>
    </div>
        <!-- Current Payment Methods -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Your Payment Methods</h3>
                <p class="text-sm text-gray-500 mt-1">Manage how you receive payments from clients</p>
            </div>
            
            <div id="payment-methods-list" class="divide-y divide-gray-200">
                <!-- Payment methods will be inserted here by JavaScript -->
            </div>
        </div>

        <!-- Payout Settings -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Payout Settings</h3>
                <p class="text-sm text-gray-500 mt-1">Configure when and how you receive your earnings</p>
            </div>
            
            <div class="p-6">
                <form class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payout Schedule</label>
                        <select class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="weekly">Weekly (Every Monday)</option>
                            <option value="biweekly">Bi-weekly (Every other Monday)</option>
                            <option value="monthly">Monthly (1st of each month)</option>
                            <option value="manual">Manual (Request when needed)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Payout Amount</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" class="pl-7 w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" value="50" min="1">
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Minimum amount before automatic payout is triggered</p>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="email-notifications" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="email-notifications" class="ml-2 block text-sm text-gray-900">
                            Email me when payouts are processed
                        </label>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Method Modal -->
<div id="payment-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add Payment Method</h3>
            <form id="payment-form" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                    <select id="payment-type" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="bank">Bank Account</option>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                    </select>
                </div>
                
                <div id="bank-fields" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Holder Name</label>
                        <input type="text" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                        <input type="text" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                        <input type="text" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Routing Number</label>
                        <input type="text" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                
                <div id="paypal-fields" class="space-y-4 hidden">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">PayPal Email</label>
                        <input type="email" class="w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                        Add Payment Method
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@vite(['resources/js/payment-methods.js'])