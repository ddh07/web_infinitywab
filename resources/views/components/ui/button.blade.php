@props([
    'href' => null,
    'variant' => 'primary', // primary | outline | ghost | light
    'size' => 'md', // sm | md | lg
    'as' => null, // a | button (auto si href)
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-semibold transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-mint-400';

    $sizes = [
        'sm' => 'px-4 py-2 rounded-xl text-sm',
        'md' => 'px-6 py-3 rounded-2xl text-sm',
        'lg' => 'px-8 py-4 rounded-2xl text-base',
    ];

    $variants = [
        'primary' => 'bg-gradient-to-r from-mint-500 to-azure-500 text-slate-950 shadow-xl shadow-mint-600/30 hover:shadow-azure-600/40 hover:-translate-y-0.5',
        'outline' => 'border border-(--border-default) text-ink-secondary hover:text-ink-primary hover:border-(--border-strong) bg-transparent',
        'ghost' => 'bg-black/5 dark:bg-white/10 border border-(--border-default) text-ink-primary hover:bg-black/10 dark:hover:bg-white/20',
        'light' => 'bg-white text-slate-900 shadow-lg shadow-mint-600/20 hover:-translate-y-0.5',
    ];

    $classes = trim($base.' '.($sizes[$size] ?? $sizes['md']).' '.($variants[$variant] ?? $variants['primary']).' '.$attributes->get('class'));
    $tag = $as ?: ($href ? 'a' : 'button');
@endphp

@if($tag === 'a')
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif

