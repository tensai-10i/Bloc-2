@extends('layouts.app')

@section('title', 'Mentions légales')

@section('content')
<section class="legal-page container">
    <div class="page-title-block">
        <p class="page-kicker">Informations</p>
        <h1 class="legal-main-title">Mentions légales</h1>
        <p class="page-intro">Les pages légales adoptent désormais la même sobriété premium, les mêmes espacements et les mêmes cartes que le reste du site.</p>
    </div>

    <div class="legal-card">

        <div class="legal-content">
            <section class="legal-block">
                <h2>Éditeur du site</h2>
                <p>
                    Le site <strong>RESources Relationnelles</strong> est un projet pédagogique réalisé dans le cadre
                    d'un travail collaboratif de développement web.
                </p>
                <p>
                    Responsable de publication : équipe projet B2 Collab.
                </p>
            </section>

            <section class="legal-block">
                <h2>Hébergement</h2>
                <p>
                    Le site est hébergé sur un environnement de développement utilisé dans le cadre du projet.
                </p>
                <p>
                    Les informations techniques liées à l'hébergement peuvent être précisées dans la documentation du dépôt GitHub.
                </p>
            </section>

            <section class="legal-block">
                <h2>Propriété intellectuelle</h2>
                <p>
                    Les contenus, maquettes, textes, éléments graphiques, logos et composants présents sur ce site sont
                    utilisés dans le cadre du projet pédagogique.
                </p>
                <p>
                    Toute reproduction, représentation ou diffusion, même partielle, sans autorisation préalable,
                    n'est pas autorisée en dehors du cadre de ce projet.
                </p>
            </section>

            <section class="legal-block">
                <h2>Données personnelles</h2>
                <p>
                    Les données éventuellement collectées via la plateforme sont traitées dans le respect des règles
                    applicables à la protection des données.
                </p>
                <p>
                    Aucune donnée n'est utilisée à des fins commerciales dans le cadre de ce projet.
                </p>
            </section>

            <section class="legal-block">
                <h2>Responsabilité</h2>
                <p>
                    L'équipe projet s'efforce de fournir des informations exactes et à jour. Toutefois, aucune garantie
                    n'est donnée quant à l'exhaustivité ou à l'absence d'erreur dans les contenus proposés.
                </p>
            </section>
        </div>
    </div>
</section>
@endsection
