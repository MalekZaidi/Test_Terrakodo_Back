@extends('backoffice.back')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <h5 class="card-header">Modifier le Jardin</h5>
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

                        <form action="{{ route('gardens.update.admin', $jardin->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            @method('PUT') <!-- Indique que cette requête doit être traitée comme une mise à jour -->

                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom du Jardin<span class="text-danger">*</span></label>
                                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $jardin->nom) }}" required>
                                <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" required>{{ old('description', $jardin->description) }}</textarea>
                                <small class="form-text text-muted">Doit contenir au moins 10 caractères.</small>
                            </div>

                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse<span class="text-danger">*</span></label>
                                <input type="text" name="adresse" id="adresse" class="form-control" value="{{ old('adresse', $jardin->adresse) }}" required>
                                <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
                            </div>
                            <div class="form-group">
        <label for="image">Image du Jardin</label>
        <input type="file" name="image" class="form-control" id="image">
    </div>
                            <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                            <a href="{{ route('gardens.index.admin') }}" class="btn btn-secondary">Retour à la Liste</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
