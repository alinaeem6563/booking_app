@extends('layouts.app')

@section('title', 'Manage Categories')

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
        
        <!-- Enhanced Header with Gradient -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 md:p-8 text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white opacity-5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 md:w-48 md:h-48 bg-white opacity-5 rounded-full -ml-12 md:-ml-24 -mb-12 md:-mb-24"></div>
                <div class="relative z-10">
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                        <div>
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">
                                Category Management
                            </h1>
                            <p class="text-purple-100 text-sm md:text-lg">Organize and manage your service categories</p>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('categories.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-lg hover:bg-white/30 transition-all duration-200 border border-white/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add New Category
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto" x-data="categoriesManager()">
            <!-- Filters and Search -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Filter & Search</h2>
                        <p class="text-sm text-gray-600 mt-1">Find and organize your categories</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        <span x-text="filteredCategories.length"></span> of <span x-text="categories.length"></span> categories
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="group">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            Search Categories
                        </label>
                        <div class="relative">
                            <input type="text" 
                                   x-model="searchTerm"
                                   @input="filterCategories()"
                                   placeholder="Search by name or description..."
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 group-hover:border-gray-400">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="group">
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-2">
                            Filter by Status
                        </label>
                        <select x-model="statusFilter" 
                                @change="filterCategories()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 group-hover:border-gray-400">
                            <option value="">All Status</option>
                            <option value="active">Active Only</option>
                            <option value="inactive">Inactive Only</option>
                        </select>
                    </div>

                    <div class="group">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">
                            Sort Categories
                        </label>
                        <select x-model="sortBy" 
                                @change="sortCategories()"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 group-hover:border-gray-400">
                            <option value="name">Sort by Name</option>
                            <option value="created_at">Sort by Date Created</option>
                            <option value="status">Sort by Status</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="category in filteredCategories" :key="category.id">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-purple-200 transition-all duration-300 cursor-pointer transform hover:-translate-y-1"
                         @click="viewCategory(category.id)">
                        <div class="p-6">
                            <!-- Category Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center flex-1 min-w-0">
                                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white mr-4 shadow-lg flex-shrink-0"
                                         x-html="category.icon_preview">
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate" x-text="category.category_name"></h3>
                                        <p class="text-sm text-gray-500 truncate" x-text="'/' + category.category_slug"></p>
                                    </div>
                                </div>
                                <span :class="category.category_status === 'active' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200'"
                                      class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border ml-2 flex-shrink-0">
                                    <span :class="category.category_status === 'active' ? 'bg-green-400' : 'bg-red-400'"
                                          class="w-2 h-2 rounded-full mr-2"></span>
                                    <span x-text="category.category_status === 'active' ? 'Active' : 'Inactive'"></span>
                                </span>
                            </div>

                            <!-- Description -->
                            <div class="mb-6">
                                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3" x-text="category.category_description"></p>
                            </div>

                            <!-- Footer -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="text-xs text-gray-500 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span x-text="formatDate(category.created_at)"></span>
                                </div>
                                <div class="flex space-x-2" @click.stop>
                                    <a :href="`/categories/${category.id}/edit`"
                                       class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <button @click="deleteCategory(category.id)"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredCategories.length === 0" class="text-center py-16">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12">
                    <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No categories found</h3>
                    <p class="text-gray-600 mb-6">
                        <span x-show="searchTerm || statusFilter">Try adjusting your search or filter criteria.</span>
                        <span x-show="!searchTerm && !statusFilter">Get started by creating your first category.</span>
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <button @click="clearFilters()" 
                                x-show="searchTerm || statusFilter"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Clear Filters
                        </button>
                        <a href="{{ route('categories.create') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function categoriesManager() {
    return {
        categories: @json($categories),
        filteredCategories: [],
        searchTerm: '',
        statusFilter: '',
        sortBy: 'name',

        init() {
            this.processCategories();
            this.filteredCategories = [...this.categories];
        },

        processCategories() {
            this.categories = this.categories.map(category => {
                // Process icon preview
                if (category.category_icon_link.startsWith('<svg')) {
                    category.icon_preview = category.category_icon_link;
                } else if (category.category_icon_link.startsWith('http')) {
                    category.icon_preview = `<img src="${category.category_icon_link}" alt="Icon" class="h-8 w-8 object-contain">`;
                } else {
                    category.icon_preview = '<div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg></div>';
                }
                return category;
            });
        },

        filterCategories() {
            let filtered = [...this.categories];

            // Search filter
            if (this.searchTerm) {
                filtered = filtered.filter(category => 
                    category.category_name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                    category.category_description.toLowerCase().includes(this.searchTerm.toLowerCase())
                );
            }

            // Status filter
            if (this.statusFilter) {
                filtered = filtered.filter(category => category.category_status === this.statusFilter);
            }

            this.filteredCategories = filtered;
            this.sortCategories();
        },

        sortCategories() {
            this.filteredCategories.sort((a, b) => {
                switch (this.sortBy) {
                    case 'name':
                        return a.category_name.localeCompare(b.category_name);
                    case 'created_at':
                        return new Date(b.created_at) - new Date(a.created_at);
                    case 'status':
                        return a.category_status.localeCompare(b.category_status);
                    default:
                        return 0;
                }
            });
        },

        clearFilters() {
            this.searchTerm = '';
            this.statusFilter = '';
            this.filterCategories();
        },

        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        },

        deleteCategory(categoryId) {
            Swal.fire({
    title: 'Are you sure?',
    text: 'Are you sure you want to delete this category? This action cannot be undone.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#EC3A45', // Your custom red
    cancelButtonColor: '#d3d3d3',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
}).then((result) => {
    if (result.isConfirmed) {
        fetch(`/admin/categories/${categoryId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.categories = this.categories.filter(cat => cat.id !== categoryId);
                this.filterCategories();
                this.showNotification('Category deleted successfully', 'success');
            } else {
                this.showNotification('Failed to delete category', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.showNotification('An error occurred while deleting the category', 'error');
        });
    }
});

        },

        viewCategory(id) {
            window.location.href = `/categories/${id}`;
        },

        showNotification(message, type) {
            // Simple notification - you can replace this with a proper toast system
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    }
}
</script>
@endsection
