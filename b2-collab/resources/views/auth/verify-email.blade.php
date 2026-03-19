<x-guest-layout>
    <h1 class="auth-title">Verifier votre email</h1>
    <p class="auth-subtitle">Consultez votre boite mail puis cliquez sur le lien de verification.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            Un nouveau lien de verification a ete envoye a votre adresse email.
        </div>
    @endif

    <div class="auth-links">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <button type="submit" class="btn btn-primary">
                    Renvoyer l'email
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="auth-link">
                Deconnexion
            </button>
        </form>
    </div>
</x-guest-layout>
