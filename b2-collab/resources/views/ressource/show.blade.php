@extends('layouts.app')

@section('title', 'Détail de la ressource')

@section('content')

    <div class="page-wrapper">

        <div class="page-header">
            <h1>{{ $ressource->name_ressource }}</h1>
            <div style="display:flex; gap:0.6rem">
                <a href="{{ route('ressources.edit', $ressource->id_ressource) }}" class="btn btn-primary">
                    Modifier
                </a>
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
                    <div class="input-display" style="min-height:80px">
                        {{ $ressource->description ?? '—' }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Créé le</label>
                    <div class="input-display">
                        {{ \Carbon\Carbon::parse($ressource->created_at)->format('d/m/Y') }}
                    </div>
                </div>

                <div class="form-actions" style="border-top:1px solid var(--green-pale); padding-top:1.25rem; margin-top:1rem">
                    <form action="{{ route('ressources.destroy', $ressource->id_ressource) }}"
                          method="POST"
                          onsubmit="return confirm('Supprimer cette ressource ?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Supprimer</button>
                    </form>
                </div>

            </div>
        </div>

    </div>

@endsection
