@extends('layouts.app')

@section('title', 'Modifier la catégorie')

@section('content')

    <div class="page-wrapper page-wrapper--narrow">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>Modifier la catégorie</h1>
                <p class="page-subtitle">Mettez à jour la présentation sans sortir du style général du site.</p>
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

            <form method="POST" action="{{ route('category.update', $category->id_cat) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name_cat">Nom de la catégorie</label>
                    <input type="text" id="name_cat" name="name_cat" value="{{ old('name_cat', $category->name_cat) }}" required>

                    @error('name_cat')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Modifier la catégorie</button>
                    <a href="{{ route('category.index') }}" class="btn btn-outline">Annuler</a>
                </div>
            </form>

        </div>

    </div>

@endsection
