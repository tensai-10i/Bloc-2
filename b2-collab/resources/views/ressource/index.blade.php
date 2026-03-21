@extends('layouts.app')

@section('title', 'Ressources')

@section('content')

    <div class="page-wrapper">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>
                    Ressources
                    @if(!$ressources->isEmpty())
                        <span class="count-badge">{{ $ressources->total() }}</span>
                    @endif
                </h1>
                <p class="page-subtitle">Toutes les ressources reprennent les couleurs, les surfaces et les interactions de la home.</p>
            </div>
        </div>

        <div class="toolbar">
            <div class="search-box">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/>
                    <path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Rechercher…">
            </div>

            <div class="toolbar-actions">
                <a href="{{ route('ressources.create') }}" class="btn btn-primary">+ Nouvelle ressource</a>
                <a href="{{ route('type_ressource.index') }}" class="btn btn-outline">Types de ressource</a>
                <a href="{{ route('category.index') }}" class="btn btn-outline">Catégories</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="table-wrap">

                @if($ressources->isEmpty())
                    <div class="empty-state">
                        <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                            <path d="M9 13h6m-3-3v6m-7 4h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z"/>
                        </svg>
                        <p>Aucune ressource pour l'instant</p>
                    </div>
                @else
                    <table>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Catégorie</th>
                            <th>Créé le</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ressources as $ressource)
                            <tr>
                                <td>
                                    <span class="id-badge">#{{ $ressource->id_ressource }}</span>
                                </td>
                                <td>
                                    <span class="ressource-name">{{ $ressource->name_ressource }}</span>
                                </td>
                                <td>
                                    <span class="meta-badge">
                                        {{ $ressource->typeRessource->name_typeressource ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="meta-badge">
                                        {{ $ressource->category->name_cat ?? '—' }}
                                    </span>
                                </td>
                                <td class="date-cell">
                                    {{ \Carbon\Carbon::parse($ressource->created_at)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('ressources.show', $ressource->id_ressource) }}" class="btn btn-outline btn-sm">
                                            Voir
                                        </a>
                                        <a href="{{ route('ressources.edit', $ressource->id_ressource) }}" class="btn btn-outline btn-sm">
                                            Modifier
                                        </a>
                                        <form action="{{ route('ressources.destroy', $ressource->id_ressource) }}" method="POST" class="inline-form" onsubmit="return confirm('Supprimer cette ressource ?')">
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

        @if($ressources->hasPages())
            <div class="pagination-shell">
                {{ $ressources->links() }}
            </div>
        @endif

    </div>

    <script>
        document.getElementById('searchInput')?.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>

@endsection
