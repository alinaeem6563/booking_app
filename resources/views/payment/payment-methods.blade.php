@extends('layouts.app')

@section('title', 'Payment Methods')

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
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64" 
             :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">
             <!-- Top Header -->
             @include('navigation.UserHeader')
            
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg mb-6 mt-4">
                <div class="px-6 py-8 text-white">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h1 class="text-3xl font-bold mb-2">Payment Methods</h1>
                            <p class="text-indigo-100">Manage your payment methods and payout settings</p>
                        </div>
                        <button onclick="addPaymentMethod()"
                            class="bg-white/20 backdrop-blur-sm text-white px-6 py-3 rounded-lg text-sm font-medium hover:bg-white/30 transition-all duration-200 border border-white/20">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Payment Method
                        </button>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div class="flex items-center">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-indigo-100">Total Methods</p>
                                    <p class="text-xl font-semibold" id="total-methods">0</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div class="flex items-center">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-indigo-100">Verified</p>
                                    <p class="text-xl font-semibold" id="verified-methods">0</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                            <div class="flex items-center">
                                <div class="p-2 bg-white/20 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-indigo-100">Default Set</p>
                                    <p class="text-xl font-semibold" id="default-set">Yes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Payment Methods -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8 border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Your Payment Methods</h3>
                            <p class="text-sm text-gray-600 mt-1">Manage your payment methods and set your default</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Secure
                            </span>
                        </div>
                    </div>
                </div>

                <div id="payment-methods-list" class="divide-y divide-gray-100">
                    <!-- Payment methods will be inserted here by JavaScript -->
                </div>

                <!-- Empty State -->
                <div id="empty-state" class="text-center py-12 hidden">
                    <div class="mx-auto h-12 w-12 text-gray-400 mb-4">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No payment methods</h3>
                    <p class="text-gray-600 mb-4">Add your first payment method to start receiving payments</p>
                    <button onclick="addPaymentMethod()" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:from-indigo-600 hover:to-rose-600 transition-all duration-200">
                        Add Payment Method
                    </button>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-indigo-800">Security & Privacy</h3>
                        <div class="mt-2 text-sm text-indigo-700">
                            <p>Your payment information is encrypted and secure. We never store sensitive financial data on our servers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Method Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border-0 w-full max-w-md shadow-2xl rounded-2xl bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">Add Payment Method</h3>
                    <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form id="payment-form" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                        <select id="payment-type" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <option value="bank">🏦 Bank Account</option>
                            <option value="paypal">💙 PayPal</option>
                            <option value="stripe">💜 Stripe Connect</option>
                        </select>
                    </div>

                    <div id="bank-fields" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Account Holder Name</label>
                            <input type="text" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bank Name</label>
                            <input type="text" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="Chase Bank">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Account Number</label>
                            <input type="text" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="****1234">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Routing Number</label>
                            <input type="text" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="021000021">
                        </div>
                    </div>

                    <div id="paypal-fields" class="space-y-4 hidden">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PayPal Email</label>
                            <input type="email" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors" placeholder="your@email.com">
                        </div>
                    </div>

                    <div id="stripe-fields" class="space-y-4 hidden">
                        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                            <p class="text-sm text-indigo-700">You'll be redirected to Stripe to complete the setup process securely.</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-100">
                        <button type="button" onclick="closePaymentModal()" class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:from-indigo-600 hover:to-purple-600 transition-all duration-200">
                            Add Payment Method
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@vite(['resources/js/payment-methods.js'])
