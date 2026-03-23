<x-app-layout>
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Mon espace</p>
                <h1>Profil</h1>
                <p class="page-subtitle">Vos paramètres de compte s'inscrivent maintenant dans la même identité visuelle que l'accueil.</p>
            </div>
        </div>

        <div class="status-stack">
            @if (auth()->user() && !auth()->user()->email_verified_at)
                <div class="dashboard-panel">
                    <div class="alert alert-warning alert-flush">
                        <h3 class="compact-note-sm">Vérifier votre adresse e-mail</h3>
                        <p class="compact-note-md">Veuillez vérifier votre adresse e-mail pour déverrouiller toutes les fonctionnalités.</p>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary">Envoyer l'e-mail de vérification</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="dashboard-panel">
                    <div class="alert alert-success alert-flush">
                        <p class="compact-note">Votre adresse e-mail a été vérifiée.</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="account-stack stack-top-gap">
            <div class="profile-panel">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="profile-panel">
                @include('profile.partials.update-password-form')
            </div>

            <div class="profile-panel">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
