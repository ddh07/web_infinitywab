// Utilitaires communs à toutes les modales admin : ouverture/fermeture avec
// verrouillage du scroll body, restauration du focus au point de départ, et piège
// à focus (Tab / Shift+Tab ne sortent pas de la modale tant qu'elle est ouverte).
const FOCUSABLE_SELECTOR = 'a[href], button:not([disabled]), textarea, input, select, [tabindex]:not([tabindex="-1"])';

const trappedModals = new WeakSet();
let lastFocusedElement = null;

function lockBodyScroll(lock) {
    document.body.style.overflow = lock ? 'hidden' : '';
}

function trapFocus(modal, event) {
    if (event.key !== 'Tab') return;
    const focusable = Array.from(modal.querySelectorAll(FOCUSABLE_SELECTOR)).filter((el) => el.offsetParent !== null);
    if (!focusable.length) return;
    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
    }
}

export function openModal(modal) {
    if (!modal) return;
    lastFocusedElement = document.activeElement;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    lockBodyScroll(true);

    const focusable = modal.querySelector(FOCUSABLE_SELECTOR);
    focusable?.focus();

    if (!trappedModals.has(modal)) {
        modal.addEventListener('keydown', (e) => trapFocus(modal, e));
        trappedModals.add(modal);
    }
}

export function closeModal(modal) {
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    lockBodyScroll(false);
    lastFocusedElement?.focus();
    lastFocusedElement = null;
}
