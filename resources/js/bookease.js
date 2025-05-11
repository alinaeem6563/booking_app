/**
 * BookEase - Main JavaScript File
 * Contains functionality for the BookEase booking platform
 */

document.addEventListener("DOMContentLoaded", function () {
    // Initialize date pickers
    initDatepickers();

    // Initialize tooltips
    initTooltips();

    // Initialize any other global components
    initGlobalComponents();
});

/**
 * Initialize Flatpickr date pickers
 */
function initDatepickers() {
    if (typeof flatpickr !== "undefined") {
        const datepickers = document.querySelectorAll(".datepicker");
        if (datepickers.length > 0) {
            flatpickr(datepickers, {
                dateFormat: "Y-m-d",
                allowInput: true,
            });
        }

        const datetimepickers = document.querySelectorAll(".datetimepicker");
        if (datetimepickers.length > 0) {
            flatpickr(datetimepickers, {
                dateFormat: "Y-m-d H:i",
                enableTime: true,
                time_24hr: false,
                allowInput: true,
            });
        }
    }
}

/**
 * Initialize tooltips
 */
function initTooltips() {
    // If using a tooltip library, initialize it here
    // This is a placeholder for future implementation
}

/**
 * Initialize global components
 */
function initGlobalComponents() {
    // Mobile menu toggle
    const mobileMenuToggle = document.querySelector(
        "[data-mobile-menu-toggle]"
    );
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener("click", function () {
            const mobileMenu = document.querySelector("[data-mobile-menu]");
            if (mobileMenu) {
                mobileMenu.classList.toggle("hidden");
            }
        });
    }
}

/**
 * Format currency
 * @param {number} amount - The amount to format
 * @param {string} currency - The currency code (default: USD)
 * @returns {string} Formatted currency string
 */
function formatCurrency(amount, currency = "USD") {
    return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: currency,
    }).format(amount);
}

/**
 * Format date
 * @param {string} dateString - The date string to format
 * @param {object} options - Formatting options
 * @returns {string} Formatted date string
 */
function formatDate(
    dateString,
    options = { year: "numeric", month: "short", day: "numeric" }
) {
    if (!dateString) return "";
    return new Date(dateString).toLocaleDateString(undefined, options);
}

/**
 * Show toast notification
 * @param {string} message - The message to display
 * @param {string} type - The type of notification (success, error, warning, info)
 * @param {number} duration - Duration in milliseconds
 */
function showToast(message, type = "info", duration = 3000) {
    // Create toast element
    const toast = document.createElement("div");
    toast.className = `fixed bottom-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 ${getToastColorClass(
        type
    )}`;
    toast.textContent = message;

    // Add to DOM
    document.body.appendChild(toast);

    // Remove after duration
    setTimeout(() => {
        toast.classList.add("opacity-0", "transition-opacity", "duration-300");
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, duration);
}

/**
 * Get toast color class based on type
 * @param {string} type - The type of notification
 * @returns {string} Tailwind CSS class
 */
function getToastColorClass(type) {
    switch (type) {
        case "success":
            return "bg-green-500 text-white";
        case "error":
            return "bg-red-500 text-white";
        case "warning":
            return "bg-yellow-500 text-white";
        case "info":
        default:
            return "bg-indigo-500 text-white";
    }
}

/**
 * Make an AJAX request
 * @param {string} url - The URL to request
 * @param {object} options - Request options
 * @returns {Promise} Promise resolving to the response
 */
async function makeRequest(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
            ...options,
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error("Request error:", error);
        throw error;
    }
}

/**
 * Validate form data
 * @param {HTMLFormElement} form - The form to validate
 * @returns {boolean} Whether the form is valid
 */
function validateForm(form) {
    let isValid = true;

    // Get all required inputs
    const requiredInputs = form.querySelectorAll("[required]");

    // Check each required input
    requiredInputs.forEach((input) => {
        if (!input.value.trim()) {
            isValid = false;
            highlightInvalidInput(input);
        } else {
            removeInvalidHighlight(input);
        }
    });

    // Email validation
    const emailInputs = form.querySelectorAll('input[type="email"]');
    emailInputs.forEach((input) => {
        if (input.value && !isValidEmail(input.value)) {
            isValid = false;
            highlightInvalidInput(input);
        }
    });

    return isValid;
}

/**
 * Check if email is valid
 * @param {string} email - The email to validate
 * @returns {boolean} Whether the email is valid
 */
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

/**
 * Highlight invalid input
 * @param {HTMLElement} input - The input to highlight
 */
function highlightInvalidInput(input) {
    input.classList.add(
        "border-red-500",
        "focus:ring-red-500",
        "focus:border-red-500"
    );

    // Add error message if it doesn't exist
    const errorId = `${input.id}-error`;
    if (!document.getElementById(errorId)) {
        const errorMsg = document.createElement("p");
        errorMsg.id = errorId;
        errorMsg.className = "mt-1 text-sm text-red-600";
        errorMsg.textContent =
            input.dataset.errorMessage || "This field is required";
        input.parentNode.appendChild(errorMsg);
    }
}

/**
 * Remove invalid highlight
 * @param {HTMLElement} input - The input to remove highlight from
 */
function removeInvalidHighlight(input) {
    input.classList.remove(
        "border-red-500",
        "focus:ring-red-500",
        "focus:border-red-500"
    );

    // Remove error message if it exists
    const errorId = `${input.id}-error`;
    const errorMsg = document.getElementById(errorId);
    if (errorMsg) {
        errorMsg.remove();
    }
}

/**
 * Coupon Manager - Alpine.js component
 * @returns {object} Alpine.js component data and methods
 */
function couponManager() {
    return {
        coupons: [
            {
                id: 1,
                code: "WELCOME20",
                description: "Welcome discount for new customers",
                discount_type: "percentage",
                discount_value: 20,
                start_date: "2023-05-01",
                end_date: "2023-12-31",
                usage_limit: 1000,
                usage_count: 345,
                min_order_amount: 0,
                status: "active",
            },
            {
                id: 2,
                code: "SUMMER10",
                description: "Summer sale discount",
                discount_type: "percentage",
                discount_value: 10,
                start_date: "2023-06-01",
                end_date: "2023-08-31",
                usage_limit: 500,
                usage_count: 125,
                min_order_amount: 50,
                status: "active",
            },
            {
                id: 3,
                code: "FLAT25",
                description: "Flat discount on all services",
                discount_type: "fixed",
                discount_value: 25,
                start_date: "2023-04-15",
                end_date: "2023-05-15",
                usage_limit: 200,
                usage_count: 200,
                min_order_amount: 100,
                status: "expired",
            },
            {
                id: 4,
                code: "CLEAN15",
                description: "Discount on cleaning services",
                discount_type: "percentage",
                discount_value: 15,
                start_date: "2023-05-01",
                end_date: "2023-07-31",
                usage_limit: 0,
                usage_count: 78,
                min_order_amount: 0,
                status: "active",
            },
            {
                id: 5,
                code: "PREMIUM50",
                description: "Premium customer discount",
                discount_type: "fixed",
                discount_value: 50,
                start_date: "2023-05-10",
                end_date: "2023-12-31",
                usage_limit: 100,
                usage_count: 12,
                min_order_amount: 200,
                status: "inactive",
            },
        ],
        filteredCoupons: [],
        searchTerm: "",
        statusFilter: "all",
        typeFilter: "all",
        showModal: false,
        showDeleteModal: false,
        isEditing: false,
        currentCoupon: {
            id: null,
            code: "",
            description: "",
            discount_type: "percentage",
            discount_value: 0,
            start_date: "",
            end_date: "",
            usage_limit: 0,
            usage_count: 0,
            min_order_amount: 0,
            status: "active",
        },
        couponToDelete: null,

        init() {
            this.filteredCoupons = [...this.coupons];

            // Initialize date pickers after Alpine loads
            this.$nextTick(() => {
                this.initDatepickers();
            });

            // Load coupons from API in a real application
            // this.loadCoupons();
        },

        initDatepickers() {
            if (typeof flatpickr !== "undefined") {
                flatpickr(".datepicker", {
                    dateFormat: "Y-m-d",
                    allowInput: true,
                });
            }
        },

        async loadCoupons() {
            try {
                // In a real application, this would fetch from an API
                // const response = await makeRequest('/api/coupons');
                // this.coupons = response.data;
                // this.filterCoupons();

                // For demo purposes, we're using the static data
                this.filterCoupons();
            } catch (error) {
                console.error("Error loading coupons:", error);
                showToast("Failed to load coupons", "error");
            }
        },

        filterCoupons() {
            this.filteredCoupons = this.coupons.filter((coupon) => {
                // Search filter
                const searchMatch =
                    this.searchTerm === "" ||
                    coupon.code
                        .toLowerCase()
                        .includes(this.searchTerm.toLowerCase()) ||
                    (coupon.description &&
                        coupon.description
                            .toLowerCase()
                            .includes(this.searchTerm.toLowerCase()));

                // Status filter
                const statusMatch =
                    this.statusFilter === "all" ||
                    coupon.status === this.statusFilter;

                // Type filter
                const typeMatch =
                    this.typeFilter === "all" ||
                    coupon.discount_type === this.typeFilter;

                return searchMatch && statusMatch && typeMatch;
            });
        },

        formatDiscount(coupon) {
            if (coupon.discount_type === "percentage") {
                return `${coupon.discount_value}% off`;
            } else {
                return `$${coupon.discount_value.toFixed(2)} off`;
            }
        },

        formatDate(dateString) {
            return formatDate(dateString);
        },

        openCreateModal() {
            this.isEditing = false;
            this.currentCoupon = {
                id: null,
                code: "",
                description: "",
                discount_type: "percentage",
                discount_value: 0,
                start_date: new Date().toISOString().split("T")[0],
                end_date: new Date(
                    new Date().setMonth(new Date().getMonth() + 1)
                )
                    .toISOString()
                    .split("T")[0],
                usage_limit: 0,
                usage_count: 0,
                min_order_amount: 0,
                status: "active",
            };
            this.showModal = true;

            // Initialize date pickers after modal is shown
            this.$nextTick(() => {
                this.initDatepickers();
            });
        },

        openEditModal(coupon) {
            this.isEditing = true;
            this.currentCoupon = { ...coupon };
            this.showModal = true;

            // Initialize date pickers after modal is shown
            this.$nextTick(() => {
                this.initDatepickers();
            });
        },

        closeModal() {
            this.showModal = false;
        },

        async saveCoupon() {
            try {
                if (this.isEditing) {
                    // In a real application, this would update via API
                    // await makeRequest(`/api/coupons/${this.currentCoupon.id}`, {
                    //     method: 'PUT',
                    //     body: JSON.stringify(this.currentCoupon)
                    // });

                    // For demo purposes, update locally
                    const index = this.coupons.findIndex(
                        (c) => c.id === this.currentCoupon.id
                    );
                    if (index !== -1) {
                        this.coupons[index] = { ...this.currentCoupon };
                    }

                    showToast("Coupon updated successfully!", "success");
                } else {
                    // In a real application, this would create via API
                    // const response = await makeRequest('/api/coupons', {
                    //     method: 'POST',
                    //     body: JSON.stringify(this.currentCoupon)
                    // });
                    // const newCoupon = response.data;

                    // For demo purposes, create locally
                    const newId =
                        Math.max(...this.coupons.map((c) => c.id), 0) + 1;
                    const newCoupon = {
                        ...this.currentCoupon,
                        id: newId,
                        usage_count: 0,
                    };
                    this.coupons.push(newCoupon);

                    showToast("Coupon created successfully!", "success");
                }

                // Update filtered coupons
                this.filterCoupons();

                // Close modal
                this.closeModal();
            } catch (error) {
                console.error("Error saving coupon:", error);
                showToast("Failed to save coupon", "error");
            }
        },

        confirmDelete(coupon) {
            this.couponToDelete = coupon;
            this.showDeleteModal = true;
        },

        async deleteCoupon() {
            if (!this.couponToDelete) return;

            try {
                // In a real application, this would delete via API
                // await makeRequest(`/api/coupons/${this.couponToDelete.id}`, {
                //     method: 'DELETE'
                // });

                // For demo purposes, delete locally
                this.coupons = this.coupons.filter(
                    (c) => c.id !== this.couponToDelete.id
                );

                // Update filtered coupons
                this.filterCoupons();

                // Close modal
                this.showDeleteModal = false;

                showToast("Coupon deleted successfully!", "success");
            } catch (error) {
                console.error("Error deleting coupon:", error);
                showToast("Failed to delete coupon", "error");
            }
        },

        validateCouponForm() {
            // Basic validation
            if (!this.currentCoupon.code) {
                showToast("Coupon code is required", "error");
                return false;
            }

            if (this.currentCoupon.discount_value <= 0) {
                showToast("Discount value must be greater than 0", "error");
                return false;
            }

            if (
                this.currentCoupon.discount_type === "percentage" &&
                this.currentCoupon.discount_value > 100
            ) {
                showToast("Percentage discount cannot exceed 100%", "error");
                return false;
            }

            if (
                !this.currentCoupon.start_date ||
                !this.currentCoupon.end_date
            ) {
                showToast("Start and end dates are required", "error");
                return false;
            }

            if (
                new Date(this.currentCoupon.start_date) >
                new Date(this.currentCoupon.end_date)
            ) {
                showToast("End date must be after start date", "error");
                return false;
            }

            return true;
        },
    };
}

/**
 * Booking Manager - Alpine.js component
 * @returns {object} Alpine.js component data and methods
 */
function bookingManager() {
    return {
        bookings: [],
        filteredBookings: [],
        searchTerm: "",
        statusFilter: "all",
        dateFilter: "all",
        showDetailsModal: false,
        selectedBooking: null,

        init() {
            // Load bookings from API in a real application
            // this.loadBookings();

            // For demo purposes, we'll use static data
            this.bookings = [
                {
                    id: 1,
                    service_name: "Home Cleaning",
                    provider_name: "Elite Cleaning Services",
                    customer_name: "John Doe",
                    booking_date: "2023-05-15",
                    booking_time: "10:00 AM - 12:00 PM",
                    status: "upcoming",
                    price: 75.0,
                    payment_status: "paid",
                },
                // Add more bookings as needed
            ];

            this.filteredBookings = [...this.bookings];
        },

        async loadBookings() {
            try {
                // In a real application, this would fetch from an API
                // const response = await makeRequest('/api/bookings');
                // this.bookings = response.data;
                // this.filterBookings();
            } catch (error) {
                console.error("Error loading bookings:", error);
                showToast("Failed to load bookings", "error");
            }
        },

        filterBookings() {
            // Implement booking filtering logic
        },

        viewBookingDetails(booking) {
            this.selectedBooking = booking;
            this.showDetailsModal = true;
        },
    };
}

