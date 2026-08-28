import { openModal, closeModal } from './modal-utils';

// Remplace window.confirm() par une modale stylée cohérente avec le thème admin.
// Retourne une Promise<boolean> (true = confirmé). Se dégrade vers confirm() natif
// si le partiel #confirm-dialog n'est pas présent dans la page.
export function confirmDialog(message, options = {}) {
    const modal = document.getElementById('confirm-dialog');
    if (!modal) return Promise.resolve(window.confirm(message));

    const titleEl = document.getElementById('confirm-dialog-title');
    const messageEl = document.getElementById('confirm-dialog-message');
    const confirmBtn = document.getElementById('confirm-dialog-confirm');
    const cancelBtn = document.getElementById('confirm-dialog-cancel');

    titleEl.textContent = options.title ?? 'Confirmer l’action';
    messageEl.textContent = message;
    confirmBtn.textContent = options.confirmLabel ?? 'Confirmer';

    return new Promise((resolve) => {
        function cleanup(result) {
            closeModal(modal);
            confirmBtn.removeEventListener('click', onConfirm);
            cancelBtn.removeEventListener('click', onCancel);
            modal.removeEventListener('click', onOverlay);
            document.removeEventListener('keydown', onKeydown);
            resolve(result);
        }
        function onConfirm() { cleanup(true); }
        function onCancel() { cleanup(false); }
        function onOverlay(e) { if (e.target === modal) cleanup(false); }
        function onKeydown(e) { if (e.key === 'Escape') cleanup(false); }

        confirmBtn.addEventListener('click', onConfirm);
        cancelBtn.addEventListener('click', onCancel);
        modal.addEventListener('click', onOverlay);
        document.addEventListener('keydown', onKeydown);

        openModal(modal);
    });
}
