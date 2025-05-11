<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
   @vite(['resources/js/bookease.js', 'resources/js/sidebar.js'])

</head>
<body class="font-[Inter] bg-gray-50 text-gray-900">
    <div x-data="{
        sidebarOpen: window.innerWidth >= 768,
        
        init() {
            this.checkScreenSize();
            window.addEventListener('resize', () => {
                this.checkScreenSize();
            });
        },
        
        checkScreenSize() {
            const isDesktop = window.innerWidth >= 768;
            if (isDesktop !== this.sidebarOpen) {
                this.sidebarOpen = isDesktop;
            }
        },
        
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        }
    }">
        <!-- Include the sidebar component -->
        @include('navigation.sidebar', ['role' => $userRole ?? 'user'])

        <!-- Main Content -->
        <div class="flex-1 md:ml-64">
           @yield('content')
        </div>
    </div>
</body>
</html>