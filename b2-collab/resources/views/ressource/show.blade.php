@extends('layouts.app')

@section('title', 'Détail de la ressource')

@section('content')

    <div class="page-wrapper page-wrapper--narrow">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>{{ $ressource->name_ressource }}</h1>
                <p class="page-subtitle">Consultez la ressource avec le même niveau de finition visuelle que le reste du site.</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('ressources.edit', $ressource->id_ressource) }}" class="btn btn-primary">Modifier</a>
                <a href="{{ route('ressources.index') }}" class="btn btn-outline">Retour</a>
            </div>
        </div>

        <div class="create-grid">
            <div class="create-main">

                <p class="section-title">Informations de la ressource</p>

                <div class="form-group">
                    <label>Nom de la ressource</label>
                    <div class="input-display">{{ $ressource->name_ressource }}</div>
                </div>

                <div class="form-group">
                    <label>Type de ressource</label>
                    <div class="input-display">
                        {{ $ressource->typeRessource->name_typeressource ?? '—' }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Catégorie</label>
                    <div class="input-display">
                        {{ $ressource->category->name_cat ?? '—' }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <div class="input-display input-display--large input-display--top">
                        {{ $ressource->description ?? '—' }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Créé le</label>
                    <div class="input-display">
                        {{ \Carbon\Carbon::parse($ressource->created_at)->format('d/m/Y') }}
                    </div>
                </div>

                <div class="form-actions">
                    <form action="{{ route('ressources.destroy', $ressource->id_ressource) }}" method="POST" onsubmit="return confirm('Supprimer cette ressource ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Supprimer</button>
                    </form>
                </div>

            </div>
        </div>

    </div>

@endsection
