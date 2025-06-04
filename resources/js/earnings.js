
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
const transactions = [
    {
        id: 1,
        date: "2024-01-15",
        clientName: "Jennifer Wilson",
        service: "Deep Cleaning",
        amount: 150,
        status: "completed",
        payoutDate: "2024-01-17"
    },
    {
        id: 2,
        date: "2024-01-14",
        clientName: "Michael Roberts",
        service: "Pipe Repair",
        amount: 200,
        status: "completed",
        payoutDate: "2024-01-16"
    },
    {
        id: 3,
        date: "2024-01-13",
        clientName: "Sarah Davis",
        service: "Regular Cleaning",
        amount: 80,
        status: "pending",
        payoutDate: null
    },
    {
        id: 4,
        date: "2024-01-12",
        clientName: "David Johnson",
        service: "Move-out Cleaning",
        amount: 250,
        status: "completed",
        payoutDate: "2024-01-14"
    },
    {
        id: 5,
        date: "2024-01-11",
        clientName: "Lisa Brown",
        service: "Deep Cleaning",
        amount: 175,
        status: "refunded",
        payoutDate: null
    }
];

document.addEventListener('DOMContentLoaded', function() {
    const transactionsTbody = document.getElementById('transactions-tbody');
    const transactionFilter = document.getElementById('transaction-filter');
    const dateFilter = document.getElementById('date-filter');

    // Initialize earnings chart
    initializeEarningsChart();

    function getStatusBadge(status) {
        const badges = {
            completed: 'bg-green-100 text-green-800',
            pending: 'bg-yellow-100 text-yellow-800',
            refunded: 'bg-red-100 text-red-800'
        };
        return badges[status] || 'bg-gray-100 text-gray-800';
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }

    function renderTransactions(transactions) {
        transactionsTbody.innerHTML = transactions.map(transaction => `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${formatDate(transaction.date)}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${transaction.clientName}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${transaction.service}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    $${transaction.amount}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${getStatusBadge(transaction.status)}">
                        ${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <button onclick="viewTransaction(${transaction.id})" class="text-purple-600 hover:text-purple-900">
                        View Details
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function filterTransactions() {
        let filtered = [...transactions];
        
        const status = transactionFilter.value;
        const date = dateFilter.value;

        if (status !== 'all') {
            filtered = filtered.filter(transaction => transaction.status === status);
        }

        if (date) {
            filtered = filtered.filter(transaction => transaction.date === date);
        }

        renderTransactions(filtered);
    }

    function initializeEarningsChart() {
        const ctx = document.getElementById('earnings-chart').getContext('2d');
        
        // Sample data for the last 7 days
        const chartData = {
            labels: ['Jan 9', 'Jan 10', 'Jan 11', 'Jan 12', 'Jan 13', 'Jan 14', 'Jan 15'],
            datasets: [{
                label: 'Daily Earnings',
                data: [120, 190, 80, 250, 175, 200, 150],
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        };

        new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
    }

    // Event listeners
    transactionFilter.addEventListener('change', filterTransactions);
    dateFilter.addEventListener('change', filterTransactions);

    // Initial render
    renderTransactions(transactions);
});

function viewTransaction(id) {
    alert('View transaction details functionality would be implemented here');
}
