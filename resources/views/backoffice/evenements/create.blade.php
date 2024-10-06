@extends('backoffice.back')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Créer un Événement</h5>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('evenements.store.admin') }}" method="POST" class="mt-4">
                            @csrf

                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom de l'Événement <span class="text-danger">*</span></label>
                                <input type="text" name="nom" id="nom" class="form-control" required>
                                <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" class="form-control"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" id="date" class="form-control" required>
                                <small class="form-text text-muted">Doit être aujourd'hui ou une date future.</small>
                            </div>

                            <div class="mb-3">
                                <label for="jardin_id" class="form-label">Choisir un Jardin <span class="text-danger">*</span></label>
                                <select name="jardin_id" id="jardin_id" class="form-select" required>
                                    <option value="">Sélectionnez un jardin</option>
                                    @foreach ($jardins as $jardin)
                                        <option value="{{ $jardin->id }}">{{ $jardin->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Créer</button>
                            <a href="{{ route('evenements.index.admin') }}" class="btn btn-secondary">Retour à la Liste</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
