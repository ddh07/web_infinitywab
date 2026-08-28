@extends('layouts.app')

@section('title', "Conditions d'utilisation - Infinity WAB")
@section('description', "Conditions d'utilisation du site Infinity WAB.")

@section('content')
@php
    $company = \App\Models\Company::active()->first();
    $companyName = $company->name ?? 'Infinity WAB';
    $companyEmail = $company->email ?? 'infinity-wab@infinity-wab.com';
    $companyPhone = $company->phone ?? '+226 73 24 08 46';
    $companyAddress = $company->address ?? 'Ouagadougou, Burkina Faso';
    $companyWebsite = $company->website ?? 'https://infinity-wab.com';
@endphp

<section class="pt-28 lg:pt-32 pb-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="space-y-3">
            <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-500">Mentions légales</p>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-ink-primary">Conditions d'utilisation</h1>
            @if($document && $document->exists)
            <p class="text-sm text-ink-muted">Dernière mise à jour : {{ $document->updated_at->translatedFormat('d F Y') }}</p>
            @endif
        </div>

        @if($document && $document->exists)
        <x-legal-document :document="$document">
        <div class="prose-legal space-y-8 text-ink-secondary leading-relaxed">
            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">1. Objet et acceptation</h2>
                <p>Les présentes conditions générales d'utilisation (« CGU ») régissent l'accès et l'utilisation du site {{ $companyWebsite }} (le « Site »), édité par {{ $companyName }}, ainsi que l'ensemble de ses fonctionnalités : consultation du contenu, formulaire de contact, création et gestion d'un compte utilisateur. La navigation sur le Site emporte acceptation pleine et entière des présentes CGU. Si vous n'acceptez pas ces conditions, vous devez cesser d'utiliser le Site.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">2. Mentions légales — identification de l'éditeur</h2>
                <p>Conformément aux obligations d'identification des prestataires en ligne prévues par la loi n°045/2009/AN portant réglementation des services et des transactions électroniques au Burkina Faso :</p>
                <ul class="list-disc pl-6 space-y-1.5">
                    <li><b class="text-ink-primary">Éditeur</b> : {{ $companyName }}, société à responsabilité limitée (SARL) de droit burkinabè.</li>
                    <li><b class="text-ink-primary">Siège social</b> : {{ $companyAddress }}.</li>
                    <li><b class="text-ink-primary">Registre du Commerce et du Crédit Mobilier (RCCM)</b> : <i>à compléter</i>.</li>
                    <li><b class="text-ink-primary">Identifiant Financier Unique (IFU)</b> : <i>à compléter</i>.</li>
                    <li><b class="text-ink-primary">Contact</b> : <a href="mailto:{{ $companyEmail }}" class="text-mint-500 hover:text-ink-primary font-semibold">{{ $companyEmail }}</a> — {{ $companyPhone }}.</li>
                    <li><b class="text-ink-primary">Directeur de la publication</b> : la gérance de {{ $companyName }}.</li>
                    <li><b class="text-ink-primary">Hébergeur du Site</b> : <i>raison sociale, adresse et contact de l'hébergeur à compléter</i>.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">3. Accès au site</h2>
                <p>Le Site est accessible gratuitement à tout utilisateur disposant d'un accès à internet. Tous les frais nécessaires à cet accès (matériel informatique, connexion internet, etc.) sont à la charge exclusive de l'utilisateur. {{ $companyName }} met tout en œuvre pour assurer un accès de qualité au Site, sans obligation d'y parvenir.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">4. Compte utilisateur</h2>
                <p>La création d'un compte requiert la fourniture d'informations exactes (nom, adresse email) et d'un mot de passe personnel. L'utilisateur est seul responsable de la confidentialité de ses identifiants et de toute activité réalisée depuis son compte. Il s'engage à informer {{ $companyName }} sans délai en cas d'utilisation non autorisée de son compte. {{ $companyName }} se réserve le droit de suspendre ou de supprimer tout compte utilisé en violation des présentes CGU, notamment en cas d'usurpation d'identité ou de fraude.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">5. Propriété intellectuelle</h2>
                <p>L'ensemble des éléments du Site (textes, visuels, logo, charte graphique, identité de marque, structure) est protégé au titre de la propriété intellectuelle et demeure la propriété exclusive de {{ $companyName }} ou de ses concédants, sauf mention contraire. Toute reproduction, représentation, modification ou exploitation, totale ou partielle, sans autorisation écrite préalable, est strictement interdite et susceptible de constituer une contrefaçon.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">6. Utilisation du formulaire de contact</h2>
                <p>Le formulaire de contact est exclusivement destiné à l'envoi de demandes légitimes relatives aux activités et services de {{ $companyName }}. Toute utilisation abusive, automatisée (bot), frauduleuse ou contraire à sa finalité est interdite et pourra entraîner un blocage d'accès, sans préjudice de poursuites en cas d'infraction pénale.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">7. Liens vers des sites tiers</h2>
                <p>Le Site peut contenir des liens hypertextes vers des sites tiers. {{ $companyName }} n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu, leur disponibilité ou leurs pratiques en matière de protection des données.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">8. Disponibilité et responsabilité</h2>
                <p>{{ $companyName }} met en œuvre les moyens raisonnables pour assurer la disponibilité et la sécurité du Site, sans garantie d'accès continu, ininterrompu ou exempt d'erreurs. {{ $companyName }} ne saurait être tenue responsable des interruptions liées à des opérations de maintenance, à des causes de force majeure, ou à des éléments hors de son contrôle raisonnable (panne réseau, cyberattaque, défaillance d'un prestataire tiers). L'utilisateur reconnaît utiliser le Site sous sa propre responsabilité.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">9. Protection des données personnelles</h2>
                <p>Les données personnelles traitées à l'occasion de l'utilisation du Site (formulaire de contact, création de compte) le sont dans les conditions décrites dans notre <a href="{{ route('privacy') }}" class="text-mint-500 hover:text-ink-primary font-semibold">politique de confidentialité</a>, conforme à la loi n°001‑2021/AN portant protection des données à caractère personnel au Burkina Faso.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">10. Droit applicable et juridiction compétente</h2>
                <p>Les présentes CGU sont soumises au droit burkinabè. En cas de litige relatif à leur validité, leur interprétation ou leur exécution, et à défaut de résolution amiable, compétence exclusive est attribuée aux juridictions de Ouagadougou (Burkina Faso).</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">11. Modification des conditions</h2>
                <p>{{ $companyName }} se réserve le droit de modifier les présentes CGU à tout moment, notamment pour refléter une évolution légale, technique ou fonctionnelle du Site. La version applicable est celle en vigueur à la date de consultation du Site. La date de dernière mise à jour figure en haut de cette page.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">12. Contact</h2>
                <p>Pour toute question relative à ces conditions, contactez-nous à <a href="mailto:{{ $companyEmail }}" class="text-mint-500 hover:text-ink-primary font-semibold">{{ $companyEmail }}</a>.</p>
            </section>
        </div>
        </x-legal-document>

        <div class="pt-4 border-t border-(--border-default)">
            <a href="{{ route('privacy') }}" class="text-sm font-semibold text-mint-500 hover:text-ink-primary inline-flex items-center gap-2">
                Voir la politique de confidentialité
            </a>
        </div>
        @else
        <div class="rounded-2xl border border-(--border-default) bg-surface-raised/60 p-8 text-center">
            <p class="text-ink-secondary">Cette page est en cours de préparation et sera publiée prochainement.</p>
            <a href="{{ route('contact') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-mint-500 hover:text-ink-primary">
                Une question en attendant ? Contactez-nous
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
