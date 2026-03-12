@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <section class="hero container">
        <div class="hero-quote">
            "Améliorez vos relations humaines au quotidien"
        </div>

        <div class="search-bar">
            <input type="text" placeholder="Rechercher une ressource...">
            <span>🔍</span>
        </div>
    </section>

    <section class="wave-section">
        <div class="wave-line one"></div>
        <div class="wave-line two"></div>
        <div class="wave-line three"></div>
    </section>

    <section class="categories-section container">
        <div class="section-title">Les catégories principales :</div>

        <div class="categories-grid">
            <div class="category-card">Famille</div>
            <div class="category-card">Couple</div>
            <div class="category-card">Travail</div>
            <div class="category-card">Amis</div>
            <div class="category-card">Communauté</div>
            <div class="category-card">Développement personnel</div>
        </div>
    </section>

    <section class="popular-section">
        <div class="container">
            <div class="section-title">Ressources populaires</div>

            <div class="resources-grid">
                <div class="resource-card">
                    <h3>Titre</h3>
                    <p>Description</p>
                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>
                    <div class="fake-line short"></div>
                    <span class="tag">Ressource</span>
                </div>

                <div class="resource-card">
                    <h3>Titre</h3>
                    <p>Description</p>
                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>
                    <div class="fake-line short"></div>
                    <span class="tag">Ressource</span>
                </div>

                <div class="resource-card">
                    <h3>Titre</h3>
                    <p>Description</p>
                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>
                    <div class="fake-line short"></div>
                    <span class="tag">Ressource</span>
                </div>

                <div class="resource-card">
                    <h3>Titre</h3>
                    <p>Description</p>
                    <div class="fake-line long"></div>
                    <div class="fake-line medium"></div>
                    <div class="fake-line short"></div>
                    <span class="tag">Ressource</span>
                </div>
            </div>
        </div>
    </section>
@endsection