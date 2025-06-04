document.addEventListener("DOMContentLoaded", function () {
    const providersGrid = document.getElementById("providers-grid");
    const emptyState = document.getElementById("empty-state");
    const providerShowRouteBase = "{{ url('/providers') }}";
    const searchInput = document.getElementById("search-providers");
    const categoryFilter = document.getElementById("category-filter");
    const ratingFilter = document.getElementById("rating-filter");
    const sortFilter = document.getElementById("sort-filter");

    let savedProviders = [];

    fetch("/get-saved-providers", {
        headers: {
            "X-Requested-With": "XMLHttpRequest",
        },
        credentials: "same-origin",
    })
        .then((res) => res.json())
        .then((data) => {
            if (!Array.isArray(data)) {
                throw new Error("Invalid response format");
            }

            savedProviders = data.map((p) => ({
                id: p.id,
                name: p.name,
                image: p.image || "/images/default-avatar.png",
                rating: p.rating || 0,
                review: p.review_count || 0,
                verified: p.verified || false,
                hourlyRate: p.hourly_rate || null,
                responseTime: p.response_time || "N/A",
                service: p.service_name || "General",
                category: String(p.category_id || ""),
                savedDate: new Date(p.saved_at || p.created_at || Date.now()),
                serviceId: p.service_id || p.id,
            }));

            renderProviders(savedProviders);
        })
        .catch((err) => {
            console.error("Error loading saved providers", err);
            Swal.fire({
                icon: "error",
                title: "Oops!",
                text: "Failed to load saved providers. Try again later.",
            });
        });

    function renderProviders(providers) {
        if (providers.length === 0) {
            providersGrid.classList.add("hidden");
            emptyState.classList.remove("hidden");
            return;
        }

        providersGrid.classList.remove("hidden");
        emptyState.classList.add("hidden");

        providersGrid.innerHTML = providers
            .map(
                (provider) => `
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <img class="h-12 w-12 rounded-full object-cover" src="${
                                provider.image
                            }" alt="${provider.name}">
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">${
                                    provider.name
                                }</h3>
                                <p class="text-sm text-gray-500">${
                                    provider.service
                                }</p>
                            </div>
                        </div>
                        <button onclick="removeProvider(${
                            provider.serviceId
                        })" class="text-red-500 hover:text-red-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center mb-3">
                        ${[...Array(5)]
                            .map(
                                (_, i) => `
                            <svg class="h-4 w-4 ${
                                i < Math.floor(provider.rating)
                                    ? "text-yellow-400"
                                    : "text-gray-300"
                            }" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        `
                            )
                            .join("")}
                        <span class="ml-2 text-sm text-gray-600">${
                            provider.rating
                        } (${provider.review} reviews)</span>
                        ${
                            provider.verified
                                ? '<span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Verified</span>'
                                : ""
                        }
                    </div>
                    <div class="text-sm text-gray-600 mb-4">
                        ${
                            provider.hourlyRate !== null
                                ? `<p class="mb-1">$${provider.hourlyRate}/hour</p>`
                                : ""
                        }
                        <p>${provider.responseTime}</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="window.location.href='{{ route('providers.show', $service->id) }}'"
                         class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition-colors">
                            Book Now
                        </button>

                    </div>
                </div>
            </div>
        `
            )
            .join("");
    }

    function filterProviders() {
        let filtered = [...savedProviders];

        const searchTerm = searchInput.value.toLowerCase();
        const category = categoryFilter.value;
        const rating = ratingFilter.value;
        const sort = sortFilter.value;

        if (searchTerm) {
            filtered = filtered.filter(
                (provider) =>
                    provider.name.toLowerCase().includes(searchTerm) ||
                    provider.service.toLowerCase().includes(searchTerm)
            );
        }

        if (category) {
            filtered = filtered.filter(
                (provider) => provider.category === category
            );
        }

        if (rating) {
            filtered = filtered.filter(
                (provider) => parseFloat(provider.rating) >= parseFloat(rating)
            );
        }

        switch (sort) {
            case "rating":
                filtered.sort((a, b) => b.rating - a.rating);
                break;
            case "name":
                filtered.sort((a, b) => a.name.localeCompare(b.name));
                break;
            case "recent":
            default:
                filtered.sort(
                    (a, b) => new Date(b.savedDate) - new Date(a.savedDate)
                );
                break;
        }

        renderProviders(filtered);
    }

    // Filter events
    searchInput.addEventListener("input", filterProviders);
    categoryFilter.addEventListener("change", filterProviders);
    ratingFilter.addEventListener("change", filterProviders);
    sortFilter.addEventListener("change", filterProviders);

    // Remove provider (toggle unfavorite)
    window.removeProvider = function (serviceId) {
        if (confirm("Remove this provider from your saved list?")) {
            fetch("/saved-providers", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute("content"),
                    "X-Requested-With": "XMLHttpRequest",
                },
                credentials: "same-origin",
                body: JSON.stringify({ service_id: serviceId }),
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success && data.status === "removed") {
                        const index = savedProviders.findIndex(
                            (p) => p.serviceId === serviceId
                        );
                        if (index > -1) {
                            savedProviders.splice(index, 1);
                            filterProviders();
                        }

                        Swal.fire({
                            icon: "success",
                            title: "Removed!",
                            text: data.message,
                        });
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "Not Removed",
                            text:
                                data.message ||
                                "Provider could not be removed.",
                        });
                    }
                })
                .catch((err) => {
                    console.error("Error removing provider:", err);
                    Swal.fire({
                        icon: "error",
                        title: "Oops!",
                        text: "Failed to remove provider. Try again later.",
                    });
                });
        }
    };

    // Placeholder actions
    window.contactProvider = function (id) {
        alert("Contact provider functionality would be implemented here");
    };

    window.bookProvider = function (id) {
        alert("Book provider functionality would be implemented here");
    };
});
