<section class="account-section">
    <header>
        <h2>Informations de profil</h2>
        <p>Mettez à jour vos informations de profil et votre adresse e-mail.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="form-stack">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="'Prénom'" />
            <x-text-input id="name" name="name" type="text" class="w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="'E-mail'" />
            <x-text-input id="email" name="email" type="email" class="w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning alert-top alert-flush">
                    <p class="compact-note-sm">Votre adresse e-mail n'a pas été vérifiée.</p>

                    <button form="send-verification" class="btn-inline" type="submit">
                        Cliquez ici pour renvoyer l'e-mail de vérification.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="compact-note-top">Un nouveau lien de vérification a été envoyé à votre adresse e-mail.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="form-actions">
            <x-primary-button>Enregistrer</x-primary-button>

            @if (session('status') === 'profile-updated')
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
