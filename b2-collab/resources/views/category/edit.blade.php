<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la catégorie</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/category.css') }}">
</head>
<body>

<div class="page-wrapper">

    <div class="page-header">
        <h1>Modifier la catégorie</h1>
        <a href="{{ route('category.index') }}" class="btn btn-outline">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            Retour
        </a>
    </div>

    <div class="form-card">

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('category.update', $category->id_cat) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name_cat">Nom de la catégorie</label>

                <input type="text"
                       id="name_cat"
                       name="name_cat"
                       value="{{ old('name_cat', $category->name_cat) }}"
                       required>

                @error('name_cat')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Modifier la catégorie
                </button>
            </div>
        </form>
    </div>

</div>

</body>
</html>
