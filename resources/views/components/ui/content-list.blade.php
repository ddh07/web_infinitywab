@props([
    'items' => [],
    'mode' => 'list', // list | cards | timeline | feature-cards | feature-centered | feature-image
    'accent' => 'mint', // mint | azure
])

@php
    $accentDot = $accent === 'azure' ? 'bg-azure-400' : 'bg-mint-400';
    $accentRing = $accent === 'azure' ? 'text-slate-950 bg-azure-400' : 'text-slate-950 bg-mint-400';
    $accentBadge = $accent === 'azure' ? 'from-azure-500 to-mint-500' : 'from-mint-500 to-azure-500';

    // Chaque élément peut être une simple chaîne (ancien format) ou un tableau
    // {title, body, icon, image} — voir la migration convert_company_vision_mission_items_to_objects.
    $normalized = collect($items)->map(function ($item) {
        return is_array($item)
            ? array_merge(['title' => '', 'body' => '', 'icon' => null, 'image' => null], $item)
            : ['title' => $item, 'body' => '', 'icon' => null, 'image' => null];
    });
@endphp

@if($normalized->isEmpty())
    {{-- Rien à afficher : évite une section vide si l'admin n'a encore rien renseigné. --}}
@elseif($mode === 'cards')
    <div class="grid grid-cols-1 {{ $normalized->count() > 1 ? 'sm:grid-cols-2' : '' }} gap-4">
        @foreach($normalized as $index => $item)
            <article class="rounded-2xl border border-(--border-default) bg-surface-raised/60 p-5 shadow-xl shadow-(--glow-accent)" data-reveal style="--reveal-delay: {{ $index * 80 }}ms">
                @if($item['title'])<h4 class="font-display text-base font-semibold text-ink-primary mb-2">{{ $item['title'] }}</h4>@endif
                @if($item['body'])<p class="text-sm text-ink-secondary leading-relaxed">{{ $item['body'] }}</p>@endif
            </article>
        @endforeach
    </div>
@elseif($mode === 'timeline')
    <ol class="relative border-l-2 border-(--border-default) pl-7 space-y-7">
        @foreach($normalized as $index => $item)
            <li class="relative" data-reveal style="--reveal-delay: {{ $index * 80 }}ms">
                <span class="absolute -left-[2.35rem] top-0 flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold {{ $accentRing }}">{{ $index + 1 }}</span>
                @if($item['title'])<h4 class="font-display text-base font-semibold text-ink-primary mb-1">{{ $item['title'] }}</h4>@endif
                @if($item['body'])<p class="text-sm text-ink-secondary leading-relaxed">{{ $item['body'] }}</p>@endif
            </li>
        @endforeach
    </ol>
@elseif($mode === 'feature-cards')
    <div class="grid grid-cols-1 {{ $normalized->count() > 1 ? 'sm:grid-cols-2' : '' }} gap-4">
        @foreach($normalized as $index => $item)
            <article class="rounded-2xl border border-(--border-default) bg-surface-raised/60 p-5 shadow-xl shadow-(--glow-accent)" data-reveal style="--reveal-delay: {{ $index * 80 }}ms">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br {{ $accentBadge }} flex items-center justify-center mb-4">
                    @include('partials.icons.feature-icon', ['icon' => $item['icon'] ?: 'check', 'class' => 'w-5 h-5 text-slate-950'])
                </div>
                @if($item['title'])<h4 class="font-display text-base font-semibold text-ink-primary mb-2">{{ $item['title'] }}</h4>@endif
                @if($item['body'])<p class="text-sm text-ink-secondary leading-relaxed">{{ $item['body'] }}</p>@endif
            </article>
        @endforeach
    </div>
@elseif($mode === 'feature-centered')
    <div class="grid grid-cols-1 {{ $normalized->count() > 1 ? 'sm:grid-cols-2' : '' }} gap-6 text-center">
        @foreach($normalized as $index => $item)
            <div data-reveal style="--reveal-delay: {{ $index * 80 }}ms">
                <div class="w-14 h-14 mx-auto rounded-full bg-gradient-to-br {{ $accentBadge }} flex items-center justify-center mb-4">
                    @include('partials.icons.feature-icon', ['icon' => $item['icon'] ?: 'check', 'class' => 'w-6 h-6 text-slate-950'])
                </div>
                @if($item['title'])<h4 class="font-display text-base font-semibold text-ink-primary mb-2">{{ $item['title'] }}</h4>@endif
                @if($item['body'])<p class="text-sm text-ink-secondary leading-relaxed">{{ $item['body'] }}</p>@endif
            </div>
        @endforeach
    </div>
@elseif($mode === 'feature-image')
    <div class="space-y-6">
        @foreach($normalized as $index => $item)
            <article class="flex flex-col sm:flex-row items-center gap-5 rounded-2xl border border-(--border-default) bg-surface-raised/60 p-5 shadow-xl shadow-(--glow-accent)" data-reveal style="--reveal-delay: {{ $index * 80 }}ms">
                <div class="w-full sm:w-32 h-32 sm:h-24 shrink-0 rounded-xl overflow-hidden bg-gradient-to-br {{ $accentBadge }} flex items-center justify-center">
                    @if($item['image'])
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                    @else
                        @include('partials.icons.feature-icon', ['icon' => $item['icon'] ?: 'check', 'class' => 'w-8 h-8 text-slate-950'])
                    @endif
                </div>
                <div class="flex-1 text-center sm:text-left">
                    @if($item['title'])<h4 class="font-display text-base font-semibold text-ink-primary mb-1">{{ $item['title'] }}</h4>@endif
                    @if($item['body'])<p class="text-sm text-ink-secondary leading-relaxed">{{ $item['body'] }}</p>@endif
                </div>
            </article>
        @endforeach
    </div>
@else
    <ul class="space-y-4">
        @foreach($normalized as $index => $item)
            <li class="flex items-start gap-3" data-reveal style="--reveal-delay: {{ $index * 60 }}ms">
                <span class="mt-2 h-1.5 w-1.5 rounded-full {{ $accentDot }} shrink-0"></span>
                <span class="text-ink-secondary leading-relaxed">
                    @if($item['title'])<strong class="text-ink-primary">{{ $item['title'] }}</strong>@endif
                    @if($item['title'] && $item['body']) — @endif
                    {{ $item['body'] }}
                </span>
            </li>
        @endforeach
    </ul>
@endif
