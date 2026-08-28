// Éditeur de contenu riche pour les champs HTML de l'admin (services, projets,
// produits, contenu). Wrapper autour de Quill qui synchronise en permanence le
// <textarea> d'origine, donc fillForm()/buildPayload() des pages existantes n'ont
// rien à changer — elles continuent de lire/écrire `textarea.value` normalement.
// L'insertion d'image passe par window.openMediaPicker() (voir media-library.js),
// aucune logique d'upload dupliquée ici.
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

// Doit rester synchronisé avec config/purifier.php ('HTML.Allowed') : un format que
// Quill peut produire mais que le Purifier serveur ne connaît pas serait supprimé
// silencieusement à l'enregistrement, donc autant ne pas l'offrir dans la barre d'outils.
const TOOLBAR = [
    [{ header: [2, 3, 4, false] }],
    ['bold', 'italic', 'underline'],
    [{ list: 'ordered' }, { list: 'bullet' }],
    ['blockquote', 'link', 'image'],
    ['clean'],
];

const EMPTY_HTML = new Set(['', '<p></p>', '<p><br></p>']);

const instances = new Map();

function insertImage(quill) {
    if (typeof window.openMediaPicker !== 'function') {
        window.showAlert?.('Sélecteur de médias indisponible.', 'error');
        return;
    }

    const range = quill.getSelection(true) ?? { index: quill.getLength(), length: 0 };

    window.openMediaPicker({
        accept: 'image',
        onSelect(items) {
            const item = items[0];
            if (!item) return;
            quill.insertEmbed(range.index, 'image', item.url, 'user');
            quill.setSelection(range.index + 1, 0, 'user');
        },
    });
}

function syncTextarea(quill, textarea) {
    const html = quill.root.innerHTML;
    textarea.value = EMPTY_HTML.has(html.trim()) ? '' : html;
    textarea.dispatchEvent(new Event('input', { bubbles: true }));
}

/**
 * Initialise (une seule fois par textarea, les appels suivants sont des no-op qui
 * renvoient l'instance existante) un éditeur Quill au-dessus du <textarea> ciblé.
 * Le textarea original est masqué mais reste dans le DOM et reste la source de
 * vérité pour le reste du formulaire.
 */
export function initRichEditor(textareaId, { placeholder = '' } = {}) {
    if (instances.has(textareaId)) {
        return instances.get(textareaId);
    }

    const textarea = document.getElementById(textareaId);
    if (!textarea) return null;

    textarea.classList.add('hidden');

    const container = document.createElement('div');
    textarea.insertAdjacentElement('afterend', container);

    const quill = new Quill(container, {
        theme: 'snow',
        placeholder,
        modules: {
            toolbar: {
                container: TOOLBAR,
                handlers: {
                    image: () => insertImage(quill),
                },
            },
        },
    });

    if (textarea.value) {
        quill.clipboard.dangerouslyPasteHTML(textarea.value);
    }

    quill.on('text-change', () => syncTextarea(quill, textarea));

    instances.set(textareaId, quill);
    return quill;
}

/**
 * Remplace le contenu affiché par l'éditeur (et le textarea associé) — à utiliser
 * partout où le code existant faisait `document.getElementById(id).value = html`
 * pour peupler un formulaire d'édition ou le réinitialiser (html = '').
 */
export function setRichEditorValue(textareaId, html) {
    const textarea = document.getElementById(textareaId);
    if (textarea) textarea.value = html ?? '';

    const quill = instances.get(textareaId);
    if (!quill) return;

    quill.setText('');
    if (html) {
        quill.clipboard.dangerouslyPasteHTML(html);
    }
}
