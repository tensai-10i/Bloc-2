@extends('layouts.app')

@section('title', 'Catégories')

@section('content')

    <div class="page-wrapper">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>
                    Catégories
                    @if(!$categories->isEmpty())
                        <span class="count-badge">{{ $categories->count() }}</span>
                    @endif
                </h1>
                <p class="page-subtitle">Retrouvez toutes les catégories dans un habillage commun avec la page d'accueil.</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('category.create') }}" class="btn btn-primary">
                    Nouvelle catégorie
                </a>
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
        </div>

        <div class="card">
            <div class="table-wrap">
                @if($categories->isEmpty())
                    <div class="empty-state">
                        <svg width="52" height="52" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                            <path d="M4 7h16M7 4h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                        </svg>
                        <p>Aucune catégorie pour l'instant</p>
                    </div>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Créée le</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td><span class="id-badge">#{{ $category->id_cat }}</span></td>
                                    <td><span class="category-name">{{ $category->name_cat }}</span></td>
                                    <td class="date-cell">{{ optional($category->created_at)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="actions-cell">
                                            <a href="{{ route('category.edit', $category->id_cat) }}" class="btn btn-outline btn-sm">
                                                Modifier
                                            </a>
                                            <form action="{{ route('category.destroy', $category->id_cat) }}" method="POST" class="inline-form" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
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
