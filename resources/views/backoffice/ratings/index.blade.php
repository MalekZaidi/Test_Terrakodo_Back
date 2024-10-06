@extends('backoffice.back')

@section('title', 'Ratings List')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Ratings</h4>

    <div class="card">
        <h5 class="card-header">List of Ratings</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Score</th>
                        <th>Advice Content</th>
                        <th>User</th>
                        <th>Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach ($ratings as $rating)
                    <tr>
                        <td>{{ $rating->score }}</td>
                        <td>{{ $rating->advice->content ?? 'N/A' }}</td> <!-- Showing the related advice content -->
                        <td>{{ $rating->user->name ?? 'Anonymous' }}</td> <!-- Showing the user who gave the rating -->
                        <td>{{ $rating->comment ?? 'No comment' }}</td> <!-- Showing the rating comment -->
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.ratings.edit', $rating->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this rating?');">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
