@extends('layouts.app')

@section('title', $ressource->name_ressource)

@push('styles')
    {{-- Nunito + Lora already loaded via your global CSS --}}
    <style>
        /* ── Article page layout ─────────────────────────── */
        .article-page {
            max-width: 780px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem 4rem;
        }

        /* ── Back link ───────────────────────────────────── */
        .article-back {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-light);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 2rem;
            transition: color 0.18s;
        }
        .article-back:hover { color: var(--green-dark); }
        .article-back svg { transition: transform 0.18s; }
        .article-back:hover svg { transform: translateX(-3px); }

        /* ── Header ──────────────────────────────────────── */
        .article-header {
            margin-bottom: 2rem;
        }

        .article-header h1 {
            font-family: 'Lora', serif;
            font-size: clamp(1.6rem, 4vw, 2.4rem);
            font-weight: 600;
            color: var(--green-dark);
            line-height: 1.25;
            margin-bottom: 0.9rem;
        }

        .article-meta-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            background: var(--green-pale);
            color: var(--text-mid);
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.25rem 0.7rem;
            border-radius: 20px;
            border: 1px solid var(--border);
        }

        .meta-pill svg { color: var(--green-mid); flex-shrink: 0; }

        /* ── Content section ─────────────────────────────── */
        .article-content {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.75rem 2rem;
            box-shadow: 0 2px 12px var(--shadow);
            margin-bottom: 2.5rem;
            font-size: 0.975rem;
            line-height: 1.75;
            color: var(--text-dark);
        }

        /* ── Section divider ─────────────────────────────── */
        .section-divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .section-divider h2 {
            font-family: 'Lora', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--green-dark);
            white-space: nowrap;
        }

        .section-divider-line {
            flex: 1;
            height: 1px;
            background: var(--green-pale);
        }

        /* ── Comment card ────────────────────────────────── */
        .comment-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .comment-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1rem 1.25rem;
            box-shadow: 0 1px 6px var(--shadow);
            transition: box-shadow 0.18s;
        }

        .comment-card:hover {
            box-shadow: 0 4px 16px var(--shadow);
        }

        .comment-author-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.55rem;
        }

        .comment-avatar {
            width: 32px;
            height: 32px;
            background: var(--green-pale);
            border: 1.5px solid var(--green-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--green-dark);
        }

        .comment-author-name {
            font-weight: 700;
            font-size: 0.88rem;
            color: var(--text-dark);
        }

        .comment-date {
            margin-left: auto;
            font-size: 0.75rem;
            color: var(--text-light);
        }

        .comment-text {
            font-size: 0.9rem;
            line-height: 1.65;
            color: var(--text-mid);
            padding-left: calc(32px + 0.75rem);
        }

        /* ── Empty comments ──────────────────────────────── */
        .comments-empty {
            text-align: center;
            padding: 2.5rem 1rem;
            color: var(--text-light);
            background: var(--green-bg);
            border: 1.5px dashed var(--border);
            border-radius: 10px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            font-style: italic;
        }

        .comments-empty svg { margin-bottom: 0.6rem; opacity: 0.4; }

        /* ── Comment form ────────────────────────────────── */
        .comment-form-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 12px var(--shadow);
        }

        .comment-form-card h3 {
            font-family: 'Lora', serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--green-dark);
            margin-bottom: 1rem;
        }

        .comment-form-card textarea {
            width: 100%;
            padding: 0.7rem 0.9rem;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            font-family: 'Nunito', sans-serif;
            font-size: 0.9rem;
            color: var(--text-dark);
            background: var(--white);
            outline: none;
            resize: vertical;
            min-height: 100px;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .comment-form-card textarea:focus {
            border-color: var(--green-mid);
            box-shadow: 0 0 0 3px rgba(90, 158, 137, 0.15);
        }

        .comment-form-card textarea::placeholder { color: var(--text-light); }

        .comment-form-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 0.75rem;
        }

        /* ── Login prompt ────────────────────────────────── */
        .login-prompt {
            text-align: center;
            padding: 1.25rem;
            background: var(--green-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.88rem;
            color: var(--text-mid);
        }

        .login-prompt a {
            color: var(--green-dark);
            font-weight: 700;
            text-decoration: none;
        }

        .login-prompt a:hover { text-decoration: underline; }
    </style>
@endpush

@section('content')
    <div class="article-page">

        {{-- ── Back link ──────────────────────────────────── --}}
        <a href="{{ url()->previous() }}" class="article-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H5M12 5l-7 7 7 7"/>
            </svg>
            Retour
        </a>

        {{-- ── Header ─────────────────────────────────────── --}}
        <header class="article-header">
            <h1>{{ $ressource->name_ressource }}</h1>

            <div class="article-meta-pills">
                {{-- Type --}}
                <span class="meta-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h10M4 18h6"/>
                </svg>
                {{ $ressource->typeRessource->name_typeressource ?? '—' }}
            </span>

                {{-- Category --}}
                <span class="meta-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 7l9-4 9 4v10l-9 4-9-4V7z"/>
                </svg>
                {{ $ressource->category->name_cat ?? '—' }}
            </span>

                {{-- Date --}}
                <span class="meta-pill">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
                </svg>
                {{ $ressource->created_at->format('d/m/Y') }}
            </span>
            </div>
        </header>

        {{-- ── Description ─────────────────────────────────── --}}
        <div class="article-content">
            {{ $ressource->description ?? 'Pas de description disponible.' }}
        </div>

        {{-- ── Comments section ────────────────────────────── --}}
        <section class="comments">

            <div class="section-divider">
                <h2>
                    Commentaires
                    <span class="count-badge">{{ $ressource->comments->count() }}</span>
                </h2>
                <div class="section-divider-line"></div>
            </div>

            @if($ressource->comments->isEmpty())
                <div class="comments-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         style="display:block;margin:0 auto 0.6rem;">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    Aucun commentaire pour le moment. Soyez le premier !
                </div>
            @else
                <div class="comment-list">
                    @foreach($ressource->comments as $comment)
                        <div class="comment-card">
                            <div class="comment-author-row">
                                <div class="comment-avatar">
                                    {{ strtoupper(substr($comment->user->name ?? '?', 0, 1)) }}
                                </div>
                                <span class="comment-author-name">{{ $comment->user->name ?? 'Anonyme' }}</span>
                                <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="comment-text">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- ── Form / Login prompt ─────────────────────── --}}
            @auth
                <div class="comment-form-card">
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                             style="display:inline;vertical-align:middle;margin-right:0.35rem;">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        Laisser un commentaire
                    </h3>

                    <form action="{{ route('ressources.comments.store', $ressource->id_ressource) }}" method="POST">
                        @csrf

                        <textarea
                            name="content"
                            rows="3"
                            placeholder="Partagez votre avis..."
                            required
                        >{{ old('content') }}</textarea>

                        @error('content')
                        <p class="form-error">{{ $message }}</p>
                        @enderror

                        <div class="comment-form-footer">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
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
