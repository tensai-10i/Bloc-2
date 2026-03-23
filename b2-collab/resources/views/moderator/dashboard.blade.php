@extends('layouts.app')

@section('title', 'Modération')

@section('content')
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-title-block">
            <p class="page-kicker">Modération</p>
            <h1>Espace modération</h1>
            <p class="page-subtitle">Les accès de modération sont maintenant présentés dans le même langage visuel que les pages publiques et privées.</p>
        </div>
    </div>

    <div class="dashboard-card-grid">
        <a href="{{ route('ressources.index') }}" class="quick-link-card">
            <h3>Voir les ressources</h3>
            <p>Consulter rapidement les contenus disponibles sur la plateforme.</p>
        </a>
        <a href="{{ route('support') }}" class="quick-link-card">
            <h3>Aller au support</h3>
            <p>Accéder aux outils utiles pour accompagner les utilisateurs.</p>
        </a>
    </div>
</div>
@endsection
