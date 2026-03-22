@extends('layouts.app')

@section('title', $ressource->name_ressource)

@section('content')

    <article class="article-page">

        <header class="article-header">
            <h1>{{ $ressource->name_ressource }}</h1>
            <p class="article-meta">
                Type : {{ $ressource->typeRessource->name_typeressource ?? '—' }} |
                Catégorie : {{ $ressource->category->name_cat ?? '—' }} |
                Créé le : {{ $ressource->created_at->format('d/m/Y') }}
            </p>
        </header>

        <section class="article-content">
            <p>{{ $ressource->description ?? 'Pas de description disponible.' }}</p>
        </section>

        <hr>

        <section class="comments">
            <h2>Commentaires ({{ $ressource->comments->count() }})</h2>

            @if($ressource->comments->isEmpty())
                <p>Aucun commentaire pour le moment.</p>
            @else
                @foreach($ressource->comments as $comment)
                    <div class="comment">
                        <p><strong>{{ $comment->user->name }}</strong> <small>{{ $comment->created_at->diffForHumans() }}</small></p>
                        <p>{{ $comment->content }}</p>
                    </div>
                @endforeach
            @endif

            @auth
                <form action="{{ route('ressources.comments.store', $ressource->id_ressource) }}" method="POST" class="comment-form">
                    @csrf
                    <textarea name="content" rows="3" placeholder="Écrire un commentaire..." required></textarea>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            @else
                <p>Connectez-vous pour laisser un commentaire.</p>
            @endauth
        </section>

    </article>

@endsection
