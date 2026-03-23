@extends('layouts.app')

@section('title', 'CGU')

@section('content')
<section class="legal-page container">
    <div class="page-title-block">
        <p class="page-kicker">Informations</p>
        <h1 class="legal-main-title">Conditions générales d'utilisation</h1>
        <p class="page-intro">Le contenu éditorial reste inchangé, mais l'habillage se cale maintenant sur la référence graphique de la home.</p>
    </div>

    <div class="legal-card">

        <div class="legal-content">
            <section class="legal-block">
                <h2>Objet</h2>
                <p>
                    Les présentes conditions générales d'utilisation ont pour objet de définir les modalités d'accès
                    et d'usage de la plateforme RESources Relationnelles.
                </p>
            </section>

            <section class="legal-block">
                <h2>Accès au service</h2>
                <p>
                    La plateforme est accessible aux utilisateurs disposant d'un accès internet compatible.
                </p>
                <p>
                    Certaines fonctionnalités peuvent nécessiter la création d'un compte ou une authentification.
                </p>
            </section>

            <section class="legal-block">
                <h2>Engagement de l'utilisateur</h2>
                <p>
                    L'utilisateur s'engage à utiliser la plateforme de manière loyale, respectueuse et conforme à sa finalité.
                </p>
                <p>
                    Sont notamment interdits :
                </p>
                <ul class="legal-list">
                    <li>les propos injurieux, diffamatoires ou discriminatoires ;</li>
                    <li>la publication de contenus illicites ou trompeurs ;</li>
                    <li>toute tentative de perturbation du fonctionnement du service.</li>
                </ul>
            </section>

            <section class="legal-block">
                <h2>Contenus publiés</h2>
                <p>
                    Les contenus publiés par les utilisateurs peuvent faire l'objet d'une modération.
                </p>
                <p>
                    L'équipe projet se réserve la possibilité de retirer tout contenu jugé inapproprié ou non conforme
                    à l'objet de la plateforme.
                </p>
            </section>

            <section class="legal-block">
                <h2>Disponibilité</h2>
                <p>
                    La plateforme est fournie sans garantie de disponibilité continue. Des interruptions peuvent intervenir,
                    notamment pour maintenance ou évolution du service.
                </p>
            </section>

            <section class="legal-block">
                <h2>Évolution des CGU</h2>
                <p>
                    Les présentes conditions peuvent être modifiées afin de tenir compte des évolutions du projet,
                    des besoins techniques ou des obligations applicables.
                </p>
            </section>
        </div>
    </div>
</section>
@endsection
