<x-guest-layout>
    <h1 class="auth-title">Créer un compte</h1>
    <p class="auth-subtitle">Inscrivez-vous dans une interface cohérente avec l'ensemble du site.</p>

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div>
            <x-input-label for="name" :value="'Prénom'" />
            <x-text-input id="name" type="text" name="name" class="w-full" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" type="email" name="email" class="w-full" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="'Mot de passe'" />
            <x-text-input id="password" type="password" name="password" class="w-full" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="'Confirmer le mot de passe'" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" class="w-full" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="auth-row">
            <a class="auth-inline-link" href="{{ route('login') }}">
                Vous avez déjà un compte ?
            </a>

            <x-primary-button>S'inscrire</x-primary-button>
        </div>
    </form>
</x-guest-layout>
