const STORAGE_KEY = 'iw_cookie_consent';

function loadGTM() {
    const containerId = window.__GTM_ID;
    if (!containerId || window.__gtmLoaded) return;
    window.__gtmLoaded = true;

    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({ 'gtm.start': new Date().getTime(), event: 'gtm.js' });

    const script = document.createElement('script');
    script.async = true;
    script.src = 'https://www.googletagmanager.com/gtm.js?id=' + containerId + '&l=dataLayer';
    document.head.appendChild(script);
}

export function initCookieConsent() {
    const banner = document.querySelector('[data-cookie-banner]');
    if (!banner) return;

    const acceptBtn = banner.querySelector('[data-cookie-accept]');
    const rejectBtn = banner.querySelector('[data-cookie-reject]');
    const manageTriggers = document.querySelectorAll('[data-cookie-manage]');

    const show = () => banner.classList.remove('hidden');
    const hide = () => banner.classList.add('hidden');

    let consent = null;
    try {
        consent = localStorage.getItem(STORAGE_KEY);
    } catch (e) {
        // Stockage indisponible (navigation privée, etc.) : on redemande à chaque visite.
    }

    if (consent === 'accepted') {
        loadGTM();
    } else if (consent !== 'rejected') {
        show();
    }

    acceptBtn?.addEventListener('click', () => {
        try { localStorage.setItem(STORAGE_KEY, 'accepted'); } catch (e) {}
        hide();
        loadGTM();
    });

    rejectBtn?.addEventListener('click', () => {
        try { localStorage.setItem(STORAGE_KEY, 'rejected'); } catch (e) {}
        hide();
    });

    manageTriggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            show();
        });
    });
}
