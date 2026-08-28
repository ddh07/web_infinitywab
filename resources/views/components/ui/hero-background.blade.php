@props(['page'])

@php
    $heroImage = \App\Models\Setting::get('hero_image_' . str_replace('-', '_', $page));
@endphp

@if($heroImage)
    {{-- Image de fond personnalisée (admin > Paramètres > Personnalisation), avec le
         même voile adaptatif clair/sombre que la vidéo du hero d'accueil, pour garder
         le texte lisible quel que soit le thème et le contenu de l'image. --}}
    <img src="{{ $heroImage }}" alt="" aria-hidden="true" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-br from-[var(--hero-overlay-strong)] via-[var(--hero-overlay-soft)] to-[var(--hero-overlay-strong)]"></div>
@endif
