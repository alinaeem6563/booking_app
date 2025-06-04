{{-- resources/views/categories/show.blade.php --}}
@extends('layouts.app')

@section('title', $category->category_name . ' - Category Details')

@section('content')
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
    @include('navigation.sidebar')
    <!-- Main Content -->
    <div class="flex-1 p-4">
        <!-- Top Header -->
        @include('navigation.UserHeader')
    <!-- Hero Section -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <!-- Category Info -->
                <div class="flex items-center mb-6 lg:mb-0">
                    <!-- Back Button -->
                    <a href="{{ auth()->user()->account_type === 'admin' ? route('categories.index') : route('all-categories') }}"
                        class="mr-4 p-2 rounded-full hover:bg-gray-100 transition-colors duration-200">
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>

                    <!-- Category Icon -->
                    <div class="h-16 w-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mr-6 shadow-lg">
                        @if(str_starts_with($category->category_icon_link, '<svg'))
                            {!! $category->category_icon_link !!}
                        @elseif(str_starts_with($category->category_icon_link, 'http'))
                            <img src="{{ $category->category_icon_link }}" alt="Icon" class="h-10 w-10">
                        @else
                            <span class="text-2xl">📁</span>
                        @endif
                    </div>

                    <!-- Category Details -->
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $category->category_name }}</h1>
                        <p class="text-lg text-gray-600 mt-1">{{ $category->category_slug }}</p>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $category->category_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($category->category_status) }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Created {{ $category->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Admin Actions -->
                @if(auth()->user()->account_type === 'admin')
                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                        <a href="{{ route('categories.edit', $category->id) }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Category
                        </a>
                        <button onclick="deleteCategory({{ $category->id }})"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="categoryDetails()">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">About This Category</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $category->category_description }}</p>
                </div>

                <!-- Services in this Category -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-gray-900">
                            Services in {{ $category->category_name }}
                            <span class="text-sm font-normal text-gray-500">({{ $services->count() }})</span>
                        </h2>
                        
                        <!-- Service Filters -->
                        <div class="flex items-center space-x-3">
                            <select x-model="serviceSort" @change="sortServices()" 
                                    class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="name">Sort by Name</option>
                                <option value="price">Sort by Price</option>
                                <option value="rating">Sort by Rating</option>
                                <option value="newest">Newest First</option>
                            </select>
                            
                            <button @click="serviceView = serviceView === 'grid' ? 'list' : 'grid'"
                                    class="p-2 text-gray-500 hover:text-gray-700 rounded-md hover:bg-gray-100">
                                <svg x-show="serviceView === 'grid'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <svg x-show="serviceView === 'list'" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    @if($services->count() > 0)
                        <!-- Grid View -->
                        <div x-show="serviceView === 'grid'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <template x-for="service in sortedServices" :key="service.id">
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer"
                                     @click="viewService(service.id)">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="font-semibold text-gray-900 line-clamp-2" x-text="service.service_name"></h3>
                                        <span class="text-lg font-bold text-indigo-600 ml-2" x-text="'$' + service.service_price"></span>
                                    </div>
                                    
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2" x-text="service.service_description"></p>
                                    
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <template x-for="i in 5" :key="i">
                                                    <svg :class="i <= (service.avg_rating || 0) ? 'text-yellow-400' : 'text-gray-300'" 
                                                         class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </template>
                                                <span class="ml-1 text-sm text-gray-500" x-text="(service.avg_rating ?? 0).toFixed(1)"></span>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500" x-text="service.provider_name"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- List View -->
                        <div x-show="serviceView === 'list'" class="space-y-4">
                            <template x-for="service in sortedServices" :key="service.id">
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer"
                                     @click="viewService(service.id)">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h3 class="font-semibold text-gray-900" x-text="service.service_name"></h3>
                                                <span class="text-lg font-bold text-indigo-600" x-text="'$' + service.service_price"></span>
                                            </div>
                                            <p class="text-gray-600 text-sm mb-2 line-clamp-1" x-text="service.service_description"></p>
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <template x-for="i in 5" :key="i">
                                                        <svg :class="i <= (service.avg_rating || 0) ? 'text-yellow-400' : 'text-gray-300'" 
                                                             class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    </template>
                                                    <span class="ml-1 text-sm text-gray-500" x-text="service.avg_rating || '0.0'"></span>
                                                </div>
                                                <span class="text-sm text-gray-500" x-text="service.provider_name"></span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m-8 0v2a2 2 0 002 2h4a2 2 0 002-2V6m-8 0H6a2 2 0 00-2 2v6a2 2 0 002 2h2m8-8V6a2 2 0 012 2v6a2 2 0 01-2 2h-2" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No services available</h3>
                            <p class="mt-1 text-sm text-gray-500">There are currently no services in this category.</p>
                            @if(Auth::user()->account_type === 'provider')
                                <div class="mt-6">
                                    <a href="{{ route('services.create') }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Add First Service
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Related Categories -->
                @if($relatedCategories->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">Related Categories</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($relatedCategories as $relatedCategory)
                                <a href="{{ route('categories.show', $relatedCategory->id) }}" 
                                   class="flex items-center p-4 border border-gray-200 rounded-lg hover:shadow-md hover:border-indigo-300 transition-all duration-200">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white mr-3">
                                        @if(str_starts_with($relatedCategory->category_icon_link, '<svg'))
                                            {!! $relatedCategory->category_icon_link !!}
                                        @elseif(str_starts_with($relatedCategory->category_icon_link, 'http'))
                                            <img src="{{ $relatedCategory->category_icon_link }}" alt="Icon" class="h-6 w-6">
                                        @else
                                            <span class="text-sm">📁</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-900 truncate">{{ $relatedCategory->category_name }}</h3>
                                        <p class="text-xs text-gray-500">{{ $relatedCategory->services_count ?? 0 }} services</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Category Stats -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Total Services</span>
                            <span class="font-semibold text-gray-900">{{ $services->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Active Providers</span>
                            <span class="font-semibold text-gray-900">{{ $activeProviders }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Average Rating</span>
                            <div class="flex items-center">
                                <span class="font-semibold text-gray-900 mr-1">{{ number_format($averageRating, 1) }}</span>
                                <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Price Range</span>
                            <span class="font-semibold text-gray-900">
                                @if($priceRange['min'] && $priceRange['max'])
                                    ${{ number_format($priceRange['min']) }} - ${{ number_format($priceRange['max']) }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        @if(Auth::user()->account_type === 'provider')
                            <a href="{{ route('services.create', ['category' => $category->id]) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Service
                            </a>
                        @endif
                        
                        <button @click="shareCategory()" 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                            </svg>
                            Share Category
                        </button>
                        
                        <a href="{{ route('all-categories') }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Browse All Categories
                        </a>
                    </div>
                </div>

                <!-- Category Details -->
                @if(Auth::user()->account_type === 'admin')
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Details</h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="text-gray-600">ID:</span>
                                <span class="font-mono text-gray-900 ml-2">{{ $category->id }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Slug:</span>
                                <span class="font-mono text-gray-900 ml-2">{{ $category->category_slug }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Created:</span>
                                <span class="text-gray-900 ml-2">{{ $category->created_at->format('M j, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Updated:</span>
                                <span class="text-gray-900 ml-2">{{ $category->updated_at->format('M j, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function categoryDetails() {
    return {
        services: @json($services),
        sortedServices: [],
        serviceSort: 'name',
        serviceView: 'grid',

        init() {
            this.sortedServices = [...this.services];
            this.sortServices();
        },

        sortServices() {
            this.sortedServices.sort((a, b) => {
                switch (this.serviceSort) {
                    case 'name':
                        return a.service_name.localeCompare(b.service_name);
                    case 'price':
                        return parseFloat(a.service_price) - parseFloat(b.service_price);
                    case 'rating':
                        return (b.avg_rating || 0) - (a.avg_rating || 0);
                    case 'newest':
                        return new Date(b.created_at) - new Date(a.created_at);
                    default:
                        return 0;
                }
            });
        },

        viewService(serviceId) {
            window.location.href = `/services/${serviceId}`;
        },

        shareCategory() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $category->category_name }}',
                    text: '{{ $category->category_description }}',
                    url: window.location.href
                });
            } else {
                // Fallback to copying URL
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Category URL copied to clipboard!');
                });
            }
        }
    }
}

function deleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
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
                window.location.href = '{{ route("categories.index") }}';
            } else {
                alert('Error deleting category. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting category. Please try again.');
        });
    }
}
</script>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

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