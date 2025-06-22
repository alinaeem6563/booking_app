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
}" 
class="min-h-screen bg-gray-50"
:class="sidebarCollapsed ? 'sidebar-collapsed' : 'sidebar-expanded'">
        @include('navigation.sidebar')
        <!-- Main Content -->
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64" 
             :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">
             <!-- Top Header -->
             @include('navigation.UserHeader')


            <!-- Dashboard Content -->
            <div class="p-4 md:p-3 lg:p-3">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 md:p-8 text-white relative overflow-hidden  lg:p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-br bg-white rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 lg:w-10 lg:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-2xl lg:text-3xl font-bold text-white ">
                                    {{ __('Profile Settings') }}
                                </h1>
                                <p class="text-white  mt-1">
                                    {{ __('Manage your account settings and preferences') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-xl">
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm font-medium text-emerald-700">{{ __('Account Active') }}</span>
                                </div>
                            </div>
                            <div class="text-sm text-white ">
                                <span class="block lg:inline">{{ __('Last updated:') }}</span>
                                <span class="font-medium text-white  block lg:inline lg:ml-1">
                                    {{ auth()->user()->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-full mx-auto">
                <!-- Profile Navigation Tabs -->
                <div x-data="{ activeTab: 'profile' }" class="space-y-6 mx-2">
                    <!-- Modern Tab Navigation -->
                    <div class="max-w-full bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-2">
                            <nav class="flex space-x-1 overflow-x-auto scrollbar-hide">
                                <button @click="activeTab = 'profile'"
                                    :class="{ 
                                        'bg-indigo-500 text-white shadow-lg': activeTab === 'profile', 
                                        'text-gray-600 hover:text-gray-900 hover:bg-gray-50': activeTab !== 'profile' 
                                    }"
                                    class="flex items-center space-x-2 px-4 py-3 rounded-xl font-medium text-sm transition-all duration-200 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ __('Profile Information') }}</span>
                                </button>
                                
                                <button @click="activeTab = 'password'"
                                    :class="{ 
                                        'bg-indigo-500 text-white shadow-lg': activeTab === 'password', 
                                        'text-gray-600 hover:text-gray-900 hover:bg-gray-50': activeTab !== 'password' 
                                    }"
                                    class="flex items-center space-x-2 px-4 py-3 rounded-xl font-medium text-sm transition-all duration-200 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <span>{{ __('Security') }}</span>
                                </button>
                                
                                <button @click="activeTab = 'delete'"
                                    :class="{ 
                                        'bg-red-500 text-white shadow-lg': activeTab === 'delete', 
                                        'text-gray-600 hover:text-gray-900 hover:bg-gray-50': activeTab !== 'delete' 
                                    }"
                                    class="flex items-center space-x-2 px-4 py-3 rounded-xl font-medium text-sm transition-all duration-200 whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>{{ __('Danger Zone') }}</span>
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                        <!-- Main Content Area -->
                        <div class="xl:col-span-2 space-y-6">
                            <!-- Profile Information Tab -->
                            <div x-show="activeTab === 'profile'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="p-6 lg:p-8">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                {{ __('Profile Information') }}
                                            </h3>
                                            <p class="text-gray-600 text-sm">
                                                {{ __("Update your account's profile information and email address.") }}
                                            </p>
                                        </div>
                                    </div>

                                    @include('profile.partials.update-profile-information-form')
                                </div>
                            </div>

                            <!-- Password Tab -->
                            <div x-show="activeTab === 'password'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="p-6 lg:p-8">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                {{ __('Update Password') }}
                                            </h3>
                                            <p class="text-gray-600 text-sm">
                                                {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                            </p>
                                        </div>
                                    </div>

                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>

                            <!-- Delete Account Tab -->
                            <div x-show="activeTab === 'delete'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-y-4"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="p-6 lg:p-8">
                                    <div class="flex items-center space-x-3 mb-6">
                                        <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-semibold text-gray-900">
                                                {{ __('Delete Account') }}
                                            </h3>
                                            <p class="text-gray-600 text-sm">
                                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Warning Alert -->
                                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                                        <div class="flex items-start space-x-3">
                                            <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                            </svg>
                                            <div>
                                                <h4 class="font-medium text-red-800">{{ __('Warning') }}</h4>
                                                <p class="text-sm text-red-700 mt-1">
                                                    {{ __('This action cannot be undone. All your data will be permanently removed from our servers.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
@endsection
