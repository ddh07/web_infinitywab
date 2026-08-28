// Barre de progression de lecture en haut de page : sa largeur (scaleX) suit la
// position de scroll. Purement informatif, donc actif même en prefers-reduced-motion
// (seule la transition d'accompagnement est neutralisée par la règle CSS globale).
export function initScrollProgress() {
    const bar = document.getElementById('scroll-progress-bar');
    if (!bar) return;

    let ticking = false;

    const update = () => {
        const scrollable = document.documentElement.scrollHeight - window.innerHeight;
        const progress = scrollable > 0 ? Math.min(window.scrollY / scrollable, 1) : 0;
        bar.style.transform = `scaleX(${progress})`;
        ticking = false;
    };

    const onScroll = () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(update);
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    update();
}
