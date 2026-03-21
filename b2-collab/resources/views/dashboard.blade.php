<x-app-layout>
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Mon espace</p>
                <h1>Tableau de bord</h1>
                <p class="page-subtitle">Votre espace reprend maintenant les mêmes matières, contrastes et hiérarchies visuelles que la page d'accueil.</p>
            </div>
        </div>

        <div class="dashboard-grid">
            <section class="dashboard-panel dashboard-panel--highlight">
                <p class="section-title">Vue d'ensemble</p>
                <p class="dashboard-copy">Vous êtes connecté et votre espace personnel est harmonisé avec le reste de l'application.</p>

                <div class="summary-grid stack-top-gap">
                    <article class="summary-card">
                        <p class="stat-label">Rôle actuel</p>
                        <p class="stat-value">{{ auth()->user()->roleDisplay() }}</p>
                    </article>

                    <article class="summary-card">
                        <p class="stat-label">Adresse e-mail</p>
                        <p class="info-value">{{ auth()->user()->email }}</p>
                    </article>
                </div>

                <div class="dashboard-actions stack-top-gap">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Mon profil</a>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">Page de gestion</a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">Gérer les rôles</a>
                    @endif

                    @if(auth()->user()->canAccessModeration())
                        <a href="{{ route('moderator.dashboard') }}" class="btn btn-outline">Page de modération</a>
                    @endif
                </div>
            </section>

            <div class="account-stack">
                @if (auth()->user() && !auth()->user()->email_verified_at)
                    <section class="dashboard-panel">
                        <div class="alert alert-warning alert-flush">
                            <p class="compact-note-lg">Veuillez vérifier votre adresse e-mail pour déverrouiller toutes les fonctionnalités.</p>
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Vérifier l'adresse e-mail</button>
                            </form>
                        </div>
                    </section>
                @else
                    <section class="dashboard-panel">
                        <div class="alert alert-success alert-flush">
                            <p class="compact-note">Votre adresse e-mail a été vérifiée.</p>
                        </div>
                    </section>
                @endif

                <section class="dashboard-panel">
                    <p class="section-title">Accès rapides</p>
                    <div class="dashboard-card-grid">
                        <a href="{{ route('ressources.index') }}" class="quick-link-card">
                            <h3>Ressources</h3>
                            <p>Parcourir, créer et modifier les contenus de la plateforme.</p>
                        </a>
                        <a href="{{ route('support') }}" class="quick-link-card">
                            <h3>Support</h3>
                            <p>Retrouver les outils et contenus d'accompagnement.</p>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
