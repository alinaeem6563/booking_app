@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="bg-gray-50 min-h-screen" x-data="categoryEditForm()" x-cloak>
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center">
                <a href="#" class="mr-4 text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Edit Category</h1>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Loading State -->
        <div x-show="loading" class="flex flex-col items-center justify-center py-12">
            <div class="w-16 h-16 border-4 border-purple-200 border-t-purple-600 rounded-full animate-spin"></div>
            <p class="mt-4 text-gray-600">Loading category data...</p>
        </div>

        <!-- Error State -->
        <div x-show="!loading && loadError" class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700" x-text="loadError"></p>
                    <div class="mt-2">
                        <a href="#" class="text-sm font-medium text-red-700 hover:text-red-600">
                            Return to categories list
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div x-show="!loading && !loadError" class="bg-white shadow-sm rounded-lg overflow-hidden">
            <form @submit.prevent="submitForm">
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Category Name <span class="text-red-500">*</span></label>
                            <input 
                                type="text" 
                                id="name" 
                                x-model="form.name"
                                @input="generateSlug"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                :class="{'border-red-300': errors.name}"
                                placeholder="e.g. Home Cleaning"
                            >
                            <p x-show="errors.name" x-text="errors.name" class="mt-1 text-sm text-red-600"></p>
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                    /categories/
                                </span>
                                <input 
                                    type="text" 
                                    id="slug" 
                                    x-model="form.slug"
                                    class="flex-1 block w-full border-gray-300 rounded-none rounded-r-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                    :class="{'border-red-300': errors.slug}"
                                    placeholder="home-cleaning"
                                >
                            </div>
                            <p x-show="errors.slug" x-text="errors.slug" class="mt-1 text-sm text-red-600"></p>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description <span class="text-red-500">*</span></label>
                            <textarea 
                                id="description" 
                                x-model="form.description"
                                rows="3" 
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                :class="{'border-red-300': errors.description}"
                                placeholder="Describe this category and the services it includes..."
                            ></textarea>
                            <p x-show="errors.description" x-text="errors.description" class="mt-1 text-sm text-red-600"></p>
                        </div>

                        <!-- Icon -->
                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-700">Icon <span class="text-red-500">*</span></label>
                            <div class="mt-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span x-html="form.icon || '<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-5 w-5 text-gray-400\' viewBox=\'0 0 20 20\' fill=\'currentColor\'><path fill-rule=\'evenodd\' d=\'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z\' clip-rule=\'evenodd\' /></svg>'"></span>
                                </div>
                                <input 
                                    type="text" 
                                    id="icon" 
                                    x-model="form.icon"
                                    class="pl-10 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                    :class="{'border-red-300': errors.icon}"
                                    placeholder="SVG icon code"
                                >
                            </div>
                            <p x-show="errors.icon" x-text="errors.icon" class="mt-1 text-sm text-red-600"></p>
                            <p class="mt-1 text-xs text-gray-500">Paste SVG icon code here. You can find free icons at <a href="https://heroicons.com/" target="_blank" class="text-purple-600 hover:text-purple-500">Heroicons</a>.</p>
                        </div>

                        <!-- Color Gradient -->
                        <div>
                            <label for="gradient" class="block text-sm font-medium text-gray-700">Color Gradient <span class="text-red-500">*</span></label>
                            <select 
                                id="gradient" 
                                x-model="form.gradient"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-purple-500 focus:border-purple-500 sm:text-sm"
                                :class="{'border-red-300': errors.gradient}"
                            >
                                <option value="">Select a color gradient</option>
                                <option value="from-blue-500 to-indigo-600">Blue to Indigo</option>
                                <option value="from-cyan-500 to-blue-600">Cyan to Blue</option>
                                <option value="from-green-500 to-teal-600">Green to Teal</option>
                                <option value="from-yellow-400 to-orange-500">Yellow to Orange</option>
                                <option value="from-pink-500 to-rose-600">Pink to Rose</option>
                                <option value="from-purple-500 to-indigo-600">Purple to Indigo</option>
                                <option value="from-red-500 to-pink-600">Red to Pink</option>
                                <option value="from-amber-500 to-orange-600">Amber to Orange</option>
                                <option value="from-gray-700 to-gray-900">Gray to Dark Gray</option>
                            </select>
                            <p x-show="errors.gradient" x-text="errors.gradient" class="mt-1 text-sm text-red-600"></p>
                        </div>

                        <!-- Preview -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200 h-32 flex">
                                <div class="w-32 h-full bg-gradient-to-br flex items-center justify-center text-white" :class="form.gradient || 'from-gray-400 to-gray-500'">
                                    <span class="text-4xl" x-html="form.icon || '<svg xmlns=\'http://www.w3.org/2000/svg\' class=\'h-10 w-10\' viewBox=\'0 0 20 20\' fill=\'currentColor\'><path fill-rule=\'evenodd\' d=\'M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z\' clip-rule=\'evenodd\' /></svg>'"></span>
                                </div>
                                <div class="p-4 flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900" x-text="form.name || 'Category Name'"></h3>
                                    <p class="mt-1 text-sm text-gray-500 line-clamp-2" x-text="form.description || 'Category description will appear here...'"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Status and Featured -->
                        <div>
                            <div class="flex items-center">
                                <input 
                                    id="active" 
                                    type="checkbox" 
                                    x-model="form.active"
                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                >
                                <label for="active" class="ml-2 block text-sm text-gray-700">
                                    Active
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Active categories are visible to users.</p>
                        </div>

                        <div>
                            <div class="flex items-center">
                                <input 
                                    id="featured" 
                                    type="checkbox" 
                                    x-model="form.featured"
                                    class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                                >
                                <label for="featured" class="ml-2 block text-sm text-gray-700">
                                    Featured
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Featured categories appear in the featured section.</p>
                        </div>

                        <!-- Provider Count -->
                        <div class="md:col-span-2">
                            <div class="bg-gray-50 rounded-md p-4">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a3 3 0 00-3-3h-2a3 3 0 00-3 3v1h8z" />
                                    </svg>
                                    <span class="text-sm text-gray-700">This category has <span class="font-medium" x-text="form.providerCount"></span> service providers.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 bg-gray-50 flex items-center justify-end space-x-3">
                    <button 
                        type="button" 
                        @click="resetForm"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                    >
                        Reset
                    </button>
                    <a 
                        href="{{ route('provider.categories.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                    >
                        Cancel
                    </a>
                    <button 
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"
                        :disabled="isSubmitting"
                    >
                        <svg x-show="isSubmitting" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="isSubmitting ? 'Saving...' : 'Update Category'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function categoryEditForm() {
    return {
        categoryId: {{ $categoryId ?? 'null' }},
        originalForm: {},
        form: {
            name: '',
            slug: '',
            description: '',
            icon: '',
            gradient: '',
            active: true,
            featured: false,
            providerCount: 0
        },
        errors: {},
        loading: true,
        loadError: null,
        isSubmitting: false,
        
        init() {
            this.fetchCategory();
        },
        
        async fetchCategory() {
            this.loading = true;
            this.loadError = null;
            
            try {
                // In a real app, this would be an API call
                // For demo purposes, we'll use mock data
                await new Promise(resolve => setTimeout(resolve, 800));
                
                // Get the category by ID
                const category = this.getMockCategory(this.categoryId);
                
                if (!category) {
                    this.loadError = 'Category not found';
                    return;
                }
                
                // Set form data
                this.form = { ...category };
                this.originalForm = { ...category };
            } catch (error) {
                console.error('Error fetching category:', error);
                this.loadError = 'Failed to load category data. Please try again.';
            } finally {
                this.loading = false;
            }
        },
        
        generateSlug() {
            if (this.form.name === this.originalForm.name) {
                // If name hasn't changed, keep the original slug
                this.form.slug = this.originalForm.slug;
                return;
            }
            
            this.form.slug = this.form.name
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
        },
        
        validateForm() {
            this.errors = {};
            
            if (!this.form.name.trim()) {
                this.errors.name = 'Category name is required';
            }
            
            if (!this.form.slug.trim()) {
                this.errors.slug = 'Slug is required';
            } else if (!/^[a-z0-9-]+$/.test(this.form.slug)) {
                this.errors.slug = 'Slug can only contain lowercase letters, numbers, and hyphens';
            }
            
            if (!this.form.description.trim()) {
                this.errors.description = 'Description is required';
            }
            
            if (!this.form.icon.trim()) {
                this.errors.icon = 'Icon is required';
            }
            
            if (!this.form.gradient) {
                this.errors.gradient = 'Please select a color gradient';
            }
            
            return Object.keys(this.errors).length === 0;
        },
        
        async submitForm() {
            if (!this.validateForm()) {
                return;
            }
            
            this.isSubmitting = true;
            
            try {
                // In a real app, this would be an API call
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Simulate successful submission
                alert('Category updated successfully!');
                
                // Redirect to categories list
                window.location.href = '{{ route("provider.categories.index") }}';
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('An error occurred while updating the category. Please try again.');
            } finally {
                this.isSubmitting = false;
            }
        },
        
        resetForm() {
            this.form = { ...this.originalForm };
            this.errors = {};
        },
        
        getMockCategory(id) {
            const categories = [
                {
                    id: 1,
                    name: 'Home Cleaning',
                    slug: 'home-cleaning',
                    description: 'Professional home cleaning services including regular cleaning, deep cleaning, and specialized services.',
                    icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>',
                    gradient: 'from-blue-500 to-indigo-600',
                    providerCount: 48,
                    active: true,
                    featured: true,
                    createdAt: '2023-01-15T00:00:00Z'
                },
                {
                    id: 2,
                    name: 'Plumbing',
                    slug: 'plumbing',
                    description: 'Expert plumbing services for repairs, installations, and maintenance for residential and commercial properties.',
                    icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
                    gradient: 'from-cyan-500 to-blue-600',
                    providerCount: 36,
                    active: true,
                    featured: true,
                    createdAt: '2023-02-10T00:00:00Z'
                },
                {
                    id: 3,
                    name: 'Electrical',
                    slug: 'electrical',
                    description: 'Licensed electricians for all electrical needs, from repairs to installations and smart home setups.',
                    icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>',
                    gradient: 'from-yellow-400 to-orange-500',
                    providerCount: 29,
                    active: true,
                    featured: true,
                    createdAt: '2023-01-25T00:00:00Z'
                }
            ];
            
            return categories.find(category => category.id === id);
        }
    };
}
</script>
@endsection