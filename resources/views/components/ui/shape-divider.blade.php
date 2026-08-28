@props([
    'shape' => 'wave',   // wave | angle | curve | zigzag | arc
    'position' => 'bottom', // bottom | top
    'fill' => 'text-surface-canvas', // classe Tailwind complète (ex: "text-surface-raised", "text-mint-700")
    'flip' => false,
])

@php
    $paths = [
        'wave' => 'M0,32 C240,80 480,0 720,24 C960,48 1200,88 1440,40 L1440,120 L0,120 Z',
        'angle' => 'M0,120 L1440,24 L1440,120 Z',
        'curve' => 'M0,0 C480,120 960,120 1440,0 L1440,120 L0,120 Z',
        'zigzag' => 'M0,60 L180,20 L360,60 L540,20 L720,60 L900,20 L1080,60 L1260,20 L1440,60 L1440,120 L0,120 Z',
        'arc' => 'M0,100 Q720,-40 1440,100 L1440,120 L0,120 Z',
    ];
    $path = $paths[$shape] ?? $paths['wave'];

    // "bottom" = la forme mord sur le bas de LA section courante (le prochain fond
    // transparaît en dessous) ; "top" = elle mord sur le haut, retournée verticalement.
    $wrapperPositionClass = $position === 'top' ? 'top-0' : 'bottom-0';
    $svgOrientationClass = $position === 'top' ? '-scale-y-100' : '';
    $svgFlipClass = $flip ? '-scale-x-100' : '';
@endphp

<div class="pointer-events-none absolute inset-x-0 {{ $wrapperPositionClass }} overflow-hidden leading-none z-10" aria-hidden="true">
    <svg class="block w-full h-14 md:h-20 {{ $fill }} {{ $svgOrientationClass }} {{ $svgFlipClass }}" viewBox="0 0 1440 120" preserveAspectRatio="none" fill="currentColor">
        <path d="{{ $path }}"></path>
    </svg>
</div>
