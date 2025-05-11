/**
 * Sidebar Manager - Alpine.js component
 * Handles the sidebar visibility and responsiveness
 * @returns {object} Alpine.js component data and methods
 */
function sidebarManager() {
    return {
        sidebarOpen: window.innerWidth >= 768, // Default open on desktop (md breakpoint)

        init() {
            // Set initial state based on screen size
            this.checkScreenSize();

            // Listen for window resize events
            window.addEventListener("resize", () => {
                this.checkScreenSize();
            });
        },

        checkScreenSize() {
            // Check if we're on desktop or mobile
            const isDesktop = window.innerWidth >= 768;

            // Only update if necessary to prevent unnecessary re-renders
            if (isDesktop !== this.sidebarOpen) {
                this.sidebarOpen = isDesktop;
            }
        },

        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        },
    };
}

// Export the sidebar manager
window.sidebarManager = sidebarManager;
