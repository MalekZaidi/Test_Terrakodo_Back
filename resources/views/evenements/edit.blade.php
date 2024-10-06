@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Modifier l'Événement</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('evenements.update', $evenement->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nom" class="form-label">Nom de l'Événement<span class="text-danger">*</span></label>
                <input type="text" name="nom" id="nom" class="form-control" value="{{ $evenement->nom }}" required>
                <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ $evenement->description }}</textarea>
                <small class="form-text text-muted">Doit contenir au moins 10 caractères.</small>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" value="{{ $evenement->date }}" required>
            </div>

            <div class="mb-3">
                <label for="jardin_id" class="form-label">Choisir un Jardin</label>
                <select name="jardin_id" id="jardin_id" class="form-select" required>
                    <option value="">Sélectionnez un jardin</option>
                    @foreach ($jardins as $jardin)
                        <option value="{{ $jardin->id }}" {{ $jardin->id == $evenement->jardin_id ? 'selected' : '' }}>
                            {{ $jardin->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à Jour</button>
            <a href="{{ route('evenements.index') }}" class="btn btn-secondary">Retour à la Liste</a>
        </form>
    </div>
@endsection
