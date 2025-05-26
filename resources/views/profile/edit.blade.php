@extends('layouts.app')

@section('content')
    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
        @include('navigation.sidebar')
        <!-- Main Content -->
        <div class="flex-1 p-4">
            <!-- Top Header -->
            @include('navigation.UserHeader')

            <x-slot name="header">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Profile Settings') }}
                    </h2>
                    <div class="mt-3 md:mt-0 text-sm">
                        <span class="text-gray-500">Last updated:</span>
                        <span class="text-gray-700 ml-1">{{ auth()->user()->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </x-slot>

            <div class="py-6 md:py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <!-- Profile Navigation Tabs -->
                    <div x-data="{ activeTab: 'profile' }" class="mb-6">
                        <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                            <div class="border-b border-gray-200">
                                <nav class="flex overflow-x-auto">
                                    <button @click="activeTab = 'profile'"
                                        :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'profile', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'profile' }"
                                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                                        <svg class="inline-block -ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profile Information
                                    </button>
                                    <button @click="activeTab = 'password'"
                                        :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'password', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'password' }"
                                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                                        <svg class="inline-block -ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                        Password
                                    </button>
                                    <button @click="activeTab = 'delete'"
                                        :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'delete', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'delete' }"
                                        class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm focus:outline-none">
                                        <svg class="inline-block -ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete Account
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- Tab Content -->
                        <div class="mt-6 space-y-6">
                            <!-- Profile Information Tab -->
                            <div x-show="activeTab === 'profile'" class="bg-white shadow sm:rounded-lg">
                                <div class="p-4 sm:p-8">
                                    <div class="max-w-xl mx-auto">
                                        <div class="flex items-center justify-between mb-6">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                {{ __('Profile Information') }}
                                            </h3>
                                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                                {{ __('Active') }}
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 mb-6">
                                            {{ __("Update your account's profile information and email address.") }}
                                        </p>

                                        @include('profile.partials.update-profile-information-form')
                                    </div>
                                </div>
                            </div>

                            <!-- Password Tab -->
                            <div x-show="activeTab === 'password'" class="bg-white shadow sm:rounded-lg">
                                <div class="p-4 sm:p-8">
                                    <div class="max-w-xl mx-auto">
                                        <div class="flex items-center justify-between mb-6">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                {{ __('Update Password') }}
                                            </h3>
                                            <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                {{ __('Security') }}
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 mb-6">
                                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                        </p>

                                        @include('profile.partials.update-password-form')
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Account Tab -->
                            <div x-show="activeTab === 'delete'" class="bg-white shadow sm:rounded-lg">
                                <div class="p-4 sm:p-8">
                                    <div class="max-w-xl mx-auto">
                                        <div class="flex items-center justify-between mb-6">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                {{ __('Delete Account') }}
                                            </h3>
                                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-800">
                                                {{ __('Danger Zone') }}
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 mb-6">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                                        </p>

                                        @include('profile.partials.delete-user-form')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Log -->
                    <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ __('Recent Activity') }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                {{ __('Your recent account activity and security events.') }}
                            </p>
                        </div>
                        <div class="px-4 py-5 sm:p-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ __('Successful login') }}
                                        </p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ __('Today at') }} {{ now()->format('h:i A') }} • {{ request()->ip() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3 w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ __('Profile information updated') }}
                                        </p>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ auth()->user()->updated_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    {{ __('View full activity log') }} →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endsection
