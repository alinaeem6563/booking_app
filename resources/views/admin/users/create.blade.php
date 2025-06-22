@extends('layouts.app')

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
    }" class="min-h-screen bg-gray-50"
        :class="sidebarCollapsed ? 'sidebar-collapsed' : 'sidebar-expanded'">
        @include('navigation.sidebar')
        <!-- Main Content -->
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64"
            :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">
            <!-- Top Header -->
            @include('navigation.UserHeader')

            <!-- Main Content -->
            <main class="relative container mx-auto px-4 sm:px-6 lg:px-8 pb-12 pt-4">
                <div class="max-w-full mx-auto">



                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-6 bg-green-50/80 backdrop-blur-sm border border-green-200 rounded-xl p-4">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50/80 backdrop-blur-sm border border-red-200 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <svg class="h-5 w-5 text-red-400 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                            </div>
                            <ul class="list-disc pl-5 space-y-1 text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- User Creation Form -->
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden p-8 mb-6">
                        <!-- Admin Header Section -->
                        <div class="text-center mb-8">
                            <div
                                class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h1
                                class="text-3xl font-bold bg-indigo-600 bg-clip-text text-transparent mb-2">
                                Create New User
                            </h1>

                            <h2 class="text-2xl font-bold text-gray-900 mb-2">User Information</h2>
                            <p class="text-gray-600">Fill in the details for the new user account</p>
                        </div>

                        <form method="POST" action="{{ route('admin.users.store') }}" x-data="adminUserForm()">
                            @csrf

                            <!-- Name Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">First
                                        Name *</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="first_name" name="first_name"
                                            placeholder="Enter first name" required value="{{ old('first_name') }}"
                                            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white">
                                    </div>
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">Last Name
                                        *</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="last_name" name="last_name" placeholder="Enter last name"
                                            required value="{{ old('last_name') }}"
                                            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white">
                                    </div>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="mb-6">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address
                                    *</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                        </svg>
                                    </div>
                                    <input type="email" id="email" name="email" placeholder="Enter email address"
                                        required value="{{ old('email') }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white">
                                </div>
                            </div>

                            <!-- Phone Field -->
                            <div class="mb-6">
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone
                                    Number</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="tel" id="phone" name="phone" placeholder="Enter phone number"
                                        value="{{ old('phone') }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white">
                                </div>
                            </div>

                            <!-- Password Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password
                                        *</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                            placeholder="Create a password" required x-model="password"
                                            @input="checkPasswordStrength"
                                            class="w-full pl-12 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white">
                                        <button type="button" @click="showPassword = !showPassword"
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Password Strength Indicator -->
                                    <div x-show="password.length > 0" class="mt-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="h-2 rounded-full transition-all duration-300"
                                                    :class="{
                                                        'bg-red-500 w-1/4': passwordStrength === 'weak',
                                                        'bg-yellow-500 w-2/4': passwordStrength === 'medium',
                                                        'bg-green-500 w-3/4': passwordStrength === 'strong',
                                                        'bg-green-600 w-full': passwordStrength === 'very-strong'
                                                    }">
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium"
                                                :class="{
                                                    'text-red-600': passwordStrength === 'weak',
                                                    'text-yellow-600': passwordStrength === 'medium',
                                                    'text-green-600': passwordStrength === 'strong' ||
                                                        passwordStrength === 'very-strong'
                                                }"
                                                x-text="passwordStrength.charAt(0).toUpperCase() + passwordStrength.slice(1).replace('-', ' ')"></span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="password_confirmation"
                                        class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password *</label>
                                    <div class="relative group">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input :type="showConfirmPassword ? 'text' : 'password'" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirm password" required
                                            x-model="confirmPassword"
                                            class="w-full pl-12 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-gray-50/50 focus:bg-white">
                                        <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                            <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                    <!-- Password Match Indicator -->
                                    <div x-show="confirmPassword.length > 0" class="mt-2">
                                        <div class="flex items-center space-x-2">
                                            <svg x-show="password === confirmPassword && password.length > 0"
                                                class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <svg x-show="password !== confirmPassword || password.length === 0"
                                                class="h-4 w-4 text-red-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span class="text-xs"
                                                :class="password === confirmPassword && password.length > 0 ? 'text-green-600' :
                                                    'text-red-600'"
                                                x-text="password === confirmPassword && password.length > 0 ? 'Passwords match' : 'Passwords do not match'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Type Selection -->
                            <div class="mb-8">
                                <label class="block text-sm font-semibold text-gray-700 mb-4">Account Type *</label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- User Account -->
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="account_type" value="user" class="sr-only"
                                            x-model="accountType"
                                            {{ old('account_type', 'user') == 'user' ? 'checked' : '' }}>
                                        <div class="p-6 border-2 rounded-xl transition-all duration-200 hover:shadow-md"
                                            :class="accountType === 'user' ? 'border-indigo-500 bg-indigo-50' :
                                                'border-gray-200 hover:border-gray-300'">
                                            <div class="flex flex-col items-center text-center">
                                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3"
                                                    :class="accountType === 'user' ? 'bg-indigo-100' : 'bg-gray-100'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        :class="accountType === 'user' ? 'text-indigo-600' :
                                                            'text-gray-600'"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <h3 class="font-semibold text-gray-900 mb-1">Customer</h3>
                                                <p class="text-sm text-gray-600">Can book services</p>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Provider Account -->
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="account_type" value="provider" class="sr-only"
                                            x-model="accountType" {{ old('account_type') == 'provider' ? 'checked' : '' }}>
                                        <div class="p-6 border-2 rounded-xl transition-all duration-200 hover:shadow-md"
                                            :class="accountType === 'provider' ? 'border-indigo-500 bg-indigo-50' :
                                                'border-gray-200 hover:border-gray-300'">
                                            <div class="flex flex-col items-center text-center">
                                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3"
                                                    :class="accountType === 'provider' ? 'bg-indigo-100' : 'bg-gray-100'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        :class="accountType === 'provider' ? 'text-indigo-600' :
                                                            'text-gray-600'"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6" />
                                                    </svg>
                                                </div>
                                                <h3 class="font-semibold text-gray-900 mb-1">Service Provider</h3>
                                                <p class="text-sm text-gray-600">Can offer services</p>
                                            </div>
                                        </div>
                                    </label>

                                    <!-- Admin Account -->
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="account_type" value="admin" class="sr-only"
                                            x-model="accountType" {{ old('account_type') == 'admin' ? 'checked' : '' }}>
                                        <div class="p-6 border-2 rounded-xl transition-all duration-200 hover:shadow-md"
                                            :class="accountType === 'admin' ? 'border-indigo-500 bg-indigo-50' :
                                                'border-gray-200 hover:border-gray-300'">
                                            <div class="flex flex-col items-center text-center">
                                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3"
                                                    :class="accountType === 'admin' ? 'bg-indigo-100' : 'bg-gray-100'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                                                        :class="accountType === 'admin' ? 'text-indigo-600' :
                                                            'text-gray-600'"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                                <h3 class="font-semibold text-gray-900 mb-1">Administrator</h3>
                                                <p class="text-sm text-gray-600">Full platform access</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Account Status -->
                            <div class="mb-8">
                                <label class="block text-sm font-semibold text-gray-700 mb-4">Account Status</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="active" class="sr-only"
                                            x-model="accountStatus" checked>
                                        <div class="p-4 border-2 rounded-xl transition-all duration-200 hover:shadow-md"
                                            :class="accountStatus === 'active' ? 'border-green-500 bg-green-50' :
                                                'border-gray-200 hover:border-gray-300'">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3"
                                                    :class="accountStatus === 'active' ? 'bg-green-100' : 'bg-gray-100'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        :class="accountStatus === 'active' ? 'text-green-600' :
                                                            'text-gray-600'"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">Active</h3>
                                                    <p class="text-sm text-gray-600">User can access the platform</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="status" value="inactive" class="sr-only"
                                            x-model="accountStatus">
                                        <div class="p-4 border-2 rounded-xl transition-all duration-200 hover:shadow-md"
                                            :class="accountStatus === 'inactive' ? 'border-red-500 bg-red-50' :
                                                'border-gray-200 hover:border-gray-300'">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3"
                                                    :class="accountStatus === 'inactive' ? 'bg-red-100' : 'bg-gray-100'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        :class="accountStatus === 'inactive' ? 'text-red-600' : 'text-gray-600'"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">Inactive</h3>
                                                    <p class="text-sm text-gray-600">User cannot access the platform</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Email Verification -->
                            <div class="mb-8">
                                <label class="flex items-start cursor-pointer">
                                    <input name="email_verified" type="checkbox" value="1" x-model="emailVerified"
                                        class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-colors">
                                    <div class="ml-3">
                                        <span class="text-sm font-semibold text-gray-700">Mark email as verified</span>
                                        <p class="text-xs text-gray-500 mt-1">Check this if the user's email should be
                                            considered verified immediately</p>
                                    </div>
                                </label>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button type="submit"
                                    class="flex-1 bg-indigo-600  hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg">
                                    <span class="flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        Create User Account
                                    </span>
                                </button>

                                <a href="{{ route('dashboard') }}"
                                    class="flex-1 sm:flex-none bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <span class="flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                        Cancel
                                    </span>
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- Admin Notes -->
                    <div
                        class="bg-blue-50/80 backdrop-blur-sm rounded-2xl shadow-lg border border-blue-200/50 overflow-hidden p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-blue-900 mb-1">Admin Notes</h3>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Users will receive a welcome email with their login credentials</li>
                                    <li>• Password requirements: minimum 8 characters with numbers and special characters
                                    </li>
                                    <li>• Email verification can be set immediately or require user action</li>
                                    <li>• Account status can be changed later from the user management panel</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    @endsection

    <script>
        function adminUserForm() {
            return {
                // Form state
                showPassword: false,
                showConfirmPassword: false,
                password: '',
                confirmPassword: '',
                passwordStrength: 'weak',
                accountType: @json(old('account_type', 'user')),
                accountStatus: 'active',
                emailVerified: true,

                checkPasswordStrength() {
                    const password = this.password;
                    let strength = 0;

                    // Length check
                    if (password.length >= 8) strength++;
                    if (password.length >= 12) strength++;

                    // Character variety checks
                    if (/[a-z]/.test(password)) strength++;
                    if (/[A-Z]/.test(password)) strength++;
                    if (/[0-9]/.test(password)) strength++;
                    if (/[^A-Za-z0-9]/.test(password)) strength++;

                    // Set strength level
                    if (strength <= 2) {
                        this.passwordStrength = 'weak';
                    } else if (strength <= 4) {
                        this.passwordStrength = 'medium';
                    } else if (strength <= 5) {
                        this.passwordStrength = 'strong';
                    } else {
                        this.passwordStrength = 'very-strong';
                    }
                }
            };
        }
    </script>
