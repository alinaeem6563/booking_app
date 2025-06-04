{{-- resources/views/categories/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manage Categories')

@section('content')
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
    @include('navigation.sidebar')
    
    <div class="flex-1 p-4">
        @include('navigation.UserHeader')
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="categoriesManager()">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
                        <p class="mt-2 text-sm text-gray-600">Manage your service categories</p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <a href="{{ route('categories.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Category
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" 
                               x-model="searchTerm"
                               @input="filterCategories()"
                               placeholder="Search categories..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                    </div>
                    <div>
                        <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select x-model="statusFilter" 
                                @change="filterCategories()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select x-model="sortBy" 
                                @change="sortCategories()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500">
                            <option value="name">Name</option>
                            <option value="created_at">Date Created</option>
                            <option value="status">Status</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="category in filteredCategories" :key="category.id"
                >
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200"
                    @click="viewCategory(category.id)">
                        <div class="p-6">
                            <!-- Category Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white mr-3"
                                         x-html="category.icon_preview">
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900" x-text="category.category_name"></h3>
                                        <p class="text-sm text-gray-500" x-text="category.category_slug"></p>
                                    </div>
                                </div>
                                <span :class="category.category_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                      x-text="category.category_status"></span>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3" x-text="category.category_description"></p>

                            <!-- Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <div class="text-xs text-gray-500">
                                    Created <span x-text="formatDate(category.created_at)"></span>
                                </div>
                                <div class="flex space-x-2">
                                    <a :href="`/categories/${category.id}/edit`"
                                       class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                        Edit
                                    </a>
                                    <button @click="deleteCategory(category.id)"
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredCategories.length === 0" class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No categories found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new category.</p>
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
                    category.icon_preview = `<img src="${category.category_icon_link}" alt="Icon" class="h-6 w-6">`;
                } else {
                    category.icon_preview = '<span class="text-xs">📁</span>';
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

        formatDate(dateString) {
            return new Date(dateString).toLocaleDateString();
        },

        deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category?')) {
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
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        },

        viewCategory(id) {
            window.location.href = `/categories/${id}`;
        }
    }
}

</script>
@endsection