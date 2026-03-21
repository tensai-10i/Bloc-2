<x-guest-layout>
    <h1 class="auth-title">Vérifier votre e-mail</h1>
    <p class="auth-subtitle">Consultez votre boîte mail puis cliquez sur le lien de vérification.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
        </div>
    @endif

    <div class="auth-links">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="btn btn-primary">
                Renvoyer l'e-mail
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="auth-link">
                Déconnexion
            </button>
        </form>
    </div>
</x-guest-layout>
