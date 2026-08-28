// Révèle progressivement les éléments marqués [data-reveal] quand ils entrent dans le
// viewport. N'active l'état "caché" en CSS que si ce module tourne effectivement
// (classe js-reveal-enabled), pour que le contenu reste visible sans JS ou en cas d'erreur.
export function initScrollReveal() {
    const elements = document.querySelectorAll('[data-reveal]');
    if (!elements.length) return;

    document.documentElement.classList.add('js-reveal-enabled');

    const prefersReducedMotion = (window.__forceReducedMotion === true || window.matchMedia('(prefers-reduced-motion: reduce)').matches);

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        elements.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    elements.forEach((el) => observer.observe(el));
}
