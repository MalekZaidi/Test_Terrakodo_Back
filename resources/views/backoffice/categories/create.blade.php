@extends('backoffice.back')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Créer une Catégorie</h5>
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

                    <form action="{{ route('categories.store.admin') }}" method="POST" class="mt-4">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de la Catégorie <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Créer</button>
                        <a href="{{ route('categories.index.admin') }}" class="btn btn-secondary">Retour à la Liste</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection