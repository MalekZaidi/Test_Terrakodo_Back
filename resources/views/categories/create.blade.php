@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">Créer une Catégorie</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom de la Catégorie <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required>
            <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            <small class="form-text text-muted">Fournissez une description de la catégorie.</small>
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Retour à la Liste</a>
    </form>
</div>
@endsection