
const bookingRequests = [{
        id: 1,
        clientName: "Jennifer Wilson",
        clientImage: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150",
        service: "Deep Cleaning",
        category: "cleaning",
        date: "2024-01-20",
        time: "10:00 AM",
        duration: "3 hours",
        budget: 150,
        status: "pending",
        requestDate: "2024-01-15T10:30:00",
        address: "123 Main St, Downtown",
        description: "Need a thorough deep cleaning for my 2-bedroom apartment. Focus on kitchen and bathrooms.",
        urgency: "normal"
    },
    {
        id: 2,
        clientName: "Michael Roberts",
        clientImage: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150",
        service: "Pipe Repair",
        category: "plumbing",
        date: "2024-01-18",
        time: "2:00 PM",
        duration: "2 hours",
        budget: 200,
        status: "pending",
        requestDate: "2024-01-15T14:20:00",
        address: "456 Oak Ave, Midtown",
        description: "Kitchen sink pipe is leaking. Need urgent repair.",
        urgency: "urgent"
    },
    {
        id: 3,
        clientName: "Sarah Davis",
        clientImage: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150",
        service: "Regular Cleaning",
        category: "cleaning",
        date: "2024-01-22",
        time: "9:00 AM",
        duration: "2 hours",
        budget: 80,
        status: "accepted",
        requestDate: "2024-01-14T09:15:00",
        address: "789 Pine St, Uptown",
        description: "Weekly cleaning service for small apartment.",
        urgency: "normal"
    }
];

document.addEventListener('DOMContentLoaded', function() {
    const requestsContainer = document.getElementById('requests-container');
    const emptyState = document.getElementById('empty-state');
    const statusFilter = document.getElementById('status-filter');
    const serviceFilter = document.getElementById('service-filter');
    const dateFilter = document.getElementById('date-filter');

    function getStatusBadge(status) {
        const badges = {
            pending: 'bg-yellow-100 text-yellow-800',
            accepted: 'bg-green-100 text-green-800',
            declined: 'bg-red-100 text-red-800'
        };
        return badges[status] || 'bg-gray-100 text-gray-800';
    }

    function getUrgencyBadge(urgency) {
        const badges = {
            urgent: 'bg-red-100 text-red-800',
            normal: 'bg-blue-100 text-blue-800'
        };
        return badges[urgency] || 'bg-gray-100 text-gray-800';
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function renderRequests(requests) {
        if (requests.length === 0) {
            requestsContainer.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        requestsContainer.classList.remove('hidden');
        emptyState.classList.add('hidden');

        requestsContainer.innerHTML = requests.map(request => `
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center">
                    <img class="h-12 w-12 rounded-full object-cover" src="${request.clientImage}" alt="${request.clientName}">
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">${request.clientName}</h3>
                        <p class="text-sm text-gray-500">Requested ${formatDate(request.requestDate)}</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusBadge(request.status)}">
                        ${request.status.charAt(0).toUpperCase() + request.status.slice(1)}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getUrgencyBadge(request.urgency)}">
                        ${request.urgency.charAt(0).toUpperCase() + request.urgency.slice(1)}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Service</p>
                    <p class="text-sm text-gray-900">${request.service}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Date & Time</p>
                    <p class="text-sm text-gray-900">${request.date} at ${request.time}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Duration</p>
                    <p class="text-sm text-gray-900">${request.duration}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Budget</p>
                    <p class="text-sm text-gray-900">$${request.budget}</p>
                </div>
            </div>

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-500 mb-1">Address</p>
                <p class="text-sm text-gray-900">${request.address}</p>
            </div>

            <div class="mb-6">
                <p class="text-sm font-medium text-gray-500 mb-1">Description</p>
                <p class="text-sm text-gray-700">${request.description}</p>
            </div>

            ${request.status === 'pending' ? `
                    <div class="flex space-x-3">
                        <button onclick="respondToRequest(${request.id}, 'accept')" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 transition-colors">
                            Accept Request
                        </button>
                        <button onclick="respondToRequest(${request.id}, 'decline')" class="flex-1 bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition-colors">
                            Decline Request
                        </button>
                        <button onclick="viewDetails(${request.id})" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            View Details
                        </button>
                    </div>
                ` : `
                    <div class="flex justify-end">
                        <button onclick="viewDetails(${request.id})" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                            View Details
                        </button>
                    </div>
                `}
        </div>
    </div>
`).join('');
    }

    function filterRequests() {
        let filtered = [...bookingRequests];

        const status = statusFilter.value;
        const service = serviceFilter.value;
        const date = dateFilter.value;

        if (status) {
            filtered = filtered.filter(request => request.status === status);
        }

        if (service) {
            filtered = filtered.filter(request => request.category === service);
        }

        if (date) {
            filtered = filtered.filter(request => request.date === date);
        }

        renderRequests(filtered);
    }

    // Event listeners
    statusFilter.addEventListener('change', filterRequests);
    serviceFilter.addEventListener('change', filterRequests);
    dateFilter.addEventListener('change', filterRequests);

    // Initial render
    renderRequests(bookingRequests);
});

function respondToRequest(id, action) {
    const request = bookingRequests.find(r => r.id === id);
    if (!request) return;

    const modal = document.getElementById('response-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalContent = document.getElementById('modal-content');

    modalTitle.textContent = action === 'accept' ? 'Accept Booking Request' : 'Decline Booking Request';

    modalContent.innerHTML = `
<div class="mb-4">
    <p class="text-sm text-gray-600 mb-2">Client: ${request.clientName}</p>
    <p class="text-sm text-gray-600 mb-2">Service: ${request.service}</p>
    <p class="text-sm text-gray-600 mb-4">Date: ${request.date} at ${request.time}</p>
</div>

${action === 'accept' ? `
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Your Rate (per hour)</label>
            <input type="number" id="rate-input" class="w-full border-gray-300 rounded-md" value="50" min="1">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Message to Client</label>
            <textarea id="message-input" rows="3" class="w-full border-gray-300 rounded-md" placeholder="Thank you for choosing my services..."></textarea>
        </div>
    ` : `
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Declining</label>
            <select id="decline-reason" class="w-full border-gray-300 rounded-md mb-2">
                <option value="">Select a reason</option>
                <option value="schedule">Schedule conflict</option>
                <option value="location">Location too far</option>
                <option value="service">Service not offered</option>
                <option value="other">Other</option>
            </select>
            <textarea id="decline-message" rows="3" class="w-full border-gray-300 rounded-md" placeholder="Additional message (optional)"></textarea>
        </div>
    `}

<div class="flex justify-end space-x-3">
    <button onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
        Cancel
    </button>
    <button onclick="confirmResponse(${id}, '${action}')" class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm font-medium hover:bg-purple-700">
        ${action === 'accept' ? 'Accept Request' : 'Decline Request'}
    </button>
</div>
`;

    modal.classList.remove('hidden');
}

function confirmResponse(id, action) {
    const request = bookingRequests.find(r => r.id === id);
    if (request) {
        request.status = action === 'accept' ? 'accepted' : 'declined';
        closeModal();
        document.getElementById('status-filter').dispatchEvent(new Event('change'));

        // Show success message
        alert(`Request ${action}ed successfully!`);
    }
}

function closeModal() {
    document.getElementById('response-modal').classList.add('hidden');
}

function viewDetails(id) {
    alert('View details functionality would be implemented here');
}
