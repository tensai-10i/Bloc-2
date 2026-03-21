<x-guest-layout>
    <h1 class="auth-title">Confirmer votre mot de passe</h1>
    <p class="auth-copy">Cette zone est sécurisée. Veuillez confirmer votre mot de passe avant de continuer.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <div>
            <x-input-label for="password" :value="'Mot de passe'" />
            <x-text-input id="password" type="password" name="password" class="w-full" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="auth-actions">
            <x-primary-button>Confirmer</x-primary-button>
        </div>
    </form>
</x-guest-layout>
