import './bootstrap';
import { initContactCarousel } from './pages/contact-carousel';

function initMobileMenu() {
    const button = document.querySelector('[data-mobile-menu-button]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (button && menu) {
        button.addEventListener('click', () => menu.classList.toggle('hidden'));

        document.addEventListener('click', (event) => {
            if (menu.classList.contains('hidden')) return;
            if (menu.contains(event.target)) return;
            if (button.contains(event.target)) return;
            menu.classList.add('hidden');
        });
    }

    // Legacy fallback (si présent)
    const legacyButton = document.querySelector('[data-legacy-mobile-menu-button]');
    const legacyMenu = document.getElementById('mobileMenu');
    if (legacyButton && legacyMenu) {
        legacyButton.addEventListener('click', () => legacyMenu.classList.toggle('hidden'));
    }
}

function initNavIndicator() {
    const navLinksGroup = document.querySelector('[data-nav-links]');
    const navLinks = document.querySelectorAll('[data-nav-link]');
    const navIndicator = document.querySelector('[data-nav-indicator]');
    const activeLink = Array.from(navLinks).find((link) => link.dataset.active === 'true') || navLinks[0];

    const repositionIndicator = (link) => {
        if (!link || !navIndicator || !navLinksGroup) return;
        const linkRect = link.getBoundingClientRect();
        const groupRect = navLinksGroup.getBoundingClientRect();
        navIndicator.style.width = `${linkRect.width}px`;
        navIndicator.style.transform = `translateX(${linkRect.left - groupRect.left}px)`;
        navIndicator.style.opacity = '1';
    };

    if (navIndicator && navLinks.length) {
        repositionIndicator(activeLink);
        navLinks.forEach((link) => {
            link.addEventListener('mouseenter', () => repositionIndicator(link));
            link.addEventListener('focus', () => repositionIndicator(link));
        });
        navLinksGroup?.addEventListener('mouseleave', () => repositionIndicator(activeLink));
        window.addEventListener('resize', () => repositionIndicator(activeLink));
    }
}

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (!href || href === '#') return;

            const target = document.querySelector(href);
            if (!target) return;

            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth' });
        });
    });
}

function initNavShadow() {
    const nav = document.querySelector('nav');
    if (!nav) return;

    const onScroll = () => {
        const currentScroll = window.pageYOffset;
        if (currentScroll > 100) nav.classList.add('shadow-lg');
        else nav.classList.remove('shadow-lg');
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

function initPasswordToggles() {
    document.querySelectorAll('[data-password-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const selector = btn.getAttribute('data-password-toggle');
            if (!selector) return;
            const input = document.querySelector(selector);
            if (!(input instanceof HTMLInputElement)) return;

            const nextType = input.type === 'password' ? 'text' : 'password';
            input.type = nextType;

            btn.setAttribute('aria-pressed', nextType === 'text' ? 'true' : 'false');
            const label = nextType === 'text' ? 'Masquer' : 'Afficher';
            const textNode = btn.querySelector('[data-password-toggle-label]');
            if (textNode) textNode.textContent = label;
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initNavIndicator();
    initSmoothScroll();
    initNavShadow();
    initContactCarousel();
    initPasswordToggles();
});
