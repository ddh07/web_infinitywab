@props(['items'])
{{-- $items: liste ordonnée ['label' => string, 'url' => string|null (null pour l'élément courant)] --}}
@php
    $trail = array_merge([['label' => 'Accueil', 'url' => route('home')]], $items);
@endphp

<nav aria-label="Fil d’Ariane" class="text-sm">
    <ol class="flex flex-wrap items-center gap-1.5 text-ink-muted">
        @foreach($trail as $index => $crumb)
            <li class="flex items-center gap-1.5">
                @if($index > 0)
                    <svg class="w-3.5 h-3.5 text-ink-muted/60" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                @endif
                @if(!empty($crumb['url']) && $index < count($trail) - 1)
                    <a href="{{ $crumb['url'] }}" class="hover:text-ink-primary transition-colors">{{ $crumb['label'] }}</a>
                @else
                    <span class="text-ink-secondary font-medium" aria-current="page">{{ $crumb['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

<script type="application/ld+json" nonce="{{ $cspNonce }}">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => collect($trail)->values()->map(fn ($crumb, $i) => [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $crumb['label'],
        'item' => $crumb['url'] ?? url()->current(),
    ])->all(),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
