@extends('layouts.app')

@section('title', 'Modifier un type de ressource')

@section('content')

    <div class="page-wrapper page-wrapper--narrow">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>Modifier le type</h1>
                <p class="page-subtitle">Conservez la structure existante tout en alignant la page sur le style premium du site.</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('type_ressource.index') }}" class="btn btn-outline">Retour</a>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="tr-form-card">
            <form method="POST" action="{{ route('type_ressource.update', $type->id_typeressource) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name_typeressource">Nom du type</label>
                    <input type="text" id="name_typeressource" name="name_typeressource"
                           value="{{ old('name_typeressource', $type->name_typeressource) }}"
                           placeholder="Ex : Vidéo, Document, Audio…">
                    @error('name_typeressource')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('type_ressource.index') }}" class="btn btn-outline">Annuler</a>
                </div>

            </form>
        </div>

    </div>

@endsection
