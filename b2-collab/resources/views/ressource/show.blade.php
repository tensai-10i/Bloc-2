@extends('layouts.app')

@section('title', $ressource->name_ressource)

@push('styles')
    <style>
        .resource-show-page {
            display: grid;
            gap: 24px;
        }

        .resource-hero,
        .resource-comments-panel {
            display: grid;
            gap: 24px;
        }

        .resource-hero {
            padding: 28px;
        }

        .resource-show-meta {
            margin-top: 4px;
        }

        .resource-show-content {
            display: grid;
            gap: 16px;
        }

        .resource-richtext {
            margin: 0;
            color: var(--text-soft);
            font-size: 16px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .resource-comments-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .comment-list {
            display: grid;
            gap: 16px;
        }

        .comment-card {
            display: grid;
            gap: 12px;
            padding: 22px;
            border-radius: var(--radius-md);
            border: 1px solid rgba(111, 159, 143, 0.16);
            background: rgba(255, 255, 255, 0.78);
            box-shadow: 0 12px 24px rgba(73, 67, 58, 0.06);
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .comment-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(111, 159, 143, 0.14);
            border: 1px solid rgba(111, 159, 143, 0.22);
            color: var(--brand-deep);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .comment-author-meta {
            display: grid;
            gap: 2px;
        }

        .comment-author-name {
            color: #4b4b4b;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.2;
        }

        .comment-author-role {
            color: var(--text-muted);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .comment-date {
            margin-left: auto;
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.4;
        }

        .comment-text {
            margin: 0;
            color: var(--text-soft);
            font-size: 15px;
            line-height: 1.75;
        }

        .comments-empty,
        .login-prompt {
            padding: 22px;
            border-radius: var(--radius-md);
            border: 1px dashed rgba(111, 159, 143, 0.24);
            background: rgba(255, 255, 255, 0.68);
            color: var(--text-soft);
            text-align: center;
            line-height: 1.7;
        }

        .resource-comment-form {
            padding-top: 24px;
            border-top: 1px solid rgba(111, 159, 143, 0.14);
        }

        .resource-comment-form h2 {
            margin: 0 0 18px;
            color: #4b4b4b;
            font-size: 24px;
            font-weight: 500;
        }

        .login-prompt a {
            color: var(--brand-deep);
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .resource-hero,
            .resource-comments-panel,
            .comment-card {
                padding: 22px;
            }
        }

        @media (max-width: 600px) {
            .comment-date {
                width: 100%;
                margin-left: 0;
            }

            .resource-comment-form h2 {
                font-size: 22px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper page-wrapper--narrow resource-show-page">

        <div class="page-header">
            <div class="page-title-block">
                <p class="page-kicker">Bibliothèque</p>
                <h1>{{ $ressource->name_ressource }}</h1>
                <p class="page-subtitle">Consultez le détail de la ressource dans la même continuité visuelle que le reste du site.</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('ressources.index') }}" class="btn btn-outline">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M19 12H5M12 5l-7 7 7 7"/>
                    </svg>
                    Retour
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <section class="create-main resource-hero">
            <div class="info-grid resource-show-meta">
                <div class="info-item">
                    <p class="info-label">Type</p>
                    <p class="info-value">{{ $ressource->typeRessource->name_typeressource ?? '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Catégorie</p>
                    <p class="info-value">{{ $ressource->category->name_cat ?? '—' }}</p>
                </div>
                <div class="info-item">
                    <p class="info-label">Créée le</p>
                    <p class="info-value">{{ $ressource->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <div class="resource-show-content">
                <p class="section-title">Description</p>
                <p class="resource-richtext">{{ $ressource->description ?? 'Pas de description disponible.' }}</p>
            </div>
        </section>

        <section class="summary-card resource-comments-panel">
            <div class="resource-comments-header">
                <p class="section-title">Commentaires</p>
                <span class="count-badge">{{ $ressource->comments->count() }}</span>
            </div>

            @if($ressource->comments->isEmpty())
                <div class="comments-empty">
                    Aucun commentaire pour le moment. Soyez le premier !
                </div>
            @else
                <div class="comment-list">
                    @foreach($ressource->comments as $comment)
                        <article class="comment-card">
                            <div class="comment-header">
                                <div class="comment-avatar">
                                    {{ strtoupper(substr($comment->user->name ?? '?', 0, 1)) }}
                                </div>

                                <div class="comment-author-meta">
                                    <span class="comment-author-name">{{ $comment->user->name ?? 'Anonyme' }}</span>
                                    <span class="comment-author-role">Membre</span>
                                </div>

                                <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>

                            <p class="comment-text">{{ $comment->content }}</p>
                        </article>
                    @endforeach
                </div>
            @endif

            @auth
                <div class="resource-comment-form">
                    <h2>Laisser un commentaire</h2>

                    <form action="{{ route('ressources.comments.store', $ressource->id_ressource) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="content">Votre message</label>
                            <textarea id="content" name="content" rows="4" placeholder="Partagez votre avis..." required>{{ old('content') }}</textarea>
                        </div>

                        @error('content')
                            <p class="form-error">{{ $message }}</p>
                        @enderror

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <line x1="22" y1="2" x2="11" y2="13"/>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                </svg>
                                Envoyer
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="login-prompt">
                    <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un commentaire.
                </div>
            @endauth
        </section>

    </div>
@endsection
