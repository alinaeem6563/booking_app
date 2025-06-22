<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookEase - Coupon Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body class="font-[Inter] bg-gray-50 text-gray-900">
    <div x-data="{ sidebarOpen: false }">
        <!-- Mobile sidebar backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity md:hidden"
            x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- Sidebar -->
        <div x-show="sidebarOpen"
            class="fixed inset-y-0 left-0 z-30 w-64 transform overflow-y-auto bg-white transition duration-300 md:translate-x-0 md:static md:inset-0"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
            <div class="flex items-center justify-between p-4 border-b">
                <div class="flex items-center">
                    <svg class="h-8 w-auto text-indigo-600" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span class="ml-2 text-xl font-bold">BookEase</span>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden">
                    <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="mt-4 px-2">
                <div class="mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Main
                </div>
                <a href="#"
                    class="flex items-center px-4 py-3 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <div class="mt-6 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Users
                </div>
                <a href="#"
                    class="flex items-center px-4 py-3 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Customers
                </a>
                <a href="#"
                    class="flex items-center px-4 py-3 mt-1 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Service Providers
                </a>

                <div class="mt-6 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Content
                </div>
                <a href="#"
                    class="flex items-center px-4 py-3 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Service Categories
                </a>

                <div class="mt-6 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Marketing
                </div>
                <a href="#" class="flex items-center px-4 py-3 text-sm rounded-lg bg-indigo-50 text-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    Coupons
                </a>
                <a href="#"
                    class="flex items-center px-4 py-3 mt-1 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    Promotions
                </a>

                <div class="mt-6 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Finances
                </div>
                <a href="#"
                    class="flex items-center px-4 py-3 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Transactions
                </a>

                <div class="mt-6 mb-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    System
                </div>
                <a href="#"
                    class="flex items-center px-4 py-3 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </a>
                <a href="#"
                    class="flex items-center px-4 py-3 mt-1 text-sm rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
            <!-- Top Header -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between h-16 px-4 md:px-6 lg:px-8">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen"
                            class="text-gray-500 focus:outline-none md:hidden">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </button>
                        <h1 class="text-xl font-bold text-gray-800 ml-2 md:ml-0">Coupon Management</h1>
                    </div>

                    <div class="flex items-center">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center focus:outline-none">
                                <div
                                    class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold">
                                    AD
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-700 hidden md:block">Admin User</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-gray-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                                style="display: none;">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your
                                    Profile</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-4 md:p-6 lg:p-8" x-data="couponManager()">
                <!-- Page Header with Actions -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">All Coupons</h2>
                        <p class="mt-1 text-sm text-gray-600">Manage discount coupons for your platform</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                        <button @click="openCreateModal()"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create New Coupon
                        </button>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" x-model="searchTerm" @input="filterCoupons()" id="search"
                                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Search by code or description">
                            </div>
                        </div>
                        <div class="w-full md:w-48">
                            <label for="status-filter"
                                class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status-filter" x-model="statusFilter" @change="filterCoupons()"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="all">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="expired">Expired</option>
                            </select>
                        </div>
                        <div class="w-full md:w-48">
                            <label for="type-filter" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select id="type-filter" x-model="typeFilter" @change="filterCoupons()"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="all">All Types</option>
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Coupons Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Code</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Discount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Validity</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Usage / Limit</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="coupon in filteredCoupons" :key="coupon.id">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"
                                                        x-text="coupon.code"></div>
                                                    <div class="text-sm text-gray-500" x-text="coupon.description">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900" x-text="formatDiscount(coupon)"></div>
                                            <div class="text-xs text-gray-500" x-show="coupon.min_order_amount > 0">
                                                Min. Order: $<span x-text="coupon.min_order_amount"></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900" x-text="formatDate(coupon.start_date)">
                                            </div>
                                            <div class="text-sm text-gray-500">to <span
                                                    x-text="formatDate(coupon.end_date)"></span></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span x-text="coupon.usage_count"></span> / <span
                                                x-text="coupon.usage_limit || '∞'"></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                :class="{
                                                    'bg-green-100 text-green-800': coupon.status === 'active',
                                                    'bg-red-100 text-red-800': coupon.status === 'inactive',
                                                    'bg-yellow-100 text-yellow-800': coupon.status === 'expired'
                                                }"
                                                x-text="coupon.status">
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button @click="openEditModal(coupon)"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                            <button @click="confirmDelete(coupon)"
                                                class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="filteredCoupons.length === 0">
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No coupons found matching your criteria.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <button
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Previous
                            </button>
                            <button
                                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Next
                            </button>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span>
                                    of <span class="font-medium" x-text="filteredCoupons.length"></span> results
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                    aria-label="Pagination">
                                    <a href="#"
                                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="#"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        1
                                    </a>
                                    <a href="#"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        2
                                    </a>
                                    <a href="#"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-indigo-50 text-sm font-medium text-indigo-600 hover:bg-gray-50">
                                        3
                                    </a>
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                        ...
                                    </span>
                                    <a href="#"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        8
                                    </a>
                                    <a href="#"
                                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create/Edit Coupon Modal -->
                <div x-show="showModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title"
                    role="dialog" aria-modal="true" style="display: none;">
                    <div
                        class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="showModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
                        </div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                            aria-hidden="true">&#8203;</span>

                        <div x-show="showModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div class="absolute top-0 right-0 pt-4 pr-4">
                                <button @click="closeModal()" type="button"
                                    class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title"
                                        x-text="isEditing ? 'Edit Coupon' : 'Create New Coupon'"></h3>
                                    <div class="mt-6">
                                        <form @submit.prevent="saveCoupon()">
                                            <div class="space-y-6">
                                                <div>
                                                    <label for="coupon-code"
                                                        class="block text-sm font-medium text-gray-700">Coupon Code
                                                        <span class="text-red-500">*</span></label>
                                                    <input type="text" x-model="currentCoupon.code"
                                                        id="coupon-code"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        required>
                                                    <p class="mt-1 text-xs text-gray-500">Unique code that customers
                                                        will enter at checkout.</p>
                                                </div>

                                                <div>
                                                    <label for="coupon-description"
                                                        class="block text-sm font-medium text-gray-700">Description</label>
                                                    <textarea x-model="currentCoupon.description" id="coupon-description" rows="2"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="discount-type"
                                                            class="block text-sm font-medium text-gray-700">Discount
                                                            Type <span class="text-red-500">*</span></label>
                                                        <select x-model="currentCoupon.discount_type"
                                                            id="discount-type"
                                                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                            required>
                                                            <option value="percentage">Percentage (%)</option>
                                                            <option value="fixed">Fixed Amount ($)</option>
                                                        </select>
                                                    </div>

                                                    <div>
                                                        <label for="discount-value"
                                                            class="block text-sm font-medium text-gray-700">Discount
                                                            Value <span class="text-red-500">*</span></label>
                                                        <div class="mt-1 relative rounded-md shadow-sm">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 sm:text-sm"
                                                                    x-text="currentCoupon.discount_type === 'percentage' ? '%' : '$'"></span>
                                                            </div>
                                                            <input type="number"
                                                                x-model="currentCoupon.discount_value"
                                                                id="discount-value"
                                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                                                :min="currentCoupon.discount_type === 'percentage' ? 1 : 0.01"
                                                                :max="currentCoupon.discount_type === 'percentage' ? 100 :
                                                                    null"
                                                                step="0.01" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="start-date"
                                                            class="block text-sm font-medium text-gray-700">Start Date
                                                            <span class="text-red-500">*</span></label>
                                                        <input type="text" x-model="currentCoupon.start_date"
                                                            id="start-date"
                                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md datepicker"
                                                            placeholder="YYYY-MM-DD" required>
                                                    </div>

                                                    <div>
                                                        <label for="end-date"
                                                            class="block text-sm font-medium text-gray-700">End Date
                                                            <span class="text-red-500">*</span></label>
                                                        <input type="text" x-model="currentCoupon.end_date"
                                                            id="end-date"
                                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md datepicker"
                                                            placeholder="YYYY-MM-DD" required>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label for="usage-limit"
                                                            class="block text-sm font-medium text-gray-700">Usage
                                                            Limit</label>
                                                        <input type="number" x-model="currentCoupon.usage_limit"
                                                            id="usage-limit"
                                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                            min="0">
                                                        <p class="mt-1 text-xs text-gray-500">Leave empty for unlimited
                                                            usage.</p>
                                                    </div>

                                                    <div>
                                                        <label for="min-order-amount"
                                                            class="block text-sm font-medium text-gray-700">Minimum
                                                            Order Amount</label>
                                                        <div class="mt-1 relative rounded-md shadow-sm">
                                                            <div
                                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                                <span class="text-gray-500 sm:text-sm">$</span>
                                                            </div>
                                                            <input type="number"
                                                                x-model="currentCoupon.min_order_amount"
                                                                id="min-order-amount"
                                                                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                                                                min="0" step="0.01">
                                                        </div>
                                                        <p class="mt-1 text-xs text-gray-500">Minimum order amount
                                                            required to use this coupon.</p>
                                                    </div>
                                                </div>

                                                <div>
                                                    <label for="coupon-status"
                                                        class="block text-sm font-medium text-gray-700">Status</label>
                                                    <select x-model="currentCoupon.status" id="coupon-status"
                                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>

                                                <div class="flex justify-end space-x-3">
                                                    <button type="button" @click="closeModal()"
                                                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        <span
                                                            x-text="isEditing ? 'Update Coupon' : 'Create Coupon'"></span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delete Confirmation Modal -->
                <div x-show="showDeleteModal" class="fixed z-50 inset-0 overflow-y-auto"
                    aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
                    <div
                        class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
                        </div>

                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                            aria-hidden="true">&#8203;</span>

                        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div>
                                <div
                                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        Delete Coupon
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Are you sure you want to delete the coupon <span class="font-semibold"
                                                x-text="couponToDelete?.code"></span>? This action cannot be undone.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                <button type="button" @click="deleteCoupon()"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                                    Delete
                                </button>
                                <button type="button" @click="showDeleteModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function couponManager() {
            return {
                coupons: [{
                        id: 1,
                        code: 'WELCOME20',
                        description: 'Welcome discount for new customers',
                        discount_type: 'percentage',
                        discount_value: 20,
                        start_date: '2023-05-01',
                        end_date: '2023-12-31',
                        usage_limit: 1000,
                        usage_count: 345,
                        min_order_amount: 0,
                        status: 'active'
                    },
                    {
                        id: 2,
                        code: 'SUMMER10',
                        description: 'Summer sale discount',
                        discount_type: 'percentage',
                        discount_value: 10,
                        start_date: '2023-06-01',
                        end_date: '2023-08-31',
                        usage_limit: 500,
                        usage_count: 125,
                        min_order_amount: 50,
                        status: 'active'
                    },
                    {
                        id: 3,
                        code: 'FLAT25',
                        description: 'Flat discount on all services',
                        discount_type: 'fixed',
                        discount_value: 25,
                        start_date: '2023-04-15',
                        end_date: '2023-05-15',
                        usage_limit: 200,
                        usage_count: 200,
                        min_order_amount: 100,
                        status: 'expired'
                    },
                    {
                        id: 4,
                        code: 'CLEAN15',
                        description: 'Discount on cleaning services',
                        discount_type: 'percentage',
                        discount_value: 15,
                        start_date: '2023-05-01',
                        end_date: '2023-07-31',
                        usage_limit: 0,
                        usage_count: 78,
                        min_order_amount: 0,
                        status: 'active'
                    },
                    {
                        id: 5,
                        code: 'PREMIUM50',
                        description: 'Premium customer discount',
                        discount_type: 'fixed',
                        discount_value: 50,
                        start_date: '2023-05-10',
                        end_date: '2023-12-31',
                        usage_limit: 100,
                        usage_count: 12,
                        min_order_amount: 200,
                        status: 'inactive'
                    }
                ],
                filteredCoupons: [],
                searchTerm: '',
                statusFilter: 'all',
                typeFilter: 'all',
                showModal: false,
                showDeleteModal: false,
                isEditing: false,
                currentCoupon: {
                    id: null,
                    code: '',
                    description: '',
                    discount_type: 'percentage',
                    discount_value: 0,
                    start_date: '',
                    end_date: '',
                    usage_limit: 0,
                    usage_count: 0,
                    min_order_amount: 0,
                    status: 'active'
                },
                couponToDelete: null,

                init() {
                    this.filteredCoupons = [...this.coupons];

                    // Initialize date pickers after Alpine loads
                    this.$nextTick(() => {
                        this.initDatepickers();
                    });
                },

                initDatepickers() {
                    flatpickr('.datepicker', {
                        dateFormat: 'Y-m-d',
                        allowInput: true
                    });
                },

                filterCoupons() {
                    this.filteredCoupons = this.coupons.filter(coupon => {
                        // Search filter
                        const searchMatch = this.searchTerm === '' ||
                            coupon.code.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                            (coupon.description && coupon.description.toLowerCase().includes(this.searchTerm
                                .toLowerCase()));

                        // Status filter
                        const statusMatch = this.statusFilter === 'all' || coupon.status === this.statusFilter;

                        // Type filter
                        const typeMatch = this.typeFilter === 'all' || coupon.discount_type === this.typeFilter;

                        return searchMatch && statusMatch && typeMatch;
                    });
                },

                formatDiscount(coupon) {
                    if (coupon.discount_type === 'percentage') {
                        return `${coupon.discount_value}% off`;
                    } else {
                        return `$${coupon.discount_value.toFixed(2)} off`;
                    }
                },

                formatDate(dateString) {
                    const options = {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    };
                    return new Date(dateString).toLocaleDateString(undefined, options);
                },

                openCreateModal() {
                    this.isEditing = false;
                    this.currentCoupon = {
                        id: null,
                        code: '',
                        description: '',
                        discount_type: 'percentage',
                        discount_value: 0,
                        start_date: new Date().toISOString().split('T')[0],
                        end_date: new Date(new Date().setMonth(new Date().getMonth() + 1)).toISOString().split('T')[0],
                        usage_limit: 0,
                        usage_count: 0,
                        min_order_amount: 0,
                        status: 'active'
                    };
                    this.showModal = true;

                    // Initialize date pickers after modal is shown
                    this.$nextTick(() => {
                        this.initDatepickers();
                    });
                },

                openEditModal(coupon) {
                    this.isEditing = true;
                    this.currentCoupon = {
                        ...coupon
                    };
                    this.showModal = true;

                    // Initialize date pickers after modal is shown
                    this.$nextTick(() => {
                        this.initDatepickers();
                    });
                },

                closeModal() {
                    this.showModal = false;
                },

                saveCoupon() {
                    if (this.isEditing) {
                        // Update existing coupon
                        const index = this.coupons.findIndex(c => c.id === this.currentCoupon.id);
                        if (index !== -1) {
                            this.coupons[index] = {
                                ...this.currentCoupon
                            };
                        }
                    } else {
                        // Create new coupon
                        const newId = Math.max(...this.coupons.map(c => c.id), 0) + 1;
                        this.coupons.push({
                            ...this.currentCoupon,
                            id: newId,
                            usage_count: 0
                        });
                    }

                    // Update filtered coupons
                    this.filterCoupons();

                    // Close modal
                    this.closeModal();

                    // Show success message (could be implemented with a toast notification)
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: this.isEditing ? 'Coupon updated successfully!' : 'Coupon created successfully!',
                        confirmButtonColor: '#4338CA',
                    });

                },

                confirmDelete(coupon) {
                    this.couponToDelete = coupon;
                    this.showDeleteModal = true;
                },

                deleteCoupon() {
                    if (this.couponToDelete) {
                        // Remove coupon from array
                        this.coupons = this.coupons.filter(c => c.id !== this.couponToDelete.id);

                        // Update filtered coupons
                        this.filterCoupons();

                        // Close modal
                        this.showDeleteModal = false;

                        // Show success message (could be implemented with a toast notification)
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Coupon deleted successfully!',
                            confirmButtonColor: '#4338CA',
                        });

                    }
                }
            };
        }
    </script>
</body>

</html>
