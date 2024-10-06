@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mt-5">Liste des Jardins</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bootstrap Carousel with Dark Theme -->
    <div id="gardensCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
        <!-- Indicateurs -->
        <div class="carousel-indicators">
            @foreach ($jardins as $index => $jardin)
                <button type="button" data-bs-target="#gardensCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>

        <!-- Contenu du carrousel -->
        <div class="carousel-inner">
            @foreach ($jardins as $index => $jardin)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="row g-0 shadow-lg">
                    <!-- Image du jardin -->
                    <div class="col-md-6">
                        @if ($jardin->image)
                            <img src="{{ asset('storage/' . $jardin->image) }}" class="d-block w-100 img-fluid rounded" alt="Image du Jardin" style="object-fit: cover; height: 400px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        @else
                            <img src="https://via.placeholder.com/400" class="d-block w-100 img-fluid rounded" alt="Aucune image disponible" style="object-fit: cover; height: 400px;">
                        @endif
                    </div>

                    <!-- Détails du jardin -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="card bg-dark text-white border-0 p-4" style="background-color: rgba(0, 0, 0, 0.7);">
                            <div class="card-body">
                                <h3 class="card-title">{{ $jardin->nom }}</h3>
                                <p class="card-text"><strong>Description:</strong> {{ $jardin->description ?? 'Aucune description disponible' }}</p>
                                <p class="card-text"><strong>Adresse:</strong> {{ $jardin->adresse ?? 'Aucune adresse disponible' }}</p>
                                <p class="card-text"><strong>Surface:</strong> {{ $jardin->surface ?? 'Non spécifié' }} m²</p>
                                <p class="card-text"><strong>Créé le:</strong> {{ $jardin->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Contrôles de navigation -->
        <a class="carousel-control-prev" href="#gardensCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </a>
        <a class="carousel-control-next" href="#gardensCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </a>
    </div>
</div>
@endsection
