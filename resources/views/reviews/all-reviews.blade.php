{{-- resources/views/reviews/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manage Reviews')

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

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="reviewsManager()">
                <!-- Modern Header with Gradient -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl shadow-xl mb-8 overflow-hidden">
                    <div class="px-8 py-10">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <!-- Title Section -->
                            <div class="text-white">
                                <div class="flex items-center gap-3 mb-3">

                                    <div>
                                        <h1 class="text-3xl lg:text-4xl font-bold">Reviews Management</h1>
                                        <p class="text-pink-100 mt-1">Manage customer reviews for your services</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Stats & Actions -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                <!-- Quick Stats -->
                                <div class="flex items-center gap-6 text-white">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold" x-text="stats.avgRating"></div>
                                        <div class="text-xs text-pink-100">Avg Rating</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold" x-text="stats.total"></div>
                                        <div class="text-xs text-pink-100">Total Reviews</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold" x-text="stats.approved"></div>
                                        <div class="text-xs text-pink-100">Approved</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold" x-text="stats.pending"></div>
                                        <div class="text-xs text-pink-100">Pending</div>
                                    </div>
                                </div>

                                <!-- Export Button -->
                                <button @click="exportReviews()"
                                    class="inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-200 border border-white/20">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export Reviews
                                </button>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Filters and Search -->
                <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search
                                Reviews</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" x-model="searchTerm" @input="filterReviews()"
                                    placeholder="Search by customer name, service, or review text..."
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select x-model="statusFilter" @change="filterReviews()"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Status</option>
                                <option value="1">Approved</option>
                                <option value="0">Pending</option>
                            </select>
                        </div>

                        <!-- Rating Filter -->
                        <div>
                            <label for="rating-filter" class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                            <select x-model="ratingFilter" @change="filterReviews()"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">All Ratings</option>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                            <select x-model="sortBy" @change="sortReviews()"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="rating_high">Highest Rating</option>
                                <option value="rating_low">Lowest Rating</option>
                                <option value="service">Service Name</option>
                            </select>
                        </div>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" x-model="selectAll" @change="toggleSelectAll()"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">Select All</span>
                            <span x-show="selectedReviews.length > 0" class="text-sm text-gray-500">
                                (<span x-text="selectedReviews.length"></span> selected)
                            </span>
                        </div>

                        <div x-show="selectedReviews.length > 0" class="flex items-center space-x-2">
                            <button @click="bulkApprove()"
                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Approve Selected
                            </button>
                            <button @click="bulkDelete()"
                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete Selected
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Results Count -->
                <div class="mb-6">
                    <p class="text-sm text-gray-600">
                        Showing <span x-text="filteredReviews.length"></span> of <span x-text="reviews.length"></span>
                        reviews
                    </p>
                </div>

                <!-- Reviews List -->
                <div class="space-y-6">
                    <template x-for="review in paginatedReviews" :key="review.id">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="p-6">
                                <!-- Review Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-start space-x-4">
                                        <!-- Checkbox -->
                                        <input type="checkbox" :value="review.id" x-model="selectedReviews"
                                            class="mt-1 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">

                                        <!-- Customer Info -->
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold mr-3">
                                                <span x-text="review.customer_initials"></span>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900"
                                                    x-text="review.customer_name"></h3>
                                                <p class="text-sm text-gray-500" x-text="review.service_name"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status and Actions -->
                                    <div class="flex items-center space-x-3">
                                        <!-- Status Badge -->
                                        <span
                                            :class="review.status == 1 ? 'bg-green-100 text-green-800' :
                                                'bg-yellow-100 text-yellow-800'"
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            <span x-text="review.status == 1 ? 'Approved' : 'Pending'"></span>
                                        </span>

                                        <!-- Action Buttons -->
                                        <div class="flex items-center space-x-2">
                                            <button x-show="review.status == 0" @click="approveReview(review.id)"
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                                Approve
                                            </button>

                                            <button @click="deleteReview(review.id)"
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg class="-ml-1 mr-1 h-4 w-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center">
                                        <template x-for="i in 5" :key="i">
                                            <svg :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300'"
                                                class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </template>
                                        <span class="ml-2 text-sm text-gray-600" x-text="review.rating + '/5'"></span>
                                    </div>
                                    <span class="ml-4 text-sm text-gray-500" x-text="review.created_at_formatted"></span>
                                </div>

                                <!-- Review Text -->
                                <div class="mb-4">
                                    <p class="text-gray-700 leading-relaxed" x-text="review.review_text"></p>
                                </div>

                                <!-- Service Details -->
                                <div x-show="review.service_details" class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Service Details</h4>
                                    <p class="text-sm text-gray-600" x-text="review.service_details"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Empty State -->
                <div x-show="filteredReviews.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-1l-4 4z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews found</h3>
                    <p class="mt-1 text-sm text-gray-500">No reviews match your current filters.</p>
                </div>

                <!-- Pagination -->
                <div x-show="filteredReviews.length > perPage" class="mt-8 flex items-center justify-between">
                    <div class="flex items-center">
                        <p class="text-sm text-gray-700">
                            Showing <span x-text="((currentPage - 1) * perPage) + 1"></span> to
                            <span x-text="Math.min(currentPage * perPage, filteredReviews.length)"></span> of
                            <span x-text="filteredReviews.length"></span> results
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button @click="previousPage()" :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Previous
                        </button>
                        <button @click="nextPage()" :disabled="currentPage === totalPages"
                            :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function reviewsManager() {
            return {
                reviews: @json($reviews),
                filteredReviews: [],
                paginatedReviews: [],
                searchTerm: '',
                statusFilter: '',
                ratingFilter: '',
                sortBy: 'newest',
                selectedReviews: [],
                selectAll: false,
                currentPage: 1,
                perPage: 10,
                stats: {
                    total: 0,
                    approved: 0,
                    pending: 0,
                    avgRating: 0
                },

                init() {
                    this.processReviews();
                    this.calculateStats();
                    this.filteredReviews = [...this.reviews];
                    this.sortReviews();
                    this.updatePagination();
                },

                processReviews() {
                    this.reviews = this.reviews.map(review => {
                        // Add computed properties
                        review.customer_initials = this.getInitials(review.customer_name);
                        review.created_at_formatted = this.formatDate(review.created_at);
                        return review;
                    });
                },

                calculateStats() {
                    this.stats.total = this.reviews.length;
                    this.stats.approved = this.reviews.filter(r => r.status == 1).length;
                    this.stats.pending = this.reviews.filter(r => r.status == 0).length;

                    const totalRating = this.reviews.reduce((sum, review) => sum + review.rating, 0);
                    this.stats.avgRating = this.reviews.length > 0 ? (totalRating / this.reviews.length).toFixed(1) : '0.0';
                },

                filterReviews() {
                    let filtered = [...this.reviews];

                    // Search filter
                    if (this.searchTerm) {
                        const term = this.searchTerm.toLowerCase();
                        filtered = filtered.filter(review =>
                            review.customer_name.toLowerCase().includes(term) ||
                            review.service_name.toLowerCase().includes(term) ||
                            review.review_text.toLowerCase().includes(term)
                        );
                    }

                    // Status filter
                    if (this.statusFilter !== '') {
                        filtered = filtered.filter(review => review.status == this.statusFilter);
                    }

                    // Rating filter
                    if (this.ratingFilter) {
                        filtered = filtered.filter(review => review.rating == this.ratingFilter);
                    }

                    this.filteredReviews = filtered;
                    this.currentPage = 1;
                    this.sortReviews();
                    this.updatePagination();
                },

                sortReviews() {
                    this.filteredReviews.sort((a, b) => {
                        switch (this.sortBy) {
                            case 'newest':
                                return new Date(b.created_at) - new Date(a.created_at);
                            case 'oldest':
                                return new Date(a.created_at) - new Date(b.created_at);
                            case 'rating_high':
                                return b.rating - a.rating;
                            case 'rating_low':
                                return a.rating - b.rating;
                            case 'service':
                                return a.service_name.localeCompare(b.service_name);
                            default:
                                return 0;
                        }
                    });
                    this.updatePagination();
                },

                updatePagination() {
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    this.paginatedReviews = this.filteredReviews.slice(start, end);
                },

                get totalPages() {
                    return Math.ceil(this.filteredReviews.length / this.perPage);
                },

                previousPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.updatePagination();
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                        this.updatePagination();
                    }
                },

                toggleSelectAll() {
                    if (this.selectAll) {
                        this.selectedReviews = this.paginatedReviews.map(review => review.id);
                    } else {
                        this.selectedReviews = [];
                    }
                },

                approveReview(reviewId) {
                    Swal.fire({
                        title: 'Approve Review?',
                        text: 'Are you sure you want to approve this review?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, approve it',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#4338CA', // Approve button color (indigo)
                        cancelButtonColor: '#d3d3d3'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.updateReviewStatus(reviewId, 1);
                        }
                    });
                },

                deleteReview(reviewId) {
                    Swal.fire({
                        title: 'Delete Review?',
                        text: 'Are you sure you want to delete this review? This action cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#EC3A45', // Delete color
                        cancelButtonColor: '#d3d3d3'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.performDelete([reviewId]);
                        }
                    });
                },

                bulkApprove() {
                    if (this.selectedReviews.length === 0) return;

                    if (confirm(`Are you sure you want to approve ${this.selectedReviews.length} selected reviews?`)) {
                        this.selectedReviews.forEach(reviewId => {
                            this.updateReviewStatus(reviewId, 1);
                        });
                        this.selectedReviews = [];
                        this.selectAll = false;
                    }
                },

                bulkDelete() {
                    if (this.selectedReviews.length === 0) return;

                    if (confirm(
                            `Are you sure you want to delete ${this.selectedReviews.length} selected reviews? This action cannot be undone.`
                        )) {
                        this.performDelete(this.selectedReviews);
                        this.selectedReviews = [];
                        this.selectAll = false;
                    }
                },

                updateReviewStatus(reviewId, status) {
                    fetch(`/provider/reviews/${reviewId}/approve`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update local data
                                const review = this.reviews.find(r => r.id === reviewId);
                                if (review) {
                                    review.status = status;
                                }
                                this.calculateStats();
                                this.filterReviews();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Update Failed',
                                    text: 'Error updating review status. Please try again.',
                                    confirmButtonColor: '#4338CA',
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: 'Error updating review status. Please try again.',
                                confirmButtonColor: '#4338CA',
                            });
                        });
                },

                performDelete(reviewIds) {
                    fetch('/provider/reviews/bulk-delete', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                review_ids: reviewIds
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Remove deleted reviews from local data
                                this.reviews = this.reviews.filter(review => !reviewIds.includes(review.id));
                                this.calculateStats();
                                this.filterReviews();
                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Update Failed',
                                    text: 'Error deleting reviews. Please try again.',
                                    confirmButtonColor: '#4338CA',
                                });

                            }
                        })
                        .catch(error => {

                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed',
                                text: 'Error deleting reviews. Please try again.',
                                confirmButtonColor: '#4338CA',
                            });

                        });
                },

                exportReviews() {
                    window.location.href = '/provider/reviews/export';
                },

                getInitials(name) {
                    return name.split(' ').map(n => n[0]).join('').toUpperCase();
                },

                formatDate(dateString) {
                    return new Date(dateString).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }
        }
    </script>
@endsection
