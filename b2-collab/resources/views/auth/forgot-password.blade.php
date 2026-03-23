<x-guest-layout>
    <h1 class="auth-title">Mot de passe oublié</h1>
    <p class="auth-copy">Aucun problème. Indiquez simplement votre adresse e-mail et nous vous enverrons un lien pour choisir un nouveau mot de passe.</p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div>
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" type="email" name="email" class="w-full" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="auth-actions">
            <x-primary-button>Envoyer le lien de réinitialisation</x-primary-button>
        </div>
    </form>
</x-guest-layout>
