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
                <!-- Welcome Section -->
                <div class="mb-8">
                    <div
                        class="bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 rounded-2xl p-8 text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10"></div>
                        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-32 -mt-32"></div>
                        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full -ml-24 -mb-24"></div>
                        <div class="relative z-10">
                            <h1 class="text-3xl md:text-4xl font-bold mb-2">Welcome back, Admin! 👋</h1>
                            <p class="text-indigo-100 text-lg">Here's what's happening with your platform today.</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Users Card -->
                    <div
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Users</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $allUserCount }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">{{ $userGrowth }}</span>
                                    <span class="text-gray-500 ml-1">vs last month</span>
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Bookings Card -->
                    <div
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Bookings</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $allBookingCount }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">{{ $bookingGrowth }}</span>
                                    <span class="text-gray-500 ml-1">vs last month</span>
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Service Providers Card -->
                    <div
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-yellow-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Service Providers</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">{{ $allProviderCount }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">{{ $providerGrowth }}</span>
                                    <span class="text-gray-500 ml-1">vs last month</span>
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Revenue Card -->
                    <div
                        class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Total Revenue</p>
                                <p class="text-3xl font-bold text-gray-900 mb-2">${{ $totalRevenue }}</p>
                                <div class="flex items-center text-sm">
                                    <span class="text-green-600 font-medium">{{ $revenueGrowth }}</span>
                                    <span class="text-gray-500 ml-1">vs last month</span>
                                </div>
                            </div>
                            <div
                                class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- Revenue Chart -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <canvas id="revenueChart" height="200"></canvas>
                    </div>

                    <!-- Activity Chart -->
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <canvas id="activityChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div x-data="{ showAll: false }">
                    @foreach ($recentActivities as $index => $activity)
                        <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 transition-colors duration-200"
                            x-show="showAll || {{ $index }} < 5" x-cloak>
                            <div class="flex-shrink-0">
                                <div
                                    class="w-10 h-10 bg-gradient-to-br {{ $activity['iconColor'] }} rounded-xl flex items-center justify-center">
                                    {{-- You can replace the icons based on $activity['icon'] --}}
                                    {{-- <x-icon name="{{ $activity['icon'] }}" class="w-5 h-5 text-white" /> --}}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">{!! $activity['message'] !!}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @endforeach

                    {{-- Toggle Button --}}
                    @if (count($recentActivities) > 5)
                        <div class="text-center mt-4">
                            <button @click="showAll = !showAll"
                                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium"
                                x-text="showAll ? 'Show Less' : 'View All'"></button>
                        </div>
                    @endif
                </div>



                <!-- User Management Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 sm:mb-0">User Management</h2>
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                @can('manage-users')
                                    <a href="{{ route('admin.users.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add User
                                    </a>
                                @endcan
                                @can('manage-users')
                                    <a href="{{ route('admin.users.index') }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View All
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Cards View -->
                    <div class="block lg:hidden p-6 space-y-4">
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
                                $initials = strtoupper(
                                    substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1),
                                );
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
                                        @if ($user->status === 'active')
                                            <span
                                                class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">{{ ucfirst($user->status ?? 'Null') }}</span>
                                        @else<span
                                                class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">{{ ucfirst($user->status ?? 'Null') }}</span>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        @can('manage-users')
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Edit</a>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
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
                                            @if ($user->status === 'active')
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
                                            @can('manage-users')
                                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-4 font-medium">
                                                    Edit
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const revenueChartData = @json($revenueChartData);
        const userActivityData = @json($userActivityData);

        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const activityCtx = document.getElementById('activityChart').getContext('2d');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueChartData.map(item => item.date),
                datasets: [{
                    label: 'Revenue (USD)',
                    data: revenueChartData.map(item => item.total),
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    }
                }
            }
        });

        new Chart(activityCtx, {
            type: 'bar',
            data: {
                labels: userActivityData.map(item => item.date),
                datasets: [{
                    label: 'New Users',
                    data: userActivityData.map(item => item.users),
                    backgroundColor: 'rgba(139, 92, 246, 0.7)',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Users'
                        }
                    }
                }
            }
        });
    });
</script>

