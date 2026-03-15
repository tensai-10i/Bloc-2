@extends('layouts.app')

@section('title', 'Ressources')

@section('content')

<div class="page-wrapper">

    <div class="page-header">
        <h1>
            Ressources
            @if(!$ressources->isEmpty())
                <span class="count-badge">{{ $ressources->count() }}</span>
            @endif
        </h1>
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
            <a href="{{ route('ressource.create') }}" class="btn btn-primary">
                + Nouvelle ressource
            </a>

            <a href="{{ route('category.index') }}" class="btn btn-secondary">
                + Nouvelle catégorie
            </a>
        </div>

    </div>

    <div class="card">
        <div class="table-wrap">

            @if($ressources->isEmpty())

                <div class="empty-state">
                    <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                        <path d="M9 13h6m-3-3v6m-7 4h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2z"/>
                    </svg>
                    <p>Rien à voir pour l'instant</p>
                </div>

            @else

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom de la ressource</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ressources as $ressource)
                            <tr>
                                <td>
                                    <span class="id-badge">
                                        #{{ $ressource->id_ressource }}
                                    </span>
                                </td>

                                <td>
                                    <span class="ressource-name">
                                        {{ $ressource->name_ressource }}
                                    </span>
                                </td>

                                <td class="date-cell">
                                    {{ \Carbon\Carbon::parse($ressource->creation_date)->format('d/m/Y') }}
                                </td>

                                <td>
                                    <div class="actions-cell">
                                        <a href="{{ route('ressources.edit', $ressource->id_ressource) }}"
                                           class="btn btn-outline btn-sm">
                                            Modifier
                                        </a>

                                        <form action="{{ route('ressources.destroy', $ressource->id_ressource) }}"
                                              method="POST"
                                              style="display:inline"
                                              onsubmit="return confirm('Supprimer cette ressource ?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Supprimer
                                            </button>
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

<script>
    document.getElementById('searchInput')?.addEventListener('input', function () {
        const q = this.value.toLowerCase();

        document.querySelectorAll('tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });
</script>

@endsection
