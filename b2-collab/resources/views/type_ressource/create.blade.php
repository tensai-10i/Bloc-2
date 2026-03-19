@extends('layouts.app')

@section('title', 'Nouveau type de ressource')

@section('content')

    <div class="page-wrapper">

        <div class="page-header">
            <h1>Nouveau type de ressource</h1>
            <a href="{{ route('type_ressource.index') }}" class="btn btn-outline">Retour</a>
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