/**
 * User Dashboard - Alpine.js component
 * @returns {object} Alpine.js component data and methods
 */
function userDashboard() {
    return {
        upcomingBookings: [],
        completedBookings: [],
        savedProviders: [],

        init() {
            // Load user dashboard data
            // this.loadDashboardData();
        },

        async loadDashboardData() {
            try {
                // In a real application, this would fetch from an API
                // const response = await makeRequest('/api/user/dashboard');
                // this.upcomingBookings = response.data.upcomingBookings;
                // this.completedBookings = response.data.completedBookings;
                // this.savedProviders = response.data.savedProviders;
            } catch (error) {
                console.error("Error loading dashboard data:", error);
                showToast("Failed to load dashboard data", "error");
            }
        },
    };
}

/**
 * Provider Dashboard - Alpine.js component
 * @returns {object} Alpine.js component data and methods
 */
function providerDashboard() {
    return {
        bookingRequests: [],
        services: [],
        schedule: [],

        init() {
            // Load provider dashboard data
            // this.loadDashboardData();
        },

        async loadDashboardData() {
            try {
                // In a real application, this would fetch from an API
                // const response = await makeRequest('/api/provider/dashboard');
                // this.bookingRequests = response.data.bookingRequests;
                // this.services = response.data.services;
                // this.schedule = response.data.schedule;
            } catch (error) {
                console.error("Error loading dashboard data:", error);
                showToast("Failed to load dashboard data", "error");
            }
        },

        async updateBookingStatus(bookingId, status) {
            try {
                // In a real application, this would update via API
                // await makeRequest(`/api/bookings/${bookingId}/status`, {
                //     method: 'PUT',
                //     body: JSON.stringify({ status })
                // });

                showToast("Booking status updated successfully!", "success");
            } catch (error) {
                console.error("Error updating booking status:", error);
                showToast("Failed to update booking status", "error");
            }
        },
    };
}

/**
 * Admin Dashboard - Alpine.js component
 * @returns {object} Alpine.js component data and methods
 */
function adminDashboard() {
    return {
        stats: {
            totalUsers: 0,
            totalBookings: 0,
            totalProviders: 0,
            totalRevenue: 0,
        },
        recentActivity: [],

        init() {
            // Load admin dashboard data
            // this.loadDashboardData();
        },

        async loadDashboardData() {
            try {
                // In a real application, this would fetch from an API
                // const response = await makeRequest('/api/admin/dashboard');
                // this.stats = response.data.stats;
                // this.recentActivity = response.data.recentActivity;
            } catch (error) {
                console.error("Error loading dashboard data:", error);
                showToast("Failed to load dashboard data", "error");
            }
        },
    };
}

// Export Alpine.js components for global use
window.couponManager = couponManager;
window.bookingManager = bookingManager;
window.userDashboard = userDashboard;
window.providerDashboard = providerDashboard;
window.adminDashboard = adminDashboard;
