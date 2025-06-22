{{-- Reschedule Modal Styles --}}
<style>
    /* Reschedule Modal Styles */
    #rescheduleModal {
        backdrop-filter: blur(4px);
    }

    .slot-option {
        position: relative;
    }

    .slot-radio:checked+.slot-card {
        @apply border-indigo-500 bg-indigo-50;
    }

    .slot-radio:checked+.slot-card .slot-indicator {
        @apply border-indigo-500 bg-indigo-500;
    }

    .slot-radio:checked+.slot-card .slot-checkmark {
        @apply opacity-100;
    }

    .slot-card {
        @apply cursor-pointer transition-all duration-200;
    }

    .slot-card:hover {
        @apply border-indigo-300 bg-indigo-50 transform scale-105;
    }

    .slot-indicator {
        @apply transition-all duration-200;
    }

    .slot-checkmark {
        @apply transition-opacity duration-200;
    }

    /* Custom scrollbar for slots container */
    #slotsContainer::-webkit-scrollbar {
        width: 6px;
    }

    #slotsContainer::-webkit-scrollbar-track {
        @apply bg-gray-100 rounded-full;
    }

    #slotsContainer::-webkit-scrollbar-thumb {
        @apply bg-indigo-300 rounded-full;
    }

    #slotsContainer::-webkit-scrollbar-thumb:hover {
        @apply bg-indigo-400;
    }

    /* Date group styling */
    .date-group {
        @apply mb-6 last:mb-0;
    }

    .date-group h5 {
        @apply sticky top-0 bg-white z-10;
    }

    /* Loading animation */
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    /* Modal responsive adjustments */
    @media (max-width: 640px) {
        #rescheduleModal .sm\\:max-w-2xl {
            max-width: calc(100vw - 2rem) !important;
            margin: 1rem !important;
        }

        #slotsContainer {
            max-height: 200px !important;
        }

        .slot-card {
            @apply p-2;
        }

        .date-group .grid {
            @apply grid-cols-2 gap-1;
        }
    }

    /* Enhanced visual feedback */
    .slot-card.selected {
        @apply border-indigo-500 bg-indigo-50 shadow-md;
    }

    .slot-card.selected .slot-indicator {
        @apply border-indigo-500 bg-indigo-500;
    }

    .slot-card.selected .slot-checkmark {
        @apply opacity-100;
    }

    /* Smooth transitions */
    * {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Focus styles for accessibility */
    .slot-radio:focus+.slot-card {
        @apply ring-2 ring-indigo-500 ring-offset-2;
    }

    /* Button hover effects */
    button:hover {
        transform: translateY(-1px);
    }

    button:active {
        transform: translateY(0);
    }

    /* Modal entrance animation */
    #rescheduleModal.show {
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Success and error message styles */
    .success-message {
        @apply bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg;
    }

    .error-message {
        @apply bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg;
    }

    /* Loading overlay */
    #loadingOverlay {
        backdrop-filter: blur(2px);
    }

    /* Responsive grid adjustments */
    @media (min-width: 768px) {
        .date-group .grid {
            @apply grid-cols-4;
        }
    }

    @media (min-width: 1024px) {
        .date-group .grid {
            @apply grid-cols-5;
        }
    }

    /* Slot card hover animation */
    .slot-card:hover {
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.15);
    }

    /* Selected slot animation */
    @keyframes checkmark {
        0% {
            transform: scale(0);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    .slot-checkmark.animate-checkmark {
        animation: checkmark 0.3s ease-in-out;
    }

    /* Modal backdrop blur effect */
    #rescheduleModal .fixed.inset-0 {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    /* Improved button states */
    button:disabled {
        @apply opacity-50 cursor-not-allowed;
        transform: none !important;
    }

    button:disabled:hover {
        transform: none !important;
    }

    /* Enhanced focus states */
    button:focus {
        @apply outline-none ring-2 ring-offset-2;
    }

    .bg-indigo-600:focus {
        @apply ring-indigo-500;
    }

    .bg-red-600:focus {
        @apply ring-red-500;
    }

    .bg-gray-200:focus {
        @apply ring-gray-500;
    }

    /* Smooth modal transitions */
    #rescheduleModal {
        transition: opacity 0.3s ease-out, visibility 0.3s ease-out;
    }

    #rescheduleModal.hidden {
        opacity: 0;
        visibility: hidden;
    }

    #rescheduleModal:not(.hidden) {
        opacity: 1;
        visibility: visible;
    }

    /* Mobile-first responsive design */
    @media (max-width: 480px) {
        #rescheduleModal .inline-block {
            width: calc(100vw - 1rem) !important;
            margin: 0.5rem !important;
        }

        .slot-card {
            @apply text-xs p-2;
        }

        .date-group .grid {
            @apply grid-cols-1 gap-2;
        }
    }
</style>
{{-- Ensure CSRF token is available --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- Include the JavaScript file --}}
@vite('resources/js/reschedule-modal.js')


