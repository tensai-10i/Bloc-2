@extends('layouts.app')

@section('title', 'Type de ressource')

@section('content')

    <div class="page-wrapper">

        <div class="page-header">
            <h1>{{ $type->name_typeressource }}</h1>
            <a href="{{ route('type_ressource.index') }}" class="btn btn-outline">Retour</a>
        </div>

        <div class="tr-form-card">

            <div class="form-group">
                <label>Nom du type :</label>
                <div class="tr-display">{{ $type->name_typeressource }}</div>
            </div>

            <div class="form-group">
                <label>Créé le :</label>
                <div class="tr-display">{{ \Carbon\Carbon::parse($type->created_at)->format('d/m/Y') }}</div>
            </div>

            <div class="form-group">
                <label>Ressources associées : </label>
                <div class="tr-display">{{ $type->ressources->count() }} ressource(s)</div>
            </div>

        </div>

    </div>

@endsection
