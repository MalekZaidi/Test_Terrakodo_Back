@extends('backoffice.back')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header">Liste des Plantes</h5>
        <div class="card-body">
            <a href="{{ route('plants.create.admin') }}" class="btn btn-success mb-3">Créer une Nouvelle Plante</a>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Nom Commun</th>
                        <th>Nom Scientifique</th>
                        <th>Origine</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach ($plants as $plant)
                    <tr>
                        <td>{{ $plant->common_name }}</td>
                        <td>{{ $plant->scientific_name }}</td>
                        <td>{{ $plant->origin }}</td>
                        <td>{{ $plant->description }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('plants.edit.admin', $plant->id) }}" class="btn btn-primary me-2">
                                    <i class="bx bx-edit-alt me-1"></i> Modifier
                                </a>
                                <form action="{{ route('plants.destroy.admin', $plant->id) }}" method="POST" class="d-inline">
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