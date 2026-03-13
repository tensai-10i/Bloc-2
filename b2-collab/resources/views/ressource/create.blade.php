<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle ressource</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ressource.css') }}">
</head>
<body>

<div class="page-wrapper">

    <div class="page-header">
        <h1>Nouvelle ressource</h1>
        <a href="{{ route('ressources.index') }}" class="btn btn-outline">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Retour
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('ressources.store') }}">
        @csrf

        <div class="create-grid">

            {{-- ── Colonne gauche : champs ── --}}
            <div class="create-main">

                <p class="section-title">Informations de la ressource</p>

                <div class="form-group">
                    <label for="name_ressource">Nom de la ressource</label>
                    <input type="text" id="name_ressource" name="name_ressource"
                           value="{{ old('name_ressource') }}"
                           placeholder="Ex : Guide de démarrage"
                           required
                           oninput="updatePreview(this.value)">
                    @error('name_ressource')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ──
                <div class="form-group">
                    <label for="id_category">Catégorie</label>
                    <select id="id_category" name="id_category">
                        <option value="">— Sélectionner une catégorie —</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id_category }}"
                                {{ old('id_category') == $category->id_category ? 'selected' : '' }}>
                                {{ $category->name_category }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_category')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
── --}}
                <div class="form-group">
                    <label for="description">Description <span class="text-muted">(optionnel)</span></label>
                    <textarea id="description" name="description" placeholder="Décrivez cette ressource…">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                        Créer la ressource
                    </button>
                    <a href="{{ route('ressources.index') }}" class="btn btn-outline">Annuler</a>
                </div>
            </div>

        </div>
    </form>

</div>

<script>
    // Aperçu nom en temps réel
    function updatePreview(val) {
        const el = document.getElementById('preview-name');
        el.innerHTML = val.trim()
            ? val
            : '<span class="preview-placeholder">Nom de la ressource…</span>';
    }

    // Aperçu date en temps réel
    document.getElementById('creation_date').addEventListener('change', function () {
        const [y, m, d] = this.value.split('-');
        document.getElementById('preview-date').textContent = this.value ? `${d}/${m}/${y}` : '';
        document.getElementById('recap-date').textContent = this.value ? `${d}/${m}/${y}` : '—';
    });

    // Recap catégorie en temps réel
    document.getElementById('id_category').addEventListener('change', function () {
        const label = this.options[this.selectedIndex].text;
        document.getElementById('recap-category').textContent =
            this.value ? label : '—';
    });

    // Init date preview
    const dateInput = document.getElementById('creation_date');
    if (dateInput.value) {
        const [y, m, d] = dateInput.value.split('-');
        document.getElementById('preview-date').textContent = `${d}/${m}/${y}`;
    }
</script>

</body>
</html>
