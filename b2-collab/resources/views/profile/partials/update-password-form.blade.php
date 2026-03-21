<section class="account-section">
    <header>
        <h2>Modifier le mot de passe</h2>
        <p>Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="form-stack">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="'Mot de passe actuel'" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="'Nouveau mot de passe'" />
            <x-text-input id="update_password_password" name="password" type="password" class="w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="'Confirmer le mot de passe'" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="form-actions">
            <x-primary-button>Enregistrer</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-muted"
                >Enregistré.</p>
            @endif
        </div>
    </form>
</section>
