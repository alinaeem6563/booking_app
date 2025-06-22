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

            <!-- Dashboard Content -->
            <main class="p-4 md:p-6 lg:p-8">
                <!-- Mobile Cards View -->
                <div class="block lg:hidden p-6 space-y-4">
                    <div class="bg-white  py-8 px-4 rounded-lg">
                        <h1 class="text-lg lg:text-xl font-semibold text-gray-900  ">View All Users</h1>
                    </div>
                    <!-- User Card  -->
                    @php
                        $gradients = [
                            'bg-gradient-to-br from-green-400 to-green-600',
                            'bg-gradient-to-br from-indigo-400 to-indigo-600',
                            'bg-gradient-to-br from-purple-400 to-purple-600',
                            'bg-gradient-to-br from-yellow-400 to-yellow-600',
                            'bg-gradient-to-br from-pink-400 to-pink-600',
                        ];
                    @endphp

                    @foreach ($allUsers as $user)
                        @php
                            $gradient = $gradients[$loop->index % count($gradients)];
                            $initials = strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1));
                        @endphp

                        <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center space-x-3 mb-3">
                                @if ($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image"
                                        class="w-12 h-12 rounded-xl object-cover">
                                @else
                                    <div
                                        class="w-12 h-12 {{ $gradient }} rounded-xl flex items-center justify-center text-white font-semibold">
                                        {{ $initials }}
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $user->first_name }}
                                        {{ $user->last_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-600">{{ ucfirst($user->account_type) }}</span>
                                    @if($user->status ==='active')
                                    <span
                                        class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ ucfirst($user->status ?? 'Null') }}</span>
                                    @else<span
                                        class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">{{ ucfirst($user->status ?? 'Null') }}</span>
                                        @endif
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-4 font-medium">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <div class="bg-white  py-8 px-4">
                        <h1 class="text-lg lg:text-xl font-semibold text-gray-900">View All Users</h1>
                    </div>
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Role</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Joined</th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $gradients = [
                                    'bg-gradient-to-br from-green-400 to-green-600',
                                    'bg-gradient-to-br from-indigo-400 to-indigo-600',
                                    'bg-gradient-to-br from-purple-400 to-purple-600',
                                    'bg-gradient-to-br from-yellow-400 to-yellow-600',
                                    'bg-gradient-to-br from-pink-400 to-pink-600',
                                ];
                            @endphp

                            @foreach ($allUsers as $user)
                                @php
                                    $gradient = $gradients[$loop->index % count($gradients)];
                                    $initials = strtoupper(
                                        substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1),
                                    );
                                @endphp

                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if ($user->profile_image)
                                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                                    alt="Profile Image" class="w-12 h-12 rounded-xl object-cover">
                                            @else
                                                <div
                                                    class="w-12 h-12 {{ $gradient }} rounded-xl flex items-center justify-center text-white font-semibold">
                                                    {{ $initials }}
                                                </div>
                                            @endif

                                            <div class="ml-4">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $user->first_name }} {{ $user->last_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ ucfirst($user->account_type) }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->status ==='active')
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($user->status ?? 'Null') }}

                                        </span>
                                        @else
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ ucfirst($user->status ?? 'Null') }}

                                        </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 mr-4 font-medium">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        @endsection
