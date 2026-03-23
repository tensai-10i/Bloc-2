<section class="account-section">
    <header>
        <h2>Supprimer le compte</h2>
        <p>Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les informations que vous souhaitez conserver.</p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >Supprimer le compte</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-body">
            @csrf
            @method('delete')

            <h2 class="modal-title">Êtes-vous sûr de vouloir supprimer votre compte ?</h2>

            <p class="modal-copy">
                Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.
            </p>

            <div class="form-group form-group-top">
                <x-input-label for="password" value="Mot de passe" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="w-full"
                    placeholder="Mot de passe"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="modal-actions">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Annuler
                </x-secondary-button>

                <x-danger-button>
                    Supprimer le compte
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
