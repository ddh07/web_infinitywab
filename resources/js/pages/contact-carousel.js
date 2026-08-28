export function initContactCarousel() {
    const carousel = document.querySelector('.hero-contact-carousel');
    const track = document.querySelector('.hero-carousel-track');
    const slides = document.querySelectorAll('.hero-carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');

    if (!carousel || !track || !slides.length || !dots.length) return;

    let currentSlide = 0;
    const totalSlides = slides.length;
    let autoPlayInterval;

    function updateDots() {
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentSlide);
        });
    }

    function goToSlide(index) {
        currentSlide = ((index % totalSlides) + totalSlides) % totalSlides;
        const offset = -(currentSlide * (100 / totalSlides));
        track.style.transform = `translateX(${offset}%)`;
        updateDots();
        resetAutoPlay();
    }

    function nextSlide() {
        goToSlide(currentSlide + 1);
    }

    function startAutoPlay() {
        if ((window.__forceReducedMotion === true || window.matchMedia('(prefers-reduced-motion: reduce)').matches)) return;
        autoPlayInterval = setInterval(nextSlide, 6000);
    }

    function stopAutoPlay() {
        if (autoPlayInterval) clearInterval(autoPlayInterval);
    }

    function resetAutoPlay() {
        stopAutoPlay();
        startAutoPlay();
    }

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });

    carousel.addEventListener('mouseenter', stopAutoPlay);
    carousel.addEventListener('mouseleave', startAutoPlay);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') goToSlide(currentSlide - 1);
        if (e.key === 'ArrowRight') nextSlide();
    });

    let touchStartX = 0;
    let touchEndX = 0;

    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    carousel.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) <= swipeThreshold) return;
        if (diff > 0) nextSlide();
        else goToSlide(currentSlide - 1);
    });

    updateDots();
    startAutoPlay();
}

