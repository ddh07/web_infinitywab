import './bootstrap';
import { initContactCarousel } from './pages/contact-carousel';
import { initScrollReveal } from './pages/scroll-reveal';
import { initScrollProgress } from './pages/scroll-progress';
import { initScrollParallax } from './pages/scroll-parallax';
import { initCookieConsent } from './pages/cookie-consent';
import { createCrudResource } from './admin/crud-resource';
import { confirmDialog } from './admin/confirm-dialog';
import { openModal, closeModal } from './admin/modal-utils';
import { openMediaPicker, initMediaLibraryPage, bindMediaField } from './admin/media-library';
import { initRichEditor, setRichEditorValue } from './admin/rich-editor';

window.createCrudResource = createCrudResource;
window.confirmDialog = confirmDialog;
window.openAdminModal = openModal;
window.closeAdminModal = closeModal;
window.openMediaPicker = openMediaPicker;
window.initMediaLibraryPage = initMediaLibraryPage;
window.bindMediaField = bindMediaField;
window.initRichEditor = initRichEditor;
window.setRichEditorValue = setRichEditorValue;

function initMobileMenu() {
    const button = document.querySelector('[data-mobile-menu-button]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (!button || !menu) return;

    const setOpen = (open) => {
        menu.classList.toggle('hidden', !open);
        button.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    button.addEventListener('click', () => setOpen(menu.classList.contains('hidden')));

    document.addEventListener('click', (event) => {
        if (menu.classList.contains('hidden')) return;
        if (menu.contains(event.target)) return;
        if (button.contains(event.target)) return;
        setOpen(false);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !menu.classList.contains('hidden')) {
            setOpen(false);
            button.focus();
        }
    });
}

function initNavIndicator() {
    const navLinksGroup = document.querySelector('[data-nav-links]');
    const navLinks = document.querySelectorAll('[data-nav-link]');
    const navIndicator = document.querySelector('[data-nav-indicator]');
    const activeLink = Array.from(navLinks).find((link) => link.dataset.active === 'true');

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

function initLoadingSubmitButtons() {
    document.querySelectorAll('[data-loading-submit]').forEach((form) => {
        form.addEventListener('submit', () => {
            const button = form.querySelector('[data-loading-submit-button]');
            const label = form.querySelector('[data-loading-submit-label]');
            if (!button || button.disabled) return;

            button.disabled = true;
            button.classList.add('opacity-70', 'cursor-not-allowed');
            if (label) label.textContent = 'Envoi en cours…';
        });
    });
}

function initReducedMotionVideos() {
    const prefersReduced = (window.__forceReducedMotion === true || window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    if (!prefersReduced) return;

    document.querySelectorAll('[data-autoplay-video]').forEach((video) => {
        video.pause();
        video.removeAttribute('autoplay');
    });
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
    initReducedMotionVideos();
    initLoadingSubmitButtons();
    initPasswordToggles();
    initScrollReveal();
    initScrollProgress();
    initScrollParallax();
    initCookieConsent();
});
