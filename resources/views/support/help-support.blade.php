@extends('layouts.app')
<title>BookEase - Help & Support</title>

<!-- Header -->
@include('navigation.Header')

@section('content')
    <!-- Background with gradient -->
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50">
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-32 w-80 h-80 rounded-full bg-gradient-to-br from-indigo-400/20 to-purple-600/20 blur-3xl">
            </div>
            <div
                class="absolute -bottom-40 -left-32 w-80 h-80 rounded-full bg-gradient-to-tr from-purple-400/20 to-indigo-600/20 blur-3xl">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-gradient-to-r from-indigo-300/10 to-purple-300/10 blur-3xl">
            </div>
        </div>

        <!-- Main Content -->
        <main class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="helpSupport()">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">
                    Help & Support
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    We're here to help you get the most out of BookEase. Find answers to common questions or get in touch
                    with our support team.
                </p>
            </div>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto mb-12">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" x-model="searchQuery" @input="filterFAQs"
                        placeholder="Search for help articles, FAQs, or topics..."
                        class="w-full pl-12 pr-4 py-4 text-lg border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 bg-white/80 backdrop-blur-sm shadow-lg">
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Contact Support -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 hover:shadow-2xl transition-all duration-300 group cursor-pointer"
                    @click="openContactModal = true">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 ml-3">Contact Support</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Get personalized help from our support team</p>
                    <div class="flex items-center text-indigo-600 font-medium group-hover:text-indigo-700">
                        <span>Start conversation</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>

                <!-- Live Chat -->
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 hover:shadow-2xl transition-all duration-300 group cursor-pointer">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-green-100 to-emerald-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2v-6a2 2 0 012-2h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 ml-3">Live Chat</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Chat with our support team in real-time</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-green-600 font-medium group-hover:text-green-700">
                            <span>Chat now</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <div class="flex items-center text-sm text-green-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>
                            Online
                        </div>
                    </div>
                </div>

                <!-- Video Tutorials -->
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 hover:shadow-2xl transition-all duration-300 group cursor-pointer">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-purple-100 to-pink-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H15M9 10v4a2 2 0 002 2h2a2 2 0 002-2v-4M9 10V9a2 2 0 012-2h2a2 2 0 012 2v1" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 ml-3">Video Tutorials</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Watch step-by-step video guides</p>
                    <div class="flex items-center text-purple-600 font-medium group-hover:text-purple-700">
                        <span>Watch videos</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Help Categories -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Browse by Category</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <template x-for="category in categories" :key="category.id">
                        <div class="bg-white/60 backdrop-blur-sm rounded-xl p-4 text-center hover:bg-white/80 transition-all duration-200 cursor-pointer border border-white/20"
                            @click="selectedCategory = category.id; filterFAQs()">
                            <div class="w-12 h-12 mx-auto mb-3 rounded-lg flex items-center justify-center"
                                :class="category.bgColor">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :class="category.iconColor"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        :d="category.icon" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 text-sm" x-text="category.name"></h3>
                            <p class="text-xs text-gray-600 mt-1" x-text="category.count + ' articles'"></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="max-w-4xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Frequently Asked Questions</h2>
                    <button @click="selectedCategory = null; searchQuery = ''; filterFAQs()"
                        x-show="selectedCategory || searchQuery"
                        class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                        Show all FAQs
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="faq in filteredFAQs" :key="faq.id">
                        <div
                            class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg border border-white/20 overflow-hidden">
                            <button
                                class="w-full px-6 py-4 text-left hover:bg-gray-50/50 transition-colors duration-200 flex items-center justify-between"
                                @click="toggleFAQ(faq.id)">
                                <h3 class="font-semibold text-gray-900 pr-4" x-text="faq.question"></h3>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-500 transform transition-transform duration-200"
                                    :class="openFAQs.includes(faq.id) ? 'rotate-180' : ''" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="openFAQs.includes(faq.id)" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                x-transition:enter-end="opacity-100 transform translate-y-0" class="px-6 pb-4">
                                <div class="prose prose-sm max-w-none text-gray-600" x-html="faq.answer"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- No Results -->
                <div x-show="filteredFAQs.length === 0" class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No articles found</h3>
                    <p class="text-gray-600 mb-4">Try adjusting your search or browse our categories</p>
                    <button @click="searchQuery = ''; selectedCategory = null; filterFAQs()"
                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                        Clear filters
                    </button>
                </div>
            </div>

            <!-- Contact Modal -->
            <div x-show="openContactModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
                @click.self="openContactModal = false">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Contact Support</h3>
                            <button @click="openContactModal = false" class="text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form @submit.prevent="submitContactForm">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                                    <select x-model="contactForm.subject"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">Select a topic</option>
                                        <option value="account">Account Issues</option>
                                        <option value="booking">Booking Problems</option>
                                        <option value="payment">Payment Issues</option>
                                        <option value="technical">Technical Support</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input type="email" x-model="contactForm.email" placeholder="your@email.com"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Message</label>
                                    <textarea x-model="contactForm.message" rows="4" placeholder="Describe your issue or question..."
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"></textarea>
                                </div>
                            </div>
                            <div class="flex gap-3 mt-6">
                                <button type="button" @click="openContactModal = false"
                                    class="flex-1 px-4 py-3 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="flex-1 px-4 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-colors">
                                    Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
    @include('navigation.Footer')
@endsection
<script>
    function helpSupport() {
        return {
            searchQuery: "",
            selectedCategory: null,
            openFAQs: [],
            openContactModal: false,
            contactForm: {
                subject: "",
                email: "",
                message: "",
            },

            categories: [{
                    id: "account",
                    name: "Account",
                    count: 12,
                    icon: "M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z",
                    bgColor: "bg-blue-100",
                    iconColor: "text-blue-600",
                },
                {
                    id: "booking",
                    name: "Booking",
                    count: 18,
                    icon: "M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h8m-8 0H6a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V9a2 2 0 00-2-2h-2",
                    bgColor: "bg-green-100",
                    iconColor: "text-green-600",
                },
                {
                    id: "payment",
                    name: "Payment",
                    count: 8,
                    icon: "M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z",
                    bgColor: "bg-yellow-100",
                    iconColor: "text-yellow-600",
                },
                {
                    id: "technical",
                    name: "Technical",
                    count: 15,
                    icon: "M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z",
                    bgColor: "bg-purple-100",
                    iconColor: "text-purple-600",
                },
            ],

            faqs: [{
                    id: 1,
                    category: "account",
                    question: "How do I create an account?",
                    answer: 'To create an account, click the "Sign Up" button on the homepage and fill out the registration form. You\'ll need to provide your email, create a password, and choose your account type (customer or service provider).',
                },
                {
                    id: 2,
                    category: "account",
                    question: "I forgot my password. How can I reset it?",
                    answer: 'Click on "Forgot Password" on the login page, enter your email address, and we\'ll send you a password reset link. Follow the instructions in the email to create a new password.',
                },
                {
                    id: 3,
                    category: "booking",
                    question: "How do I book a service?",
                    answer: "Browse our service providers, select the one you want, choose an available time slot, and complete the booking form. You'll receive a confirmation email with all the details.",
                },
                {
                    id: 4,
                    category: "booking",
                    question: "Can I cancel or reschedule my booking?",
                    answer: 'Yes, you can cancel or reschedule your booking up to 24 hours before the scheduled time. Go to "My Bookings" in your dashboard and select the booking you want to modify.',
                },
                {
                    id: 5,
                    category: "payment",
                    question: "What payment methods do you accept?",
                    answer: "We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers. All payments are processed securely through our encrypted payment system.",
                },
                {
                    id: 6,
                    category: "payment",
                    question: "When will I be charged for my booking?",
                    answer: "Payment is processed immediately when you confirm your booking. For some services, a deposit may be required upfront with the balance due after service completion.",
                },
                {
                    id: 7,
                    category: "technical",
                    question: "The website is not loading properly. What should I do?",
                    answer: "Try clearing your browser cache and cookies, or try accessing the site from a different browser. If the problem persists, please contact our technical support team.",
                },
                {
                    id: 8,
                    category: "technical",
                    question: "I'm not receiving email notifications. How can I fix this?",
                    answer: "Check your spam/junk folder first. If emails aren't there, verify your email address in your account settings and ensure notifications are enabled in your preferences.",
                },
            ],

            filteredFAQs: [],

            init() {
                this.filteredFAQs = this.faqs;
            },

            filterFAQs() {
                let filtered = this.faqs;

                // Filter by category
                if (this.selectedCategory) {
                    filtered = filtered.filter(
                        (faq) => faq.category === this.selectedCategory
                    );
                }

                // Filter by search query
                if (this.searchQuery.trim()) {
                    const query = this.searchQuery.toLowerCase();
                    filtered = filtered.filter(
                        (faq) =>
                        faq.question.toLowerCase().includes(query) ||
                        faq.answer.toLowerCase().includes(query)
                    );
                }

                this.filteredFAQs = filtered;
            },

            toggleFAQ(id) {
                const index = this.openFAQs.indexOf(id);
                if (index > -1) {
                    this.openFAQs.splice(index, 1);
                } else {
                    this.openFAQs.push(id);
                }
            },

            submitContactForm() {
                // Validate form
                if (
                    !this.contactForm.subject ||
                    !this.contactForm.email ||
                    !this.contactForm.message
                ) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Fields',
                        text: 'Please fill in all fields.',
                        confirmButtonColor: '#4338CA',
                    });

                    return;
                }

                // Here you would typically send the form data to your backend
                console.log("Contact form submitted:", this.contactForm);

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Thank You!',
                    text: "Thank you for contacting us! We'll get back to you within 24 hours.",
                    confirmButtonColor: '#4338CA',
                });


                // Reset form and close modal
                this.contactForm = {
                    subject: "",
                    email: "",
                    message: ""
                };
                this.openContactModal = false;
            },
        };
    }
</script>
