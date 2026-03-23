<x-guest-layout>
    <h1 class="auth-title">Connexion</h1>
    <p class="auth-subtitle">Retrouvez l'expérience visuelle de l'accueil jusque dans l'espace d'authentification.</p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div>
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" type="email" name="email" class="w-full" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="'Mot de passe'" />
            <x-text-input id="password" type="password" name="password" class="w-full" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="check-row">
            <label for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Se souvenir de moi</span>
            </label>
        </div>

        <div class="auth-row">
            @if (Route::has('password.request'))
                <a class="auth-inline-link" href="{{ route('password.request') }}">
                    Mot de passe oublié ?
                </a>
            @endif

            <x-primary-button>Connexion</x-primary-button>
        </div>

        <p class="auth-note">
            Vous n'avez pas de compte ?
            <a href="{{ route('register') }}" class="auth-inline-link">S'inscrire</a>
        </p>
    </form>
</x-guest-layout>
