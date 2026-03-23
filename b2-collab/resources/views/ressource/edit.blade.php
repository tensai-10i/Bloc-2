@extends('layouts.app')

@section('title', 'Modifier une ressource')

@section('content')

    <div class="page-wrapper page-wrapper--narrow">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>Modifier la ressource</h1>
                <p class="page-subtitle">Ajustez les contenus dans un cadre aligné sur les autres pages du site.</p>
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

        <form action="{{ route('ressources.update', $ressource->id_ressource) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="create-grid">
                <div class="create-main">

                    <p class="section-title">Informations de la ressource</p>

                    <div class="form-group">
                        <label for="name_ressource">Nom de la ressource</label>
                        <input type="text" id="name_ressource" name="name_ressource"
                               value="{{ old('name_ressource', $ressource->name_ressource) }}"
                               placeholder="Ex : Guide de démarrage"
                               required>
                        @error('name_ressource')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_typeressource">Type de ressource</label>
                        <select id="id_typeressource" name="id_typeressource" required>
                            <option value="">— Sélectionner un type —</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id_typeressource }}"
                                    {{ old('id_typeressource', $ressource->id_typeressource) == $type->id_typeressource ? 'selected' : '' }}>
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
                        <select id="id_cat" name="id_cat" required>
                            <option value="">— Sélectionner une catégorie —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_cat }}"
                                    {{ old('id_cat', $ressource->id_cat) == $category->id_cat ? 'selected' : '' }}>
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
                                  placeholder="Décrivez cette ressource…">{{ old('description', $ressource->description) }}</textarea>
                        @error('description')
                        <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                        <a href="{{ route('ressources.index') }}" class="btn btn-outline">Annuler</a>
                    </div>

                </div>
            </div>

        </form>

    </div>

@endsection
