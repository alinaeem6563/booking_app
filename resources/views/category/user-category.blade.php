
@extends('layouts.app')

@section('title', 'Service Categories')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    @include('navigation.Header')
 <!-- Hero Section -->
 <div class="relative bg-gradient-to-r from-purple-600 to-indigo-700">
    <div class="absolute inset-0">
        <img src="{{ asset('images/pattern-bg.png') }}" alt="" class="w-full h-full object-cover opacity-10">
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                Service Categories
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-xl text-indigo-100">
                Find the perfect service provider for your needs. Browse our categories and connect with trusted professionals.
            </p>
        </div>
    </div>
</div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="userCategories()">
        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" 
                               x-model="searchTerm"
                               @input="filterCategories()"
                               placeholder="Search categories..."
                               class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <!-- Sort -->
                <div>
                    <select x-model="sortBy" 
                            @change="sortCategories()"
                            class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="name">Sort by Name</option>
                        <option value="popular">Most Popular</option>
                        <option value="newest">Newest First</option>
                    </select>
                </div>

                <!-- View Toggle -->
                <div class="flex items-center justify-end space-x-2">
                    <button @click="viewMode = 'grid'" 
                            :class="viewMode === 'grid' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700'"
                            class="p-2 rounded-md">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </button>
                    <button @click="viewMode = 'list'" 
                            :class="viewMode === 'list' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:text-gray-700'"
                            class="p-2 rounded-md">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-sm text-gray-600">
                Showing <span x-text="filteredCategories.length"></span> of <span x-text="categories.length"></span> categories
            </p>
        </div>

        <!-- Grid View -->
        <div x-show="viewMode === 'grid'" 
             class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <template x-for="category in filteredCategories" :key="category.id">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-300 transition-all duration-300 cursor-pointer group"
                     @click="viewCategory(category.id)">
                    <div class="p-6">
                        <!-- Icon -->
                        <div class="flex items-center justify-center h-16 w-16 mx-auto mb-4 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white group-hover:scale-110 transition-transform duration-300"
                             x-html="category.icon_preview">
                        </div>

                        <!-- Content -->
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200" 
                                x-text="category.category_name"></h3>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4" 
                               x-text="category.category_description"></p>
                            
                            <!-- Stats -->
                            <div class="flex items-center justify-center space-x-4 text-xs text-gray-500">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0v2a2 2 0 002 2h4a2 2 0 002-2V6m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-8V6a2 2 0 012 2v6a2 2 0 01-2 2h-2" />
                                    </svg>
                                    <span x-text="category.services_count || 0"></span> Services
                                </span>
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span x-text="category.avg_rating || '0.0'"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- List View -->
        <div x-show="viewMode === 'list'" class="space-y-4">
            <template x-for="category in filteredCategories" :key="category.id">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md hover:border-indigo-300 transition-all duration-200 cursor-pointer"
                     @click="viewCategory(category.id)">
                    <div class="p-6">
                        <div class="flex items-center">
                            <!-- Icon -->
                            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mr-4"
                                 x-html="category.icon_preview">
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 truncate" x-text="category.category_name"></h3>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span x-text="(category.services_count || 0) + ' Services'"></span>
                                        <span class="flex items-center">
                                            <svg class="h-4 w-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span x-text="category.avg_rating || '0.0'"></span>
                                        </span>
                                    </div>
                                </div>
                                <p class="mt-1 text-gray-600 line-clamp-2" x-text="category.category_description"></p>
                            </div>

                            <!-- Arrow -->
                            <div class="flex-shrink-0 ml-4">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <div x-show="filteredCategories.length === 0" class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No categories found</h3>
            <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filters.</p>
        </div>

        <!-- Load More Button -->
        <div x-show="hasMore && filteredCategories.length > 0" class="text-center mt-8">
            <button @click="loadMore()" 
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Load More Categories
            </button>
        </div>
    </div>
</div>
@include('navigation.Footer')
@endsection
@section('script')
<script>
function userCategories() {
    return {
        categories: @json($categories),
        filteredCategories: [],
        searchTerm: '',
        sortBy: 'name',
        viewMode: 'grid',
        hasMore: false,
        currentPage: 1,

        init() {
            this.processCategories();
            this.filteredCategories = [...this.categories];
            this.sortCategories();
        },

        processCategories() {
            this.categories = this.categories.map(category => {
                // Process icon preview
                if (category.category_icon_link && category.category_icon_link.startsWith('<svg')) {
                    category.icon_preview = category.category_icon_link;
                } else if (category.category_icon_link && category.category_icon_link.startsWith('http')) {
                    category.icon_preview = `<img src="${category.category_icon_link}" alt="Icon" class="h-8 w-8">`;
                } else {
                    category.icon_preview = '<span class="text-2xl">📁</span>';
                }
                return category;
            });
        },

        filterCategories() {
            let filtered = [...this.categories];

            if (this.searchTerm) {
                filtered = filtered.filter(category => 
                    category.category_name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                    category.category_description.toLowerCase().includes(this.searchTerm.toLowerCase())
                );
            }

            this.filteredCategories = filtered;
            this.sortCategories();
        },

        sortCategories() {
            this.filteredCategories.sort((a, b) => {
                switch (this.sortBy) {
                    case 'name':
                        return a.category_name.localeCompare(b.category_name);
                    case 'popular':
                        return (b.services_count || 0) - (a.services_count || 0);
                    case 'newest':
                        return new Date(b.created_at) - new Date(a.created_at);
                    default:
                        return 0;
                }
            });
        },

        viewCategory(categoryId) {
            window.location.href = `/categories/${categoryId}`;
        },

        loadMore() {
            // Implement pagination logic here
            this.currentPage++;
        }
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection