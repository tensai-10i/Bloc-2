@extends('layouts.app')

@section('title', 'Catégories')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/category.css') }}">

    <div class="page-wrapper">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <h1>
                Catégories
                @if(!$categories->isEmpty())
                    <span class="count-badge">{{ $categories->count() }}</span>
                @endif
            </h1>

            <a href="{{ route('category.create') }}" class="btn btn-primary">
                Nouvelle catégorie
            </a>
        </div>

        <div class="toolbar">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Rechercher…">
            </div>
        </div>

        <div class="card">
            <div class="table-wrap">
                {{-- ton tableau reste inchangé --}}
            </div>
        </div>

    </div>

@endsection
