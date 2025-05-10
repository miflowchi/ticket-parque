document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".carousel-slide");
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle("active", i === index);
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }

    // Initialize the carousel
    showSlide(currentIndex);
    setInterval(nextSlide, 5000); // Change slide every 5 seconds
});
