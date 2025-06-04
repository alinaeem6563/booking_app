
document.addEventListener("DOMContentLoaded", function() {
    // Handle star rating selection
    const stars = document.querySelectorAll(".rating-star");
    const ratingInput = document.getElementById("rating-value");

    if (stars.length && ratingInput) {
        stars.forEach(star => {
            star.addEventListener("click", function() {
                const selectedRating = parseInt(this.dataset.value);
                ratingInput.value = selectedRating;

                stars.forEach(s => {
                    const svg = s.querySelector("svg");
                    if (parseInt(s.dataset.value) <= selectedRating) {
                        svg.classList.remove("text-gray-300");
                        svg.classList.add("text-yellow-400");
                    } else {
                        svg.classList.remove("text-yellow-400");
                        svg.classList.add("text-gray-300");
                    }
                });
            });
        });
    }

    // Handle "View All Photos" button
    const galleryBtn = document.getElementById("viewAllBtn");
    if (galleryBtn) {
        galleryBtn.addEventListener("click", function() {
            document.querySelectorAll(".extra-image").forEach(el => {
                el.classList.remove("hidden");
            });
            galleryBtn.style.display = "none";
        });
    }

    // Handle "View All Reviews" button
    const reviewBtn = document.getElementById("viewAllReviewsBtn");
    if (reviewBtn) {
        reviewBtn.addEventListener("click", function() {
            document.querySelectorAll(".extra-review").forEach(el => {
                el.classList.remove("hidden");
            });
            reviewBtn.style.display = "none";
        });
    }
});
