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
    <div class="group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="relative h-48 bg-gray-200 overflow-hidden">
            <img src="${provider.image}" alt="Service Image"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            <button onclick="removeProvider(${provider.serviceId})"
                class="save-provider-btn absolute top-3 right-3 p-2 bg-white/90 backdrop-blur-sm rounded-xl shadow-sm hover:bg-white transition-all duration-200">
                <svg class="h-5 w-5 heart-icon transition-all duration-200 text-red-500 fill-red-500"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </button>
        </div>

        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200">
                ${provider.service}
            </h3>

            <div class="flex items-center mb-3">
                <div class="flex items-center">
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
                </div>
                <span class="text-sm text-gray-600 ml-2">
                    ${provider.rating} (${provider.review} ${
                    provider.review == 1 ? "review" : "reviews"
                })
                </span>
            </div>

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-baseline">
                    <span class="text-2xl font-bold text-gray-900">$${
                        provider.hourlyRate ?? "N/A"
                    }</span>
                    <span class="text-sm text-gray-600 ml-1">/hour</span>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900">${
                        provider.name
                    }</p>
                    <p class="text-xs text-gray-500">Service Provider</p>
                </div>
            </div>

            <button onclick="window.location.href='/providers/${
                provider.serviceId
            }'"
                class="w-full inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-xl hover:from-indigo-700 hover:to-indigo-800 transform hover:scale-105 transition-all duration-200 shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Book Now
            </button>
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
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to remove this provider from your saved list.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, remove it!",
            }).then((result) => {
                if (result.isConfirmed) {
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
                                    title: "Removed!",
                                    text: data.message,
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false,
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
            });
        };
        
   

    // Placeholder actions
    window.contactProvider = function (id) {
        alert("Contact provider functionality would be implemented here");
    };

    window.bookProvider = function (id) {
        alert("Book provider functionality would be implemented here");
    };
});
