@extends('layouts.app')

@section('title', 'Type de ressource')

@section('content')

    <div class="page-wrapper page-wrapper--narrow">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>{{ $type->name_typeressource }}</h1>
                <p class="page-subtitle">Visualisez les informations du type dans le même registre graphique que le reste du site.</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('type_ressource.index') }}" class="btn btn-outline">Retour</a>
            </div>
        </div>

        <div class="tr-form-card">

            <div class="form-group">
                <label>Nom du type</label>
                <div class="tr-display">{{ $type->name_typeressource }}</div>
            </div>

            <div class="form-group">
                <label>Créé le</label>
                <div class="tr-display">{{ \Carbon\Carbon::parse($type->created_at)->format('d/m/Y') }}</div>
            </div>

            <div class="form-group">
                <label>Ressources associées</label>
                <div class="tr-display">{{ $type->ressources->count() }} ressource(s)</div>
            </div>

        </div>

    </div>

@endsection
