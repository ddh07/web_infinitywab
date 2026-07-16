@props([
    'href' => null,
    'variant' => 'primary', // primary | outline | ghost | light
    'size' => 'md', // sm | md | lg
    'as' => null, // a | button (auto si href)
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-semibold transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400';

    $sizes = [
        'sm' => 'px-4 py-2 rounded-xl text-sm',
        'md' => 'px-6 py-3 rounded-2xl text-sm',
        'lg' => 'px-8 py-4 rounded-2xl text-base',
    ];

    $variants = [
        'primary' => 'bg-gradient-to-r from-blue-500 to-purple-500 text-white shadow-xl shadow-blue-900/50 hover:shadow-blue-900/70 hover:-translate-y-0.5',
        'outline' => 'border border-white/30 text-white/80 hover:text-white hover:border-white/50 bg-white/0',
        'ghost' => 'bg-white/10 border border-white/20 text-white hover:bg-white/20',
        'light' => 'bg-white text-slate-900 shadow-lg shadow-blue-900/30 hover:-translate-y-0.5',
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

