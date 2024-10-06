@extends('backoffice.back')

@section('content')
<div class="container">
    <h1 class="mt-5">Liste des Jardins</h1>

    <a href="{{ route('gardens.create.admin') }}" class="btn btn-success mb-3">
        <i class="bx bx-plus-circle me-1"></i> Créer un Nouveau Jardin
    </a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
    @foreach ($jardins as $jardin)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5>{{ $jardin->nom }}</h5>
                    <span class="badge bg-success">Actif</span> <!-- Exemple de badge -->
                </div>
                <div class="card-body">
                    @if ($jardin->image)
                        <img src="{{ asset('storage/' . $jardin->image) }}" alt="Image du Jardin" class="img-fluid rounded mb-2" style="height: 200px; object-fit: cover; transition: transform .2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    @else
                        <div class="text-center text-muted">Pas d'image disponible</div>
                    @endif
                    <p class="mt-3"><strong>Description:</strong> {{ $jardin->description ?? 'Aucune description disponible' }}</p>
                    <p><i class="bx bx-map"></i><strong> Adresse:</strong> {{ $jardin->adresse ?? 'Aucune adresse disponible' }}</p>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('gardens.edit.admin', $jardin->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="bx bx-edit-alt"></i>
                    </a>
                    <form action="{{ route('gardens.destroy.admin', $jardin->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bx bx-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

</div>
@endsection
