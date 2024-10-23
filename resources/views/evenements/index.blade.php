@extends('layouts.app')

@section('content')
<style>/* Style global pour les boutons */
.btn {
    padding: 12px 20px;
    border-radius: 25px;
    border: none;
    transition: all 0.3s ease-in-out;
    font-size: 16px;
    font-weight: 600;
}

/* Bouton primaire */
.btn-primary {
    background-color: #28a745;
    color: white;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-primary:hover {
    background-color: #218838;
    transform: scale(1.05);
}

/* Bouton d'information */
.btn-info {
    background-color: #17a2b8;
    color: white;
}

.btn-info:hover {
    background-color: #138496;
}

/* Bouton de modification (warning) */
.btn-warning {
    background-color: #ffc107;
    color: white;
}

.btn-warning:hover {
    background-color: #e0a800;
}

/* Bouton de suppression (danger) */
.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}

/* Ajout d’un léger effet d'ombre lors du survol */
.btn:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    cursor: pointer;
}
</style>
<section class="team-15 team section" id="team">
    <!-- Titre de la section -->
    <div class="container section-title aos-init aos-animate" data-aos="fade-up">
        <h2>Liste des Événements</h2>
        <p>Découvrez les événements disponibles</p>
        <!-- Bouton pour créer un événement -->
        <a href="{{ route('evenements.create') }}" class="btn btn-primary">Créer un Événement</a>
    </div>

    @if ($evenements->isEmpty())
        <p>Aucun événement disponible.</p>
    @else
        <div class="container">
            <div class="row">
                @foreach ($evenements as $index => $evenement)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="person">
                            <figure>
                               
                                    <img src="{{ $evenement->jardin->image ? asset('storage/' . $evenement->jardin->image) : asset('/img/default_event.png') }}" alt="Image de l'événement" class="img-fluid">

                            </figure>
                            <div class="person-contents">
                                <h3>{{ $evenement->nom }}</h3>
                                <p class="position"><strong>Date:</strong> {{ \Carbon\Carbon::parse($evenement->date)->format('d M Y') }}</p>
                                <p><strong>Jardin:</strong> {{ $evenement->jardin->nom }}</p>
                                <p>{{ Str::limit($evenement->description, 100) }}</p>

                                <!-- Vérifier si l'utilisateur est le créateur de l'événement -->
                                @if ($evenement->user_id === auth()->id())
                                <a href="{{ route('evenements.frontDetaille', $evenement->id) }}" class="btn btn-info">Voir Détails</a>

                                 <div class="d-flex">
                                        <a href="{{ route('evenements.edit', $evenement->id) }}" class="btn btn-warning me-2">Modifier</a>
                                        <form action="{{ route('evenements.destroy', $evenement->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Fermer et démarrer une nouvelle rangée après chaque groupe de 3 événements -->
                    @if (($index + 1) % 3 == 0)
                        </div><div class="row">
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</section>

@endsection
