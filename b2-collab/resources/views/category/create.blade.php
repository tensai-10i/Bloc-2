@extends('layouts.app')

@section('title', 'Nouvelle catégorie')

@section('content')

    <div class="page-wrapper page-wrapper--narrow">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>Nouvelle catégorie</h1>
                <p class="page-subtitle">Ajoutez une catégorie dans le même langage visuel que la page d'accueil.</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('category.index') }}" class="btn btn-outline">Retour</a>
            </div>
        </div>

        <div class="form-card">

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('category.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name_cat">Nom de la catégorie</label>
                    <input type="text" id="name_cat" name="name_cat" value="{{ old('name_cat') }}" required>

                    @error('name_cat')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Créer la catégorie</button>
                    <a href="{{ route('category.index') }}" class="btn btn-outline">Annuler</a>
                </div>
            </form>

        </div>

    </div>

@endsection
