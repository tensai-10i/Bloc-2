@extends('layouts.app')

@section('title', 'Nouveau type de ressource')

@section('content')

    <div class="page-wrapper page-wrapper--narrow">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>Nouveau type de ressource</h1>
                <p class="page-subtitle">Créez un type dans la même continuité visuelle que la page d'accueil.</p>
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
            <form method="POST" action="{{ route('type_ressource.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name_typeressource">Nom du type</label>
                    <input type="text" id="name_typeressource" name="name_typeressource"
                           value="{{ old('name_typeressource') }}"
                           placeholder="Ex : Vidéo, Document, Audio…">
                    @error('name_typeressource')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button class="btn btn-primary">Créer</button>
                    <a href="{{ route('type_ressource.index') }}" class="btn btn-outline">Annuler</a>
                </div>

            </form>
        </div>

    </div>

@endsection
