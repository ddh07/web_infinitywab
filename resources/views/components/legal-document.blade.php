@props(['document'])

@if($document && $document->exists && $document->isPdf())
    <div class="space-y-4">
        <div class="rounded-2xl border border-(--border-default) overflow-hidden bg-surface-sunken" style="height: 75vh;">
            <iframe src="{{ $document->fileUrl() }}" title="{{ $document->title }}" class="w-full h-full" style="border:0;"></iframe>
        </div>
        <a href="{{ $document->fileUrl() }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-semibold text-mint-500 hover:text-ink-primary">
            Ouvrir / télécharger le PDF
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </a>
    </div>
@elseif($document && $document->exists && $document->isMarkdown())
    <div class="prose-legal text-ink-secondary leading-relaxed">
        {!! $document->renderedHtml() !!}
    </div>
@else
    {{ $slot }}
@endif
