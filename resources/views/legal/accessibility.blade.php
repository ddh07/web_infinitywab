@extends('layouts.app')

@section('title', 'Déclaration d’accessibilité - Infinity WAB')
@section('description', 'Engagement d’Infinity WAB en matière d’accessibilité numérique.')

@section('content')
@php
    $company = \App\Models\Company::active()->first();
    $companyName = $company->name ?? 'Infinity WAB';
    $companyEmail = $company->email ?? 'infinity-wab@infinity-wab.com';
@endphp
<section class="pt-28 lg:pt-32 pb-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="space-y-3">
            <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-500">Accessibilité</p>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-ink-primary">Déclaration d'accessibilité</h1>
            <p class="text-sm text-ink-muted">Dernière mise à jour : {{ now()->translatedFormat('d F Y') }}</p>
        </div>

        <x-legal-document :document="$document ?? null">
        <div class="prose-legal space-y-8 text-ink-secondary leading-relaxed">
            @if(filled($content))
                <p>{!! nl2br(e($content)) !!}</p>
            @else
                <section class="space-y-3">
                    <h2 class="font-display text-xl font-semibold text-ink-primary">1. Engagement</h2>
                    <p>{{ $companyName }} s'engage à rendre ce site accessible au plus grand nombre, y compris aux personnes en situation de handicap. Cette démarche s'inscrit dans une logique d'amélioration continue, en l'absence de référentiel d'accessibilité numérique obligatoire spécifique au Burkina Faso à ce jour, et en s'appuyant sur les Règles pour l'accessibilité des contenus web (WCAG 2.1, niveau AA) du W3C comme référentiel international de bonnes pratiques.</p>
                </section>

                <section class="space-y-3">
                    <h2 class="font-display text-xl font-semibold text-ink-primary">2. État de conformité</h2>
                    <p>Ce site est en <b class="text-ink-primary">conformité partielle</b> avec les WCAG 2.1 niveau AA. Un audit d'accessibilité complet n'a pas encore été réalisé par un tiers indépendant ; l'état de conformité ci-dessus résulte d'une auto-évaluation continue de notre équipe.</p>
                </section>

                <section class="space-y-3">
                    <h2 class="font-display text-xl font-semibold text-ink-primary">3. Mesures mises en œuvre</h2>
                    <ul class="list-disc pl-6 space-y-1.5">
                        <li>Structure sémantique des pages (titres hiérarchisés, repères de navigation).</li>
                        <li>Attributs alternatifs sur les images porteuses d'information.</li>
                        <li>Navigation utilisable au clavier sur les principales fonctionnalités du site.</li>
                        <li>Contrastes de couleurs travaillés entre le texte et l'arrière-plan, y compris en mode sombre.</li>
                        <li>Mise en page responsive, adaptée aux différentes tailles d'écran et niveaux de zoom.</li>
                        <li>Possibilité de réduire les animations et effets de mouvement de l'interface, lorsque cette option est activée par notre équipe.</li>
                    </ul>
                </section>

                <section class="space-y-3">
                    <h2 class="font-display text-xl font-semibold text-ink-primary">4. Contenus et limitations connues</h2>
                    <p>Malgré nos efforts, certains contenus peuvent ne pas être pleinement accessibles : documents déposés par des tiers (PDF non balisés), contenus intégrés depuis des services externes (cartes, réseaux sociaux), ou éléments d'interface récemment ajoutés et non encore audités. Nous travaillons à résorber progressivement ces limitations.</p>
                </section>

                <section class="space-y-3">
                    <h2 class="font-display text-xl font-semibold text-ink-primary">5. Retour d'information et contact</h2>
                    <p>Si vous rencontrez une difficulté d'accès à un contenu ou une fonctionnalité de ce site, ou si vous souhaitez nous signaler un défaut d'accessibilité, contactez-nous à <a href="mailto:{{ $companyEmail }}" class="text-mint-500 hover:text-ink-primary font-semibold">{{ $companyEmail }}</a> ou via notre <a href="{{ route('contact') }}" class="text-mint-500 hover:text-ink-primary font-semibold">formulaire de contact</a>, en décrivant le contenu concerné et, si possible, la technologie d'assistance utilisée. Nous nous engageons à examiner votre signalement et à vous répondre dans un délai raisonnable.</p>
                </section>

                <section class="space-y-3">
                    <h2 class="font-display text-xl font-semibold text-ink-primary">6. Voies de recours</h2>
                    <p>Si vous constatez un défaut d'accessibilité vous empêchant d'accéder à un contenu ou à une fonctionnalité du site et que vous nous en faites part sans obtenir de réponse satisfaisante dans un délai raisonnable, vous pouvez porter votre réclamation auprès de la Commission de l'Informatique et des Libertés (CIL) du Burkina Faso.</p>
                </section>
            @endif
        </div>
        </x-legal-document>

        <div class="pt-4 border-t border-(--border-default)">
            <a href="{{ route('contact') }}" class="text-sm font-semibold text-mint-500 hover:text-ink-primary inline-flex items-center gap-2">
                Signaler un problème d'accessibilité
            </a>
        </div>
    </div>
</section>
@endsection
