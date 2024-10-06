@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la Plante</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('plants.update', $plant->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT') <!-- Indique que cette requête doit être traitée comme une mise à jour -->

        <div class="mb-3">
            <label for="scientific_name" class="form-label">Nom Scientifique <span class="text-danger">*</span></label>
            <input type="text" name="scientific_name" id="scientific_name" class="form-control" value="{{ old('scientific_name', $plant->scientific_name) }}" required>
            <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
        </div>

        <div class="mb-3">
            <label for="common_name" class="form-label">Nom Commun <span class="text-danger">*</span></label>
            <input type="text" name="common_name" id="common_name" class="form-control" value="{{ old('common_name', $plant->common_name) }}" required>
            <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
        </div>

        <div class="mb-3">
            <label for="origin" class="form-label">Origine <span class="text-danger">*</span></label>
            <input type="text" name="origin" id="origin" class="form-control" value="{{ old('origin', $plant->origin) }}" required>
            <small class="form-text text-muted">Indiquez l'origine de la plante.</small>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $plant->description) }}</textarea>
            <small class="form-text text-muted">Fournissez une description de la plante.</small>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
        <a href="{{ route('plants.index') }}" class="btn btn-secondary">Retour à la Liste</a>
    </form>
</div>
@endsection