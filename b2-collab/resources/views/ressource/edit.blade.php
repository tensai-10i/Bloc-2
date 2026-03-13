@extends('layouts.app')

@section('title', 'Modifier une ressource')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ressource.css') }}">

    <div class="page-wrapper">

        <div class="page-header">
            <h1>Modifier une ressource</h1>
        </div>

        <div class="card">

            <form action="{{ route('ressources.update', $ressource->id_ressource) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">

                    <label for="name_ressource">Nom de la ressource</label>

                    <input
                        type="text"
                        id="name_ressource"
                        name="name_ressource"
                        value="{{ old('name_ressource', $ressource->name_ressource) }}"
                        required
                    >

                    @error('name_ressource')
                    <div class="form-error">
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="form-actions">

                    <a href="{{ route('ressources.index') }}" class="btn btn-outline">
                        Annuler
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Enregistrer
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection
