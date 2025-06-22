@extends('layouts.app')

@section('title', 'My Services')

@section('style')
    <style>
        .service-card {
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-4px);
        }

        .modal-backdrop {
            backdrop-filter: blur(8px);
        }

        .image-preview {
            transition: all 0.3s ease;
        }

        .drag-over {
            border-color: #6366f1;
            background-color: #f0f9ff;
        }
    </style>
@endsection

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
        @include('services.add-new-service')
        @include('services.edit-service')
        <!-- Main Content -->
        <div class="main-content transition-all duration-300 ease-in-out md:ml-64"
            :class="sidebarCollapsed ? 'md:ml-16' : 'md:ml-64'">

            <!-- Header -->
            @include('navigation.UserHeader')


            <!-- Main Content Area -->
            <main class="p-4 md:p-6 lg:p-8" x-data="servicesManager()">
                <!-- Header Section -->
                <div class="mb-8">
                    <div
                        class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-6 md:p-8 text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10"></div>
                        <div
                            class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white opacity-5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32">
                        </div>
                        <div class="relative z-10">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div>
                                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">Service Management</h1>
                                    <p class="text-indigo-100 text-sm md:text-lg">Create and manage your professional
                                        services</p>
                                </div>
                                <div class="mt-6 md:mt-0">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="text-center">
                                                <div class="text-2xl font-bold">{{ $services->count() }}</div>
                                                <div class="text-sm text-indigo-100">Total Services</div>
                                            </div>
                                            <div class="w-px h-12 bg-white/30"></div>
                                            <div class="text-center">
                                                <div class="text-2xl font-bold">
                                                    {{ $services->where('service_status', 1)->count() }}</div>
                                                <div class="text-sm text-indigo-100">Active</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters and Actions -->
                <div class="mb-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                            <!-- Search and Filters -->
                            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 flex-1">
                                <!-- Search -->
                                <div class="relative flex-1 max-w-md">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    <input x-model="searchTerm" type="text" placeholder="Search services..."
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                </div>

                                <!-- Status Filter -->
                                <select x-model="statusFilter"
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>

                                <!-- Category Filter -->
                                <select x-model="categoryFilter"
                                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-3">
                                <button id="openServiceModal" type="button"
                                    class="inline-flex items-center px-3 md:px-4 py-2 bg-indigo-600  text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-lg transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Service
                                </button>


                            </div>
                        </div>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" x-show="filteredServices.length > 0">
                    <template x-for="service in filteredServices" :key="service.id">
                        <div
                            class="service-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg">
                            <!-- Service Image -->
                            <div class="relative h-48 bg-gradient-to-br from-gray-200 to-gray-300">
                                <img :src="service.image_url" :alt="service.service_name"
                                    class="w-full h-full object-cover">
                                <div class="absolute top-3 right-3">
                                    <span x-show="service.service_status == 1"
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <span x-show="service.service_status == 0"
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                </div>
                                <div class="absolute top-3 left-3">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-white/90 text-gray-800"
                                        x-text="service.category_name">
                                    </span>
                                </div>
                            </div>

                            <!-- Service Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1" x-text="service.service_name">
                                </h3>

                                <!-- Rating -->
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center">
                                        <template x-for="i in 5">
                                            <svg class="w-4 h-4" :class="i <= 4 ? 'text-yellow-400' : 'text-gray-300'"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                        </template>
                                    </div>
                                    <span class="text-sm text-gray-600 ml-2">4.8 (24 reviews)</span>
                                </div>

                                <p class="text-sm text-gray-600 mb-4 line-clamp-2" x-text="service.service_description"></p>

                                <!-- Pricing -->
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <span class="text-2xl font-bold text-gray-900">$<span
                                                x-text="service.service_price"></span></span>
                                        <span class="text-sm text-gray-600">/hour</span>
                                    </div>
                                    <div class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded-full">
                                        1-8 hours
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex space-x-2">
                                    <button @click="openEditServiceModal(service.id)" type="button"
                                        class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                        Edit
                                    </button>

                                    <button @click="toggleServiceStatus({service})"
                                        class="inline-flex justify-center items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200"
                                        :class="service.service_status == 1 ?
                                            'border border-red-300 text-red-700 bg-white hover:bg-red-50' :
                                            'border border-green-300 text-green-700 bg-white hover:bg-green-50'">
                                        <svg x-show="service.service_status == 1" class="w-4 h-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728">
                                            </path>
                                        </svg>
                                        <svg x-show="service.service_status == 0" class="w-4 h-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </button>

                                    <button @click="deleteService(service)"
                                        class="inline-flex justify-center items-center px-3 py-2 border border-red-300 text-red-700 bg-white hover:bg-red-50 text-sm font-medium rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Empty State -->
                <div x-show="filteredServices.length === 0" class="text-center py-12">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6">
                            </path>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No services found</h3>
                        <p class="text-gray-500 mb-6">Get started by creating your first service offering.</p>
                        <button @click="showAddModal = true"
                            class="inline-flex items-center px-6 py-3 bg-indigo-600  text-white font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Your First Service
                        </button>
                    </div>
                </div>

            </main>
        </div>
    </div>
@endsection
    <script>
        const services = @json($processedServices);

        function servicesManager() {
            return {
                // Data

                services: services,
                // Filters
                searchTerm: '',
                statusFilter: '',
                categoryFilter: '',

                // Computed
                get filteredServices() {
                    return this.services.filter(service => {
                        const matchesSearch = !this.searchTerm ||
                            service.service_name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                            service.service_description.toLowerCase().includes(this.searchTerm.toLowerCase());

                        const matchesStatus = !this.statusFilter ||
                            service.service_status.toString() === this.statusFilter;

                        const matchesCategory = !this.categoryFilter ||
                            service.category_id.toString() === this.categoryFilter;

                        return matchesSearch && matchesStatus && matchesCategory;
                    });
                },

                // Methods
                async toggleServiceStatus(service) {
                    try {
                        const response = await fetch(`/services/${service.id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        });

                        if (response.ok) {
                            const result = await response.json();
                            // Update the service in the local array
                            const index = this.services.findIndex(s => s.id === service.id);
                            if (index !== -1) {
                                this.services[index].service_status = result.service_status;
                            }
                            this.showNotification(result.message, 'success');
                        } else {
                            throw new Error('Failed to update service status');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        this.showNotification('Error updating service status.', 'error');
                    }
                },

                async deleteService(service) {
                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'Are you sure you want to delete this service? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EC3A45', // Custom delete color
                        cancelButtonColor: '#d3d3d3',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    });

                    if (!result.isConfirmed) return;

                    try {
                        const response = await fetch(`/services/${service.id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        });

                        if (response.ok) {
                            const result = await response.json();
                            this.services = this.services.filter(s => s.id !== service.id);
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: result.message || 'Service deleted successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            throw new Error('Failed to delete service');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Error deleting service.',
                        });
                    }
                },


                showNotification(message, type) {
                    // You can integrate with your notification system here
                    // For now, we'll use a simple alert
                    if (type === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: message,
                            confirmButtonColor: '#4338CA',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message,
                            confirmButtonColor: '#4338CA',
                        });
                    }

                }
            }
        }
    </script>

