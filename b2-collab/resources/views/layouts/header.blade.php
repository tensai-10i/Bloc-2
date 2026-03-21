<header>
    <div class="container navbar-wrapper">
        <nav class="navbar">
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ route('ressources.index') }}">Ressources</a>
            <a href="{{ route('support') }}">Support</a>
            <a href="{{ route('contact') }}">Contact</a>
            @auth
                <a href="{{ route('dashboard') }}">Mon espace</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0;">
                    @csrf
                    <button type="submit" class="navbar-logout-btn">Déconnexion</button>
                </form>
            @else
                <a href="{{ route('login') }}">Connexion / inscription</a>
            @endauth
        </nav>
    </div>
</header>
