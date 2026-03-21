@extends('layouts.app')

@section('title', 'Gestion')

@section('content')
<div class="page-wrapper">
    <div class="page-header">
        <div class="page-title-block">
            <p class="page-kicker">Administration</p>
            <h1>Espace de gestion</h1>
            <p class="page-subtitle">Centralisez les actions d'administration dans une interface alignée sur la direction artistique de la home.</p>
        </div>
    </div>

    <div class="dashboard-card-grid">
        <a href="{{ route('ressources.index') }}" class="quick-link-card">
            <h3>Gérer les ressources</h3>
            <p>Accéder à la liste complète, créer de nouvelles fiches et mettre à jour les contenus.</p>
        </a>
        <a href="{{ route('category.index') }}" class="quick-link-card">
            <h3>Gérer les catégories</h3>
            <p>Organiser la bibliothèque et maintenir la structure éditoriale du projet.</p>
        </a>
        <a href="{{ route('admin.users.index') }}" class="quick-link-card">
            <h3>Gérer les rôles utilisateurs</h3>
            <p>Attribuer les permissions et piloter les accès de l'application.</p>
        </a>
    </div>
</div>
@endsection
