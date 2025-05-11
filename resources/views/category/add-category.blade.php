@extends('layouts.app')

@section('title', 'Add New Category')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900">Add New Category</h1>
                <a href="#" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Back to Categories
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <form action="{{ route('categories.store') }}" method="POST" class="p-6">
                @csrf
                
                <!-- Form Errors -->
                @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                There were {{ $errors->count() }} errors with your submission
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
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

                <div class="space-y-6">
                    <!-- Category Name -->
                    <div>
                        <label for="category_name" class="block text-sm font-medium text-gray-700">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" name="category_name" id="category_name" 
                                class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('category_name') }}" required>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            The name of the category as it will appear to users.
                        </p>
                    </div>

                    <!-- Category Slug -->
                    <div>
                        <label for="category_slug" class="block text-sm font-medium text-gray-700">
                            Category Slug <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" name="category_slug" id="category_slug" 
                                class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('category_slug') }}" required>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            URL-friendly version of the name. Use lowercase letters, numbers, and hyphens only.
                        </p>
                    </div>

                    <!-- Category Description -->
                    <div>
                        <label for="category_description" class="block text-sm font-medium text-gray-700">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <textarea name="category_description" id="category_description" rows="4"
                                class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                required>{{ old('category_description') }}</textarea>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            A brief description of the category and the services it includes.
                        </p>
                    </div>

                    <!-- Category Icon Link -->
                    <div>
                        <label for="category_icon_link" class="block text-sm font-medium text-gray-700">
                            Icon Link <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input type="text" name="category_icon_link" id="category_icon_link" 
                                class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                value="{{ old('category_icon_link') }}" required>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            URL to the icon image or SVG code for the category icon.
                        </p>
                    </div>

                    <!-- Icon Preview -->
                    <div id="icon-preview-container" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Icon Preview
                        </label>
                        <div class="flex items-center">
                            <div id="icon-preview" class="h-12 w-12 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white"></div>
                            <span class="ml-3 text-sm text-gray-500">This is how your icon will appear</span>
                        </div>
                    </div>

                    <!-- Category Status -->
                    <div>
                        <label for="category_status" class="block text-sm font-medium text-gray-700">
                            Status
                        </label>
                        <div class="mt-1">
                            <select name="category_status" id="category_status" 
                                class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="inactive" {{ old('category_status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="active" {{ old('category_status') == 'active' ? 'selected' : '' }}>Active</option>
                            </select>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">
                            Only active categories will be visible to users.
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-5">
                        <div class="flex justify-end">
                            <a href="#" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Cancel
                            </a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                Create Category
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('category_name');
    const slugInput = document.getElementById('category_slug');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            // Convert to lowercase, replace spaces with hyphens, remove special chars
            const slug = this.value
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
            
            slugInput.value = slug;
        });
    }
    
    // Icon preview functionality
    const iconInput = document.getElementById('category_icon_link');
    const iconPreview = document.getElementById('icon-preview');
    const iconPreviewContainer = document.getElementById('icon-preview-container');
    
    if (iconInput && iconPreview && iconPreviewContainer) {
        // Check on page load if there's already a value
        if (iconInput.value) {
            updateIconPreview(iconInput.value);
        }
        
        // Update on input change
        iconInput.addEventListener('input', function() {
            updateIconPreview(this.value);
        });
        
        // Update on blur (when user leaves the field)
        iconInput.addEventListener('blur', function() {
            updateIconPreview(this.value);
        });
    }
    
    function updateIconPreview(iconValue) {
        // Check if it's an SVG code or URL
        if (iconValue.trim().startsWith('<svg')) {
            // It's SVG code
            iconPreview.innerHTML = iconValue;
            iconPreviewContainer.classList.remove('hidden');
        } else if (iconValue.trim().startsWith('http')) {
            // It's a URL
            iconPreview.innerHTML = `<img src="${iconValue}" alt="Icon" class="h-6 w-6">`;
            iconPreviewContainer.classList.remove('hidden');
        } else if (iconValue.trim()) {
            // It's something else but not empty
            iconPreview.innerHTML = '<span class="text-xs text-white">Invalid icon format</span>';
            iconPreviewContainer.classList.remove('hidden');
        } else {
            // Empty input
            iconPreviewContainer.classList.add('hidden');
        }
    }
});
</script>
@endsection