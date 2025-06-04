{{-- resources/views/categories/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="min-h-screen flex">
    @include('navigation.sidebar')
    
    <div class="flex-1 p-4">
        @include('navigation.UserHeader')
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-900">Edit Category</h1>
                    <a href="{{ route('categories.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Categories
                    </a>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <form action="
                {{-- {{ route('categories.update', $category->id) }} --}}
                 " method="POST" class="p-6" x-data="categoryForm()">
                    @csrf
                    @method('PUT')

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
                                <input type="text" 
                                       name="category_name" 
                                       id="category_name"
                                       x-model="categoryName"
                                       @input="generateSlug()"
                                       class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       value="{{ old('category_name', $category->category_name) }}" 
                                       required>
                            </div>
                        </div>

                        <!-- Category Slug -->
                        <div>
                            <label for="category_slug" class="block text-sm font-medium text-gray-700">
                                Category Slug <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="category_slug" 
                                       id="category_slug"
                                       x-model="categorySlug"
                                       class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       value="{{ old('category_slug', $category->category_slug) }}" 
                                       required>
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
                                <textarea name="category_description" 
                                          id="category_description" 
                                          rows="4"
                                          class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                          required>{{ old('category_description', $category->category_description) }}</textarea>
                            </div>
                        </div>

                        <!-- Category Icon Link -->
                        <div>
                            <label for="category_icon_link" class="block text-sm font-medium text-gray-700">
                                Icon Link <span class="text-red-500">*</span>
                            </label>
                            <div class="mt-1">
                                <input type="text" 
                                       name="category_icon_link" 
                                       id="category_icon_link"
                                       x-model="iconLink"
                                       @input="updateIconPreview()"
                                       class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                       value="{{ old('category_icon_link', $category->category_icon_link) }}" 
                                       required>
                            </div>
                        </div>

                        <!-- Icon Preview -->
                        <div x-show="showPreview" class="transition-all duration-300">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Icon Preview
                            </label>
                            <div class="flex items-center">
                                <div class="h-12 w-12 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white"
                                     x-html="iconPreview">
                                </div>
                                <span class="ml-3 text-sm text-gray-500">This is how your icon will appear</span>
                            </div>
                        </div>

                        <!-- Category Status -->
                        <div>
                            <label for="category_status" class="block text-sm font-medium text-gray-700">
                                Status
                            </label>
                            <div class="mt-1">
                                <select name="category_status" 
                                        id="category_status"
                                        class="shadow-sm focus:ring-purple-500 focus:border-purple-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    <option value="inactive" {{ old('category_status', $category->category_status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="active" {{ old('category_status', $category->category_status) == 'active' ? 'selected' : '' }}>Active</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-5">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('categories.index') }}"
                                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Update Category
                                </button>
                            </div>
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
            this.categorySlug = this.categoryName
                .toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        },

        updateIconPreview() {
            if (this.iconLink.trim().startsWith('<svg')) {
                this.iconPreview = this.iconLink;
                this.showPreview = true;
            } else if (this.iconLink.trim().startsWith('http')) {
                this.iconPreview = `<img src="${this.iconLink}" alt="Icon" class="h-6 w-6">`;
                this.showPreview = true;
            } else if (this.iconLink.trim()) {
                this.iconPreview = '<span class="text-xs text-white">Invalid</span>';
                this.showPreview = true;
            } else {
                this.showPreview = false;
            }
        }
    }
}
</script>
@endsection