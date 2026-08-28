@extends('layouts.app')

@section('title', 'Politique de confidentialité - Infinity WAB')
@section('description', 'Comment Infinity WAB collecte, utilise et protège les données personnelles des visiteurs et clients.')

@section('content')
@php
    $company = \App\Models\Company::active()->first();
    $companyName = $company->name ?? 'Infinity WAB';
    $companyEmail = $company->email ?? 'infinity-wab@infinity-wab.com';
    $companyPhone = $company->phone ?? '+226 73 24 08 46';
    $companyAddress = $company->address ?? 'Ouagadougou, Burkina Faso';
    $analyticsEnabled = filled(config('services.gtm.container_id'));
@endphp

<section class="pt-28 lg:pt-32 pb-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="space-y-3">
            <p class="font-mono text-xs uppercase tracking-[0.4em] text-mint-500">Confidentialité</p>
            <h1 class="font-display text-3xl md:text-4xl font-semibold text-ink-primary">Politique de confidentialité</h1>
            @if($document && $document->exists)
            <p class="text-sm text-ink-muted">Dernière mise à jour : {{ $document->updated_at->translatedFormat('d F Y') }}</p>
            @endif
        </div>

        @if($document && $document->exists)
        <x-legal-document :document="$document">
        <div class="prose-legal space-y-8 text-ink-secondary leading-relaxed">
            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">1. Préambule et responsable du traitement</h2>
                <p>{{ $companyName }} (SARL), dont le siège est situé à {{ $companyAddress }}, est l'éditeur de ce site et le responsable du traitement des données à caractère personnel qui y sont collectées, au sens de l'article 5 de la loi burkinabè n°001‑2021/AN du 30 mars 2021 portant protection des personnes à l'égard du traitement des données à caractère personnel.</p>
                <p>Cette politique décrit, dans le respect des principes de licéité, de finalité, de minimisation, d'exactitude, de conservation limitée et de sécurité posés par les articles 6 à 11 de la loi n°001‑2021/AN, quelles données nous traitons, pourquoi, pendant combien de temps, et comment vous pouvez exercer vos droits. Elle s'inspire également, à titre de bonnes pratiques internationales, du Règlement général sur la protection des données (RGPD — UE 2016/679), qui ne s'applique pas directement au Burkina Faso mais dont les principes convergent largement avec la loi nationale.</p>
                <p>Pour toute question relative à vos données personnelles : <a href="mailto:{{ $companyEmail }}" class="text-mint-500 hover:text-ink-primary font-semibold">{{ $companyEmail }}</a> — {{ $companyPhone }}.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">2. Données que nous collectons</h2>
                <p>Nous appliquons le principe de minimisation : seules les données nécessaires à chaque finalité sont collectées, exclusivement lorsque vous nous les transmettez volontairement ou du fait de votre navigation.</p>
                <ul class="list-disc pl-6 space-y-1.5">
                    <li><b class="text-ink-primary">Formulaire de contact</b> : nom, adresse email, téléphone (facultatif), sujet et message.</li>
                    <li><b class="text-ink-primary">Création et gestion de compte</b> : nom, adresse email et mot de passe (enregistré sous forme hachée, jamais en clair), lors de votre inscription et lors de la vérification de votre adresse email.</li>
                    <li><b class="text-ink-primary">Connexion et session</b> : cookie de session technique nécessaire au maintien de votre connexion, pour les comptes utilisateurs et administrateurs.</li>
                    <li><b class="text-ink-primary">Données techniques anti-abus</b> : adresse IP et user-agent, enregistrés uniquement lors de l'envoi du formulaire de contact, à des fins de lutte contre le spam et les soumissions automatisées.</li>
                    <li><b class="text-ink-primary">Journaux techniques (logs)</b> : données de connexion au serveur (adresse IP, horodatage, pages consultées), conservées à des fins de sécurité et de détection d'incidents.</li>
                    @if($analyticsEnabled)
                    <li><b class="text-ink-primary">Mesure d'audience</b> : lorsque l'outil Google Tag Manager / Google Analytics (GA4) est activé, des identifiants de navigation et des données de fréquentation sont collectés via des cookies déposés par Google (voir section 5).</li>
                    @endif
                </ul>
                <p>Nous ne collectons aucune donnée dite « sensible » au sens de l'article 5 de la loi n°001‑2021/AN (origine raciale ou ethnique, opinions politiques, religieuses ou philosophiques, appartenance syndicale, santé, vie sexuelle, données biométriques ou génétiques, infractions pénales).</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">3. Finalités et bases légales</h2>
                <ul class="list-disc pl-6 space-y-1.5">
                    <li><b class="text-ink-primary">Répondre à vos demandes</b> (formulaire de contact) — base légale : votre consentement, exprimé par l'envoi volontaire du formulaire.</li>
                    <li><b class="text-ink-primary">Créer et gérer votre compte</b>, vous authentifier, vérifier votre adresse email — base légale : exécution du contrat (conditions d'utilisation) formé lors de votre inscription.</li>
                    <li><b class="text-ink-primary">Protéger le site contre les abus</b> (spam, tentatives d'intrusion, usage frauduleux) — base légale : intérêt légitime du responsable de traitement à assurer la sécurité de ses services.</li>
                    <li><b class="text-ink-primary">Administrer le contenu du site</b> (services, projets, produits, messages) par notre équipe autorisée — base légale : intérêt légitime et exécution du contrat de travail/mandat des personnes habilitées.</li>
                    @if($analyticsEnabled)
                    <li><b class="text-ink-primary">Mesurer l'audience du site</b> (pages vues, durée de session, taux de rebond) — base légale : votre consentement préalable au dépôt de cookies de mesure d'audience non strictement nécessaires.</li>
                    @endif
                </ul>
                <p>Nous ne vendons ni ne louons vos données à des tiers, et nous ne les utilisons jamais à des fins incompatibles avec les finalités décrites ci-dessus (interdiction du détournement de finalité, art. 6 de la loi n°001‑2021/AN).</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">4. Destinataires de vos données et sous-traitants</h2>
                <p>Vos données sont accessibles uniquement aux membres habilités de l'équipe {{ $companyName }}, dans la limite de leurs fonctions (principe du moindre privilège). Elles peuvent également être transmises aux prestataires techniques suivants, agissant en tant que sous-traitants au sens de l'article 11 de la loi n°001‑2021/AN, liés par des engagements de confidentialité et de sécurité :</p>
                <ul class="list-disc pl-6 space-y-1.5">
                    <li><b class="text-ink-primary">Prestataires d'envoi d'emails</b> (Postmark, Resend ou Amazon SES, selon la configuration active) — pour l'envoi des emails transactionnels (vérification de compte, notifications).</li>
                    <li><b class="text-ink-primary">Hébergeur du site</b> — pour l'hébergement technique de l'infrastructure et des données.</li>
                    @if($analyticsEnabled)
                    <li><b class="text-ink-primary">Google LLC</b> (Google Tag Manager, Google Analytics/GA4) — uniquement si la mesure d'audience est activée par notre équipe (voir section 5).</li>
                    @endif
                </ul>
                <p>Aucune autre communication de vos données à des tiers n'est effectuée, hors obligation légale ou réquisition d'une autorité compétente (notamment judiciaire).</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">5. Cookies et traceurs</h2>
                <p>Ce site dépose systématiquement un <b class="text-ink-primary">cookie de session technique</b>, strictement nécessaire au fonctionnement du site (maintien de la connexion, protection contre la falsification de requêtes CSRF). Ce cookie ne nécessite pas de consentement, conformément à l'exception prévue pour les cookies strictement nécessaires au service demandé.</p>
                @if($analyticsEnabled)
                <p>Notre équipe a activé un outil de <b class="text-ink-primary">mesure d'audience</b> (Google Tag Manager / Google Analytics GA4), qui dépose des cookies non essentiels afin d'établir des statistiques de fréquentation anonymisées. Ces cookies ne sont déposés qu'après recueil de votre consentement, que vous pouvez retirer à tout moment sans que cela n'affecte votre navigation sur le site. Le détail des cookies déposés par Google (nom, finalité, durée) est disponible dans la politique de confidentialité de Google.</p>
                @else
                <p>À la date de mise à jour de cette politique, aucun outil de mesure d'audience ou de publicité tierce n'est activé sur ce site. Si notre équipe active un tel outil, cette politique sera mise à jour et un recueil de votre consentement sera mis en place avant tout dépôt de cookie non essentiel.</p>
                @endif
                <p>Vous pouvez à tout moment configurer votre navigateur pour refuser les cookies ou être averti avant leur dépôt ; cela peut toutefois limiter certaines fonctionnalités du site (notamment le maintien de la connexion).</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">6. Transferts de données hors du Burkina Faso</h2>
                @if($analyticsEnabled)
                <p>Lorsque la mesure d'audience Google est activée, certaines données techniques (identifiants de navigation, adresse IP) sont transmises aux serveurs de Google LLC, susceptibles d'être situés hors du Burkina Faso, y compris aux États-Unis. Ce transfert repose sur les clauses contractuelles types et les garanties de Google, conformément aux exigences des articles 40 à 44 de la loi n°001‑2021/AN, qui imposent un niveau de protection adéquat ou des garanties contractuelles équivalentes en l'absence d'autorisation spécifique de la CIL.</p>
                @else
                <p>À ce jour, aucune donnée personnelle collectée sur ce site n'est transférée en dehors du Burkina Faso. Si un tel transfert devenait nécessaire (par exemple par l'activation d'un service tiers hébergé à l'étranger), il ne serait mis en œuvre qu'après autorisation de la CIL et mise en place de garanties conformes aux articles 40 à 44 de la loi n°001‑2021/AN.</p>
                @endif
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">7. Durée de conservation</h2>
                <ul class="list-disc pl-6 space-y-1.5">
                    <li><b class="text-ink-primary">Messages du formulaire de contact</b> : conservés pendant la durée nécessaire au traitement de votre demande, puis archivés au maximum 3 ans à compter du dernier contact, à des fins de preuve et de suivi commercial, sauf demande de suppression anticipée de votre part.</li>
                    <li><b class="text-ink-primary">Comptes utilisateurs</b> : conservés pendant toute la durée de vie du compte, puis supprimés ou anonymisés dans un délai raisonnable après sa clôture, sauf obligation légale de conservation plus longue.</li>
                    <li><b class="text-ink-primary">Données techniques anti-abus et journaux de connexion</b> : conservés pour une durée limitée strictement nécessaire à la détection et à la prévention des abus, généralement 12 mois maximum.</li>
                    @if($analyticsEnabled)
                    <li><b class="text-ink-primary">Cookies de mesure d'audience</b> : conservés selon les durées définies par Google (généralement jusqu'à 14 mois), et rappel de consentement à intervalle régulier.</li>
                    @endif
                </ul>
                <p>À l'expiration de ces durées, vos données sont supprimées ou anonymisées de façon irréversible.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">8. Sécurité des données</h2>
                <p>Conformément à l'article 10 de la loi n°001‑2021/AN, nous mettons en œuvre des mesures techniques et organisationnelles proportionnées pour protéger vos données contre l'accès non autorisé, la perte, l'altération ou la divulgation :</p>
                <ul class="list-disc pl-6 space-y-1.5">
                    <li>Chiffrement des échanges en transit (HTTPS / TLS) et en-têtes de sécurité renforcés (HSTS, CSP, protection anti-clickjacking).</li>
                    <li>Mots de passe stockés uniquement sous forme hachée (jamais en clair).</li>
                    <li>Accès à l'espace d'administration restreint aux comptes autorisés et protégé par authentification.</li>
                    <li>Principe du moindre privilège : seules les personnes habilitées accèdent aux données nécessaires à leurs fonctions.</li>
                    <li>Sauvegardes régulières et procédure de gestion des incidents de sécurité.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">9. Vos droits</h2>
                <p>Conformément aux articles 16 à 22 de la loi n°001‑2021/AN, vous disposez des droits suivants sur vos données personnelles :</p>
                <ul class="list-disc pl-6 space-y-1.5">
                    <li><b class="text-ink-primary">Droit d'information</b> : être informé, dès la collecte, de l'usage de vos données (objet de la présente politique).</li>
                    <li><b class="text-ink-primary">Droit d'accès</b> : obtenir la confirmation que vos données sont traitées et en recevoir une copie, sous 30 jours.</li>
                    <li><b class="text-ink-primary">Droit de rectification</b> : corriger des données inexactes ou incomplètes.</li>
                    <li><b class="text-ink-primary">Droit d'opposition</b> : vous opposer, pour un motif légitime, à un traitement de vos données.</li>
                    <li><b class="text-ink-primary">Droit à l'effacement</b> (droit à l'oubli) : demander la suppression de vos données lorsque leur conservation n'est plus nécessaire.</li>
                    <li><b class="text-ink-primary">Droit de refuser le profilage</b> : ce site ne procède à aucune décision automatisée produisant des effets juridiques à votre égard.</li>
                </ul>
                <p>Pour exercer ces droits, contactez-nous à <a href="mailto:{{ $companyEmail }}" class="text-mint-500 hover:text-ink-primary font-semibold">{{ $companyEmail }}</a> en précisant votre identité. Nous répondons dans un délai maximal de 30 jours.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">10. Réclamation auprès de la CIL</h2>
                <p>Si vous estimez que le traitement de vos données personnelles ne respecte pas la réglementation en vigueur, vous pouvez introduire une réclamation auprès de la Commission de l'Informatique et des Libertés (CIL) du Burkina Faso, autorité de contrôle indépendante instituée par les articles 45 à 61 de la loi n°001‑2021/AN, sans préjudice de tout autre recours administratif ou juridictionnel.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">11. Mineurs</h2>
                <p>Ce site ne s'adresse pas spécifiquement aux mineurs et ne collecte pas sciemment de données les concernant. Si vous êtes le représentant légal d'un mineur ayant transmis des données via ce site, contactez-nous afin d'en obtenir la suppression.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">12. Déclaration auprès de la CIL</h2>
                <p>Conformément aux articles 26 à 32 de la loi n°001‑2021/AN, les traitements de données mis en œuvre sur ce site font l'objet d'une déclaration auprès de la Commission de l'Informatique et des Libertés (CIL) du Burkina Faso. Numéro de récépissé : <i>en cours d'attribution — sera indiqué dès réception</i>.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-display text-xl font-semibold text-ink-primary">13. Modification de la politique</h2>
                <p>Cette politique peut être mise à jour à tout moment, notamment pour refléter une évolution légale ou technique. La date de dernière mise à jour figure en haut de cette page. Nous vous invitons à la consulter régulièrement.</p>
            </section>
        </div>
        </x-legal-document>

        <div class="pt-4 border-t border-(--border-default)">
            <a href="{{ route('contact') }}" class="text-sm font-semibold text-mint-500 hover:text-ink-primary inline-flex items-center gap-2">
                Une question sur vos données ? Contactez-nous
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
