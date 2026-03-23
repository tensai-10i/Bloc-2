<x-guest-layout>
    <h1 class="auth-title">Réinitialiser le mot de passe</h1>
    <p class="auth-subtitle">Choisissez un nouveau mot de passe sans quitter l'identité graphique du site.</p>

    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" type="email" name="email" class="w-full" :value="old('email', $request->email)" required autofocus autocomplete="username" />
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

        <div class="auth-actions">
            <x-primary-button>Réinitialiser le mot de passe</x-primary-button>
        </div>
    </form>
</x-guest-layout>
