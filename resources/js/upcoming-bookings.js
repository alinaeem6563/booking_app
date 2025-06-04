
const upcomingBookings = [
    {
        id: 1,
        clientName: "Jennifer Wilson",
        clientImage: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150",
        clientPhone: "+1 (555) 123-4567",
        service: "Deep Cleaning",
        category: "cleaning",
        date: "2024-01-16",
        time: "10:00 AM",
        endTime: "1:00 PM",
        duration: "3 hours",
        rate: 50,
        total: 150,
        address: "123 Main St, Downtown",
        notes: "Please focus on kitchen and bathrooms. Client will provide cleaning supplies.",
        status: "confirmed",
        isToday: true
    },
    {
        id: 2,
        clientName: "Michael Roberts",
        clientImage: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150",
        clientPhone: "+1 (555) 987-6543",
        service: "Pipe Repair",
        category: "plumbing",
        date: "2024-01-16",
        time: "2:00 PM",
        endTime: "4:00 PM",
        duration: "2 hours",
        rate: 75,
        total: 150,
        address: "456 Oak Ave, Midtown",
        notes: "Kitchen sink pipe leak. Emergency repair needed.",
        status: "confirmed",
        isToday: true
    },
    {
        id: 3,
        clientName: "Sarah Davis",
        clientImage: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150",
        clientPhone: "+1 (555) 456-7890",
        service: "Regular Cleaning",
        category: "cleaning",
        date: "2024-01-17",
        time: "9:00 AM",
        endTime: "11:00 AM",
        duration: "2 hours",
        rate: 40,
        total: 80,
        address: "789 Pine St, Uptown",
        notes: "Weekly cleaning service. Key is under the mat.",
        status: "confirmed",
        isToday: false
    }
];

document.addEventListener('DOMContentLoaded', function() {
    const bookingsTimeline = document.getElementById('bookings-timeline');
    const timeFilter = document.getElementById('time-filter');
    const serviceFilter = document.getElementById('service-filter');
    const searchInput = document.getElementById('search-bookings');

    function getStatusBadge(status) {
        const badges = {
            confirmed: 'bg-green-100 text-green-800',
            pending: 'bg-yellow-100 text-yellow-800',
            completed: 'bg-blue-100 text-blue-800',
            cancelled: 'bg-red-100 text-red-800'
        };
        return badges[status] || 'bg-gray-100 text-gray-800';
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const today = new Date();
        const tomorrow = new Date(today);
        tomorrow.setDate(tomorrow.getDate() + 1);

        if (date.toDateString() === today.toDateString()) {
            return 'Today';
        } else if (date.toDateString() === tomorrow.toDateString()) {
            return 'Tomorrow';
        } else {
            return date.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    }

    function renderBookings(bookings) {
        if (bookings.length === 0) {
            bookingsTimeline.innerHTML = `
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming bookings</h3>
                    <p class="mt-1 text-sm text-gray-500">Your upcoming bookings will appear here.</p>
                </div>
            `;
            return;
        }

        // Group bookings by date
        const groupedBookings = bookings.reduce((groups, booking) => {
            const date = booking.date;
            if (!groups[date]) {
                groups[date] = [];
            }
            groups[date].push(booking);
            return groups;
        }, {});

        bookingsTimeline.innerHTML = Object.entries(groupedBookings).map(([date, dayBookings]) => `
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">${formatDate(date)}</h3>
                    <p class="text-sm text-gray-500">${dayBookings.length} booking${dayBookings.length !== 1 ? 's' : ''}</p>
                </div>
                <div class="divide-y divide-gray-200">
                    ${dayBookings.map(booking => `
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <img class="h-12 w-12 rounded-full object-cover" src="${booking.clientImage}" alt="${booking.clientName}">
                                    <div class="ml-4">
                                        <h4 class="text-lg font-medium text-gray-900">${booking.clientName}</h4>
                                        <p class="text-sm text-gray-500">${booking.clientPhone}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusBadge(booking.status)}">
                                        ${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}
                                    </span>
                                    ${booking.isToday ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Today</span>' : ''}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Service</p>
                                    <p class="text-sm text-gray-900">${booking.service}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Time</p>
                                    <p class="text-sm text-gray-900">${booking.time} - ${booking.endTime}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Duration</p>
                                    <p class="text-sm text-gray-900">${booking.duration}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Total</p>
                                    <p class="text-sm text-gray-900 font-semibold">$${booking.total}</p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-500 mb-1">Address</p>
                                <p class="text-sm text-gray-900">${booking.address}</p>
                            </div>

                            ${booking.notes ? `
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-500 mb-1">Notes</p>
                                    <p class="text-sm text-gray-700">${booking.notes}</p>
                                </div>
                            ` : ''}

                            <div class="flex flex-wrap gap-3">
                                <button onclick="contactClient(${booking.id})" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    Contact
                                </button>
                                <button onclick="getDirections(${booking.id})" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Directions
                                </button>
                                ${booking.isToday ? `
                                    <button onclick="startService(${booking.id})" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Start Service
                                    </button>
                                ` : ''}
                                <button onclick="rescheduleBooking(${booking.id})" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Reschedule
                                </button>
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        `).join('');
    }

    function filterBookings() {
        let filtered = [...upcomingBookings];
        
        const timeFilter = document.getElementById('time-filter').value;
        const serviceFilter = document.getElementById('service-filter').value;
        const searchTerm = document.getElementById('search-bookings').value.toLowerCase();

        if (timeFilter !== 'all') {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);

            filtered = filtered.filter(booking => {
                const bookingDate = new Date(booking.date);
                switch (timeFilter) {
                    case 'today':
                        return bookingDate.toDateString() === today.toDateString();
                    case 'tomorrow':
                        return bookingDate.toDateString() === tomorrow.toDateString();
                    case 'week':
                        const weekFromNow = new Date(today);
                        weekFromNow.setDate(weekFromNow.getDate() + 7);
                        return bookingDate >= today && bookingDate <= weekFromNow;
                    case 'month':
                        const monthFromNow = new Date(today);
                        monthFromNow.setMonth(monthFromNow.getMonth() + 1);
                        return bookingDate >= today && bookingDate <= monthFromNow;
                    default:
                        return true;
                }
            });
        }

        if (serviceFilter) {
            filtered = filtered.filter(booking => booking.category === serviceFilter);
        }

        if (searchTerm) {
            filtered = filtered.filter(booking => 
                booking.clientName.toLowerCase().includes(searchTerm) ||
                booking.service.toLowerCase().includes(searchTerm)
            );
        }

        renderBookings(filtered);
    }

    // Event listeners
    timeFilter.addEventListener('change', filterBookings);
    serviceFilter.addEventListener('change', filterBookings);
    searchInput.addEventListener('input', filterBookings);

    // Initial render
    renderBookings(upcomingBookings);
});

function contactClient(id) {
    const booking = upcomingBookings.find(b => b.id === id);
    if (booking) {
        window.open(`tel:${booking.clientPhone}`);
    }
}

function getDirections(id) {
    const booking = upcomingBookings.find(b => b.id === id);
    if (booking) {
        const address = encodeURIComponent(booking.address);
        window.open(`https://maps.google.com/maps?q=${address}`, '_blank');
    }
}

function startService(id) {
    alert('Start service functionality would be implemented here');
}

function rescheduleBooking(id) {
    alert('Reschedule booking functionality would be implemented here');
}


