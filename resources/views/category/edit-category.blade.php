@extends('layouts.app')

@section('title', 'Edit Category')

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
                                Edit Category
                            </h1>
                            <p class="text-indigo-100 text-sm md:text-lg">Update category information and settings</p>
                        </div>
                        
        
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <form action="{{ route('categories.update', $category->id) }}" method="POST" class="p-6 md:p-8" x-data="categoryForm()">
                    @csrf
                    @method('PUT')

                    <!-- Form Errors -->
                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 border border-red-200 rounded-xl p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-red-800 mb-2">
                                        Please fix the following errors:
                                    </h3>
                                    <div class="text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Category Name -->
                            <div class="group">
                                <label for="category_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Category Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="category_name" 
                                           id="category_name"
                                           x-model="categoryName"
                                           @input="generateSlug()"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 group-hover:border-gray-400"
                                           value="{{ old('category_name', $category->category_name) }}" 
                                           placeholder="e.g., Home Cleaning Services"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">
                                    Choose a clear, descriptive name that users will easily understand
                                </p>
                            </div>

                            <!-- Category Slug -->
                            <div class="group">
                                <label for="category_slug" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Category Slug <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="category_slug" 
                                           id="category_slug"
                                           x-model="categorySlug"
                                           class="w-full px-4 py-3 pr-24 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 group-hover:border-gray-400"
                                           value="{{ old('category_slug', $category->category_slug) }}" 
                                           placeholder="home-cleaning-services"
                                           required>
                                    <button type="button" @click="generateSlugFromName()"
                                        class="absolute right-2 top-2 bottom-2 px-3 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Generate
                                    </button>
                                </div>
                                <p class="mt-2 text-sm text-gray-600">
                                    URL-friendly version used in web addresses (lowercase, hyphens only)
                                </p>
                            </div>

                            <!-- Category Status -->
                            <div class="group">
                                <label for="category_status" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Status
                                </label>
                                <select name="category_status" 
                                        id="category_status"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 group-hover:border-gray-400">
                                    <option value="inactive" {{ old('category_status', $category->category_status) == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                    <option value="active" {{ old('category_status', $category->category_status) == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                </select>
                                <p class="mt-2 text-sm text-gray-600">
                                    Only active categories will be visible to users on the platform
                                </p>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Category Description -->
                            <div class="group">
                                <label for="category_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <textarea name="category_description" 
                                          id="category_description" 
                                          rows="5"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 group-hover:border-gray-400 resize-none"
                                          placeholder="Describe what services are included in this category..."
                                          required>{{ old('category_description', $category->category_description) }}</textarea>
                                <p class="mt-2 text-sm text-gray-600">
                                    Provide a clear description of services included in this category
                                </p>
                            </div>

                            <!-- Category Icon Link -->
                            <div class="group">
                                <label for="category_icon_link" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Icon Link <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="category_icon_link" 
                                       id="category_icon_link"
                                       x-model="iconLink"
                                       @input="updateIconPreview()"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 group-hover:border-gray-400"
                                       value="{{ old('category_icon_link', $category->category_icon_link) }}" 
                                       placeholder="https://example.com/icon.svg or <svg>...</svg>"
                                       required>
                                <p class="mt-2 text-sm text-gray-600">
                                    Provide either an image URL or SVG code for the category icon
                                </p>
                            </div>

                            <!-- Icon Preview -->
                            <div x-show="showPreview" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Icon Preview
                                </label>
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 border border-gray-200">
                                    <div class="flex items-center justify-center">
                                        <div class="h-16 w-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg"
                                             x-html="iconPreview">
                                        </div>
                                    </div>
                                    <p class="text-center text-sm text-gray-600 mt-3">
                                        This is how your icon will appear to users
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row justify-end gap-4">
                            <a href="{{ route('categories.index') }}"
                               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Update Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function categoryForm() {
    return {
        categoryName: '{{ old('category_name', $category->category_name) }}',
        categorySlug: '{{ old('category_slug', $category->category_slug) }}',
        iconLink: '{{ old('category_icon_link', $category->category_icon_link) }}',
        iconPreview: '',
        showPreview: false,

        init() {
            this.updateIconPreview();
        },

        generateSlug() {
            // Auto-generate slug as user types
            this.categorySlug = this.categoryName
                .toLowerCase()
                .trim()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        },

        generateSlugFromName() {
            // Manual slug generation with visual feedback
            if (this.categoryName.trim()) {
                this.generateSlug();
                
                // Show visual feedback
                const button = document.querySelector('button[type="button"]');
                const originalText = button.innerHTML;
                button.innerHTML = '<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Generated';
                button.classList.add('bg-green-600', 'hover:bg-green-700');
                button.classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'hover:from-indigo-700', 'hover:to-purple-700');
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                    button.classList.add('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'hover:from-indigo-700', 'hover:to-purple-700');
                }, 2000);
            } else {
                // Show error feedback
                const nameInput = document.getElementById('category_name');
                nameInput.focus();
                nameInput.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                setTimeout(() => {
                    nameInput.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                }, 3000);
            }
        },

        updateIconPreview() {
            if (this.iconLink.trim().startsWith('<svg')) {
                this.iconPreview = this.iconLink;
                this.showPreview = true;
            } else if (this.iconLink.trim().startsWith('http')) {
                this.iconPreview = `<img src="${this.iconLink}" alt="Icon" class="h-8 w-8 object-contain">`;
                this.showPreview = true;
            } else if (this.iconLink.trim()) {
                this.iconPreview = '<span class="text-xs text-white font-medium">Invalid Format</span>';
                this.showPreview = true;
            } else {
                this.showPreview = false;
            }
        }
    }
}
</script>
@endsection
