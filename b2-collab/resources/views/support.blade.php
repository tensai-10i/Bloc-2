@extends('layouts.app')

@section('title', 'Outils')

@section('content')

<section class="container tools-page">

    <div class="page-title-block">
        <p class="page-kicker">Support</p>
        <h1 class="tools-title">Outils</h1>
        <p class="page-intro">Une sélection d'outils et de contenus pratiques, présentés dans la même identité visuelle que la page d'accueil.</p>
    </div>

    <section class="wave-section">
        <div class="wave-line one"></div>
        <div class="wave-line two"></div>
        <div class="wave-line three"></div>
    </section>

    <div class="tools-grid">

        <a href="#" class="tool-card">
            <h3>Exercices relationnels</h3>

            <ul>
                <li>exercice de communication</li>
                <li>jeu de rôle</li>
                <li>test d'écoute active</li>
            </ul>
        </a>

        <a href="#" class="tool-card">
            <h3>Outils d'auto évaluation</h3>

            <ul>
                <li>questionnaires</li>
                <li>checklists</li>
                <li>quiz relationnels</li>
            </ul>
        </a>

        <a href="#" class="tool-card">
            <h3>Nos conseils</h3>

            <ul>
                <li>gestion du stress</li>
                <li>régulation émotionnelle</li>
                <li>supports scientifiques</li>
            </ul>
        </a>

        <a href="#" class="tool-card">
            <h3>Fiches pratiques</h3>

            <ul>
                <li>comment gérer des conflits</li>
                <li>savoir exprimer ses besoins</li>
            </ul>
        </a>

    </div>

</section>

@endsection
