@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">Liste des Catégories</h1>

    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Créer une Nouvelle Catégorie</a>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            Catégories
        </div>
        <ul class="list-group list-group-flush">
            @foreach ($categories as $category)
            <li class="list-group-item">
                <h5>{{ $category->name }}</h5>
                <p><strong>Description:</strong> {{ $category->description ?? 'Aucune description disponible' }}</p>
                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE') <!-- Indique que cette requête doit être traitée comme une suppression -->
                    <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection