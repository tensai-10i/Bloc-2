<x-app-layout>
    <div class="page-wrapper">
        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Profil public</p>
                <h1>Profil de {{ $user->name }}</h1>
                <p class="page-subtitle">Les informations utilisateur reprennent les mêmes codes de présentation que le reste du site.</p>
            </div>

            @auth
                @if (auth()->user()->id === $user->id)
                    <div class="page-header-actions">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Modifier votre profil</a>
                    </div>
                @endif
            @endauth
        </div>

        <div class="profile-panel">
            <div class="info-grid">
                <div class="info-item">
                    <p class="info-label">Prénom</p>
                    <p class="info-value">{{ $user->name }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">E-mail</p>
                    <p class="info-value">{{ $user->email }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Membre depuis</p>
                    <p class="info-value">{{ $user->created_at->format('d F Y') }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Dernière mise à jour</p>
                    <p class="info-value">{{ $user->updated_at->format('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
