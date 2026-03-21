@extends('layouts.app')

@section('title', 'Types de ressource')

@section('content')

    <div class="page-wrapper">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>
                    Types de ressource
                    @if($types->count())
                        <span class="count-badge">{{ $types->count() }}</span>
                    @endif
                </h1>
                <p class="page-subtitle">Chaque type est présenté avec les mêmes volumes, arrondis et contrastes que la home.</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('type_ressource.create') }}" class="btn btn-primary">+ Nouveau type</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="table-wrap">

                @if($types->isEmpty())
                    <div class="empty-state">
                        <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                            <path d="M9 13h6m-3-3v6m-7 4h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z"/>
                        </svg>
                        <p>Aucun type de ressource</p>
                    </div>
                @else
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($types as $type)
                            <tr>
                                <td><span class="id-badge">#{{ $type->id_typeressource }}</span></td>
                                <td class="fw-600">{{ $type->name_typeressource }}</td>
                                <td class="text-muted">{{ \Carbon\Carbon::parse($type->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('type_ressource.show', $type->id_typeressource) }}" class="btn btn-outline btn-sm">Voir</a>
                                        <a href="{{ route('type_ressource.edit', $type->id_typeressource) }}" class="btn btn-outline btn-sm">Éditer</a>
                                        <form action="{{ route('type_ressource.destroy', $type->id_typeressource) }}" method="POST" class="inline-form" onsubmit="return confirm('Supprimer ce type ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>

    </div>

@endsection
