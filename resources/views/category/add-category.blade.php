@extends('layouts.app')

@section('title', 'Add New Category')

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

            <!-- Enhanced Header with Gradient -->
            <div class="mb-6">
                <div
                    class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 md:p-8 text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div
                        class="absolute top-0 right-0 w-32 h-32 md:w-64 md:h-64 bg-white opacity-5 rounded-full -mr-16 md:-mr-32 -mt-16 md:-mt-32">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-24 h-24 md:w-48 md:h-48 bg-white opacity-5 rounded-full -ml-12 md:-ml-24 -mb-12 md:-mb-24">
                    </div>
                    <div class="relative z-10">
                        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                            <div>
                                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-2">
                                     Add New Category
                                </h1>
                                <p class="text-purple-100 text-sm md:text-lg">Create and organize service categories</p>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <form action="{{ route('categories.store') }}" method="POST" class="p-6 md:p-8">
                        @csrf

                        <!-- Form Errors -->
                        @if ($errors->any())
                            <div class="mb-8 bg-red-50 border border-red-200 rounded-xl p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
                                        <input type="text" name="category_name" id="category_name"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 group-hover:border-gray-400"
                                            value="{{ old('category_name') }}" placeholder="e.g., Home Cleaning Services"
                                            required>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                </path>
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
                                        <input type="text" name="category_slug" id="category_slug"
                                            class="w-full px-4 py-3 pr-24 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 group-hover:border-gray-400"
                                            value="{{ old('category_slug') }}" placeholder="home-cleaning-services"
                                            required>
                                        {{-- <button type="button" id="generate-slug"
                                            class="absolute right-2 top-2 bottom-2 px-3 text-sm font-medium text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                            Generate
                                        </button> --}}
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
                                    <select name="category_status" id="category_status"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 group-hover:border-gray-400">
                                        <option value="inactive"
                                            {{ old('category_status') == 'inactive' ? 'selected' : '' }}>
                                             Inactive
                                        </option>
                                        <option value="active" {{ old('category_status') == 'active' ? 'selected' : '' }}>
                                             Active
                                        </option>
                                    </select>
                                   
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Category Description -->
                                <div class="group">
                                    <label for="category_description"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                         Description <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="category_description" id="category_description" rows="5"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 group-hover:border-gray-400 resize-none"
                                        placeholder="Describe what services are included in this category..." required>{{ old('category_description') }}</textarea>
                                    <p class="mt-2 text-sm text-gray-600">
                                         Provide a clear description of services included in this category
                                    </p>
                                </div>

                                <!-- Category Icon Link -->
                                <div class="group">
                                    <label for="category_icon_link"
                                        class="block text-sm font-semibold text-gray-700 mb-2">
                                         Icon Link <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="category_icon_link" id="category_icon_link"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 group-hover:border-gray-400"
                                        value="{{ old('category_icon_link') }}"
                                        placeholder="https://example.com/icon.svg or <svg>...</svg>" required>
                                    <p class="mt-2 text-sm text-gray-600">
                                         Provide either an image URL or SVG code for the category icon
                                    </p>
                                </div>


                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-10 pt-6 border-t border-gray-200">
                            <div class="flex flex-col sm:flex-row justify-end gap-4">
                                <a href="#"
                                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 shadow-lg transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Category
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('category_name');
            const slugInput = document.getElementById('category_slug');
            const generateButton = document.getElementById('generate-slug');

            function generateSlugFromName(name) {
                return name
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/[^\w\-]+/g, '') // Remove non-word characters
                    .replace(/\-\-+/g, '-') // Replace multiple hyphens with one
                    .replace(/^-+|-+$/g, ''); // Trim hyphens from start and end
            }

            if (generateButton && nameInput && slugInput) {
                generateButton.addEventListener('click', function() {
                    const nameValue = nameInput.value.trim();
                    if (nameValue) {
                        slugInput.value = generateSlugFromName(nameValue);

                        // Add visual feedback
                        generateButton.innerHTML = '✓ Generated';
                        generateButton.classList.add('bg-green-600', 'hover:bg-green-700');
                        generateButton.classList.remove('bg-gradient-to-r', 'from-purple-600',
                            'to-indigo-600', 'hover:from-purple-700', 'hover:to-indigo-700');

                        setTimeout(() => {
                            generateButton.innerHTML = 'Generate';
                            generateButton.classList.remove('bg-green-600', 'hover:bg-green-700');
                            generateButton.classList.add('bg-gradient-to-r', 'from-purple-600',
                                'to-indigo-600', 'hover:from-purple-700', 'hover:to-indigo-700');
                        }, 2000);
                    } else {
                        // Show error feedback
                        nameInput.focus();
                        nameInput.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                        setTimeout(() => {
                            nameInput.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                        }, 3000);
                    }
                });
            }

            // Icon preview functionality
            const iconInput = document.getElementById('category_icon_link');
            const iconPreview = document.getElementById('icon-preview');
            const iconPreviewContainer = document.getElementById('icon-preview-container');

            if (iconInput && iconPreview && iconPreviewContainer) {
                if (iconInput.value.trim()) {
                    updateIconPreview(iconInput.value.trim());
                }

                iconInput.addEventListener('input', () => updateIconPreview(iconInput.value.trim()));
                iconInput.addEventListener('blur', () => updateIconPreview(iconInput.value.trim()));
            }

            function updateIconPreview(iconValue) {
                if (iconValue.startsWith('<svg')) {
                    iconPreview.innerHTML = iconValue;
                    iconPreviewContainer.classList.remove('hidden');
                    iconPreviewContainer.classList.add('animate-fade-in');
                } else if (iconValue.startsWith('http')) {
                    iconPreview.innerHTML = `<img src="${iconValue}" alt="Icon" class="h-8 w-8 object-contain">`;
                    iconPreviewContainer.classList.remove('hidden');
                    iconPreviewContainer.classList.add('animate-fade-in');
                } else if (iconValue) {
                    iconPreview.innerHTML = '<span class="text-xs text-white font-medium"> Invalid Format</span>';
                    iconPreviewContainer.classList.remove('hidden');
                    iconPreviewContainer.classList.add('animate-fade-in');
                } else {
                    iconPreviewContainer.classList.add('hidden');
                    iconPreviewContainer.classList.remove('animate-fade-in');
                }
            }

            // Add smooth animations
            const style = document.createElement('style');
            style.textContent = `
            .animate-fade-in {
                animation: fadeIn 0.3s ease-in-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
            document.head.appendChild(style);
        });
    </script>
@endsection
