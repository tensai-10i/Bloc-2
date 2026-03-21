<nav x-data="{ open: false }">
    <div class="container navbar-wrapper">
        <div class="navbar navbar-space-between">
            <div class="toolbar-actions">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'is-active' : '' }}">Accueil</a>
                <a href="{{ route('ressources.index') }}" class="{{ request()->routeIs('ressources.*') || request()->routeIs('type_ressource.*') || request()->routeIs('category.*') ? 'is-active' : '' }}">Ressources</a>
                <a href="{{ route('support') }}" class="{{ request()->routeIs('support') ? 'is-active' : '' }}">Support</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'is-active' : '' }}">Contact</a>
            </div>

            <div class="toolbar-actions">
                <span class="meta-badge">{{ Auth::user()->name }}</span>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'is-active' : '' }}">Profil</a>
                <button type="button" class="btn btn-secondary btn-sm" @click="open = ! open">Menu</button>
                <form method="POST" action="{{ route('logout') }}" class="inline-form">
                    @csrf
                    <button type="submit" class="navbar-logout-btn">Déconnexion</button>
                </form>
            </div>
        </div>

        <div x-show="open" x-transition style="display: none;" class="profile-panel panel-top-gap">
            <div class="toolbar-actions">
                <a href="{{ route('dashboard') }}" class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">Tableau de bord</a>
                <a href="{{ route('profile.edit') }}" class="mobile-nav-link {{ request()->routeIs('profile.*') ? 'is-active' : '' }}">Profil</a>
                <a href="{{ route('ressources.index') }}" class="mobile-nav-link {{ request()->routeIs('ressources.*') ? 'is-active' : '' }}">Ressources</a>
            </div>
        </div>
    </div>
</nav>
