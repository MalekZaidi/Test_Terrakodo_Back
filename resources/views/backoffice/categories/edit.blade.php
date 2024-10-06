@extends('backoffice.back')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Modifier la Catégorie</h5>
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

                    <form action="{{ route('categories.update.admin', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom de la Catégorie <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                            <small class="form-text text-muted">Doit contenir au moins 3 caractères.</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4">{{ $category->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Mettre à Jour</button>
                        <a href="{{ route('categories.index.admin') }}" class="btn btn-secondary">Retour à la Liste</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection