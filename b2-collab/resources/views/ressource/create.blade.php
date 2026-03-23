@extends('layouts.app')

@section('title', 'Nouvelle ressource')

@section('content')

    <div class="page-wrapper page-wrapper--narrow">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>Nouvelle ressource</h1>
                <p class="page-subtitle">Créez une ressource dans une interface cohérente avec la page d'accueil.</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('ressources.index') }}" class="btn btn-outline">Retour</a>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('ressources.store') }}">
            @csrf

            <div class="create-grid">
                <div class="create-main">

                    <p class="section-title">Informations de la ressource</p>

                    <div class="form-group">
                        <label for="name_ressource">Nom de la ressource</label>
                        <input type="text" id="name_ressource" name="name_ressource"
                               value="{{ old('name_ressource') }}"
                               placeholder="Ex : Guide de démarrage"
                               required>
                        @error('name_ressource')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_typeressource">Type de ressource</label>
                        <select id="type_id" name="type_id" ...>
                            <option value="">— Sélectionner un type —</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id_typeressource }}"
                                    {{ old('id_typeressource') == $type->id_typeressource ? 'selected' : '' }}>
                                    {{ $type->name_typeressource }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_typeressource')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_cat">Catégorie</label>
                        <select id="category_id" name="category_id" ...>
                            <option value="">— Sélectionner une catégorie —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_cat }}"
                                    {{ old('id_cat') == $category->id_cat ? 'selected' : '' }}>
                                    {{ $category->name_cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_cat')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description <span class="text-muted">(optionnel)</span></label>
                        <textarea id="description" name="description"
                                  placeholder="Décrivez cette ressource…">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            Créer la ressource
                        </button>
                        <a href="{{ route('ressources.index') }}" class="btn btn-outline">Annuler</a>
                    </div>

                </div>
            </div>

        </form>

    </div>

@endsection
