@extends('backoffice.back')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Liste des Événements</h5>
            <div class="card-body">
                <a href="{{ route('evenements.create.admin') }}" class="btn btn-success mb-3">Créer un Nouvel Événement</a>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Jardin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($evenements as $evenement)
                                <tr>
                                    <td>{{ $evenement->nom }}</td>
                                    <td>{{ $evenement->description }}</td>
                                    <td>{{ $evenement->date }}</td>
                                    <td>{{ $evenement->jardin->nom }}</td>
                                    <td>
    <a href="{{ route('evenements.show', $evenement->id) }}" class="btn btn-info">Voir Détails</a>
</td>  <td>

                                        <div class="d-flex">
                                            <a href="{{ route('evenements.edit.admin', $evenement->id) }}" class="btn btn-primary me-2">
                                                <i class="bx bx-edit-alt me-1"></i> Modifier
                                            </a>
                                            <form action="{{ route('evenements.destroy.admin', $evenement->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bx bx-trash me-1"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
