@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

    <section class="hero container">
<br><br><br>
        <div class="search-bar">
            <input type="text" placeholder="Rechercher une ressource...">
            <span>🔍</span>
        </div>
        
        <p class="hero-quote">
            "Un espace pour mieux comprendre, communiquer et coopérer."
        </p>
    </section>

    <section class="wave-section">
        <div class="wave-line one"></div>
        <div class="wave-line two"></div>
        <div class="wave-line three"></div>
    </section>

    <section class="categories-section container">
        <h2 class="section-title">Catégories</h2>

        <div class="categories-grid">
            <a href="/ressources/communication" class="category-card">
                Communication
            </a>

            <a href="/ressources/gestion-conflits" class="category-card">
                Gestion des conflits
            </a>

            <a href="/ressources/cooperation" class="category-card">
                Coopération
            </a>

            <a href="/ressources/negociation" class="category-card">
                Négociation
            </a>

            <a href="/ressources/mediations" class="category-card">
                Médiation
            </a>

            <a href="/ressources/outils" class="category-card">
                Outils
            </a>
        </div>
    </section>

    <section class="popular-section">
        <div class="container">
            <h2 class="section-title">Ressources populaires</h2>

            <div class="resources-grid">
                <a href="/ressources/gestion-conflits" class="resource-card">
                    <h3>Gestion des conflits</h3>
                    <p>
                        Comprendre les tensions et apprendre à les résoudre de manière constructive.
                    </p>

                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>

                    <span class="tag">Communication</span>
                </a>

                <a href="/ressources/ecoute-active" class="resource-card">
                    <h3>Écoute active</h3>
                    <p>
                        Développer une écoute attentive pour améliorer les relations interpersonnelles.
                    </p>

                    <div class="fake-line long"></div>
                    <div class="fake-line short"></div>

                    <span class="tag">Communication</span>
                </a>

                <a href="/ressources/cooperation-equipe" class="resource-card">
                    <h3>Coopération en équipe</h3>
                    <p>
                        Outils pratiques pour mieux collaborer et répartir les rôles dans un groupe.
                    </p>

                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>

                    <span class="tag">Travail</span>
                </a>

                <a href="/ressources/mediation" class="resource-card">
                    <h3>Médiation</h3>
                    <p>
                        Découvrir les bases de la médiation pour apaiser les désaccords durables.
                    </p>

                    <div class="fake-line long"></div>
                    <div class="fake-line short"></div>

                    <span class="tag">Relationnel</span>
                </a>
            </div>
        </div>
    </section>

@endsection