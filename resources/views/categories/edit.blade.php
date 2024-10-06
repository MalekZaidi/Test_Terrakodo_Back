@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la Catégorie</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            <small class="form-text text-muted">Veuillez entrer le nom de la catégorie.</small>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $category->description) }}</textarea>
            <small class="form-text text-muted">Veuillez entrer une description de la catégorie.</small>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Retour à la Liste</a>
    </form>
</div>
@endsection