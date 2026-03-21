<header>
    <div class="container navbar-wrapper">
        <nav class="navbar">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Accueil</a>
            <a href="{{ route('ressources.index') }}" class="{{ request()->routeIs('ressources.*') || request()->routeIs('type_ressource.*') || request()->routeIs('category.*') ? 'is-active' : '' }}">Ressources</a>
            <a href="{{ route('support') }}" class="{{ request()->routeIs('support') ? 'is-active' : '' }}">Support</a>
            <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') || request()->routeIs('mentions-legales') || request()->routeIs('cgu') ? 'is-active' : '' }}">Contact</a>
            @auth
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') || request()->routeIs('profile.*') || request()->routeIs('admin.*') || request()->routeIs('moderator.*') ? 'is-active' : '' }}">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}" class="inline-form">
                    @csrf
                    <button type="submit" class="navbar-logout-btn">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*') || request()->routeIs('verification.*') ? 'is-active' : '' }}">Connexion / inscription</a>
            @endauth
        </nav>
    </div>
</header>
