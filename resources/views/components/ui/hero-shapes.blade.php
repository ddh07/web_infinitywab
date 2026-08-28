@props([
    'variant' => 'orbit', // orbit | drift | beam | constellation | rings
])

{{-- Formes décoratives flottantes pour différencier visuellement les héros d'une page
     à l'autre. Toutes les classes utilisées (blur-3xl, animate-float*, .particle) existent
     déjà dans le design system, aucun CSS supplémentaire n'est nécessaire. --}}

@if($variant === 'orbit')
    <div class="absolute -top-10 -right-10 w-72 h-72 rounded-full bg-mint-500/20 blur-3xl animate-float pointer-events-none" aria-hidden="true"></div>
    <div class="absolute bottom-10 left-10 w-28 h-28 rounded-full border-2 border-dashed border-azure-400/30 animate-float-slow pointer-events-none" aria-hidden="true"></div>
@elseif($variant === 'drift')
    <div class="absolute -bottom-16 -left-16 w-80 h-80 rounded-full bg-azure-500/20 blur-3xl animate-float-delayed pointer-events-none" aria-hidden="true"></div>
    <div class="absolute top-16 right-16 w-20 h-20 border-2 border-mint-400/30 rotate-45 animate-float pointer-events-none" aria-hidden="true"></div>
@elseif($variant === 'beam')
    <div class="absolute top-0 right-0 w-[36rem] h-40 bg-gradient-to-l from-mint-500/20 via-azure-500/10 to-transparent blur-3xl rotate-12 pointer-events-none" aria-hidden="true"></div>
    <div class="absolute bottom-8 left-8 w-16 h-16 rounded-full border-2 border-dashed border-mint-400/30 animate-float-slow pointer-events-none" aria-hidden="true"></div>
@elseif($variant === 'constellation')
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="particle particle-1"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-5"></div>
    </div>
    <div class="absolute top-1/4 right-12 w-24 h-24 rounded-full bg-mint-500/15 blur-2xl animate-float pointer-events-none" aria-hidden="true"></div>
@elseif($variant === 'rings')
    <div class="absolute top-1/3 right-1/4 w-40 h-40 rounded-full border border-azure-400/20 pointer-events-none" aria-hidden="true"></div>
    <div class="absolute top-1/3 right-1/4 w-64 h-64 -translate-x-8 -translate-y-8 rounded-full border border-mint-400/15 animate-float-slow pointer-events-none" aria-hidden="true"></div>
    <div class="absolute bottom-10 left-1/4 w-16 h-16 rounded-full bg-azure-500/20 blur-2xl animate-float-delayed pointer-events-none" aria-hidden="true"></div>
@endif
