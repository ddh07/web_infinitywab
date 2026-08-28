// Parallax léger sur les calques décoratifs (vidéo de fond, tracé infini...) marqués
// [data-parallax]. Désactivé entièrement si l'utilisateur préfère moins de mouvement :
// le parallax (déplacement continu lié au scroll) est un déclencheur connu de malaise
// vestibulaire, on ne se contente pas de le ralentir, on ne l'active pas du tout.
export function initScrollParallax() {
    if ((window.__forceReducedMotion === true || window.matchMedia('(prefers-reduced-motion: reduce)').matches)) return;

    const layers = document.querySelectorAll('[data-parallax]');
    if (!layers.length) return;

    let ticking = false;

    const update = () => {
        layers.forEach((layer) => {
            const speed = parseFloat(layer.dataset.parallax) || 0.15;
            const rect = layer.closest('section')?.getBoundingClientRect();
            const offset = rect ? rect.top * speed : 0;
            layer.style.transform = `translate3d(0, ${offset}px, 0)`;
        });
        ticking = false;
    };

    const onScroll = () => {
        if (ticking) return;
        ticking = true;
        requestAnimationFrame(update);
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    update();
}
