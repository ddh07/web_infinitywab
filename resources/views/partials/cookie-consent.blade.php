@if(config('services.gtm.container_id'))
<div data-cookie-banner class="hidden fixed inset-x-0 bottom-0 z-50 p-4 sm:p-6" role="dialog" aria-live="polite" aria-label="Préférences de cookies">
    <div class="max-w-3xl mx-auto rounded-2xl border border-(--border-default) bg-surface-raised/95 backdrop-blur-xl shadow-2xl p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
            <p class="text-sm text-ink-secondary leading-relaxed">
                Ce site utilise un cookie de session technique, toujours actif, ainsi que des cookies de mesure d'audience (Google Analytics) qui ne sont déposés qu'avec votre accord. Consultez notre
                <a href="{{ route('privacy') }}" class="text-mint-500 hover:text-ink-primary font-semibold underline underline-offset-2">politique de confidentialité</a>.
            </p>
            <div class="flex items-center gap-3 shrink-0">
                <button type="button" data-cookie-reject class="text-sm font-semibold text-ink-secondary hover:text-ink-primary px-4 py-2 rounded-xl border border-(--border-default)">
                    Refuser
                </button>
                <button type="button" data-cookie-accept class="text-sm font-semibold text-slate-950 bg-linear-to-r from-mint-500 to-azure-500 px-4 py-2 rounded-xl">
                    Accepter
                </button>
            </div>
        </div>
    </div>
</div>
@endif
