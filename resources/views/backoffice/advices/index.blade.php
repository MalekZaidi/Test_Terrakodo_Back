@extends('backoffice.back')

@section('title', 'Home Page')

@section('content')


<div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4>
<div class="card">
    <h5 class="card-header">List of Advices</h5>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Advice Content</th>
                    <th>Plant</th>
                    <th>User</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($advices as $advice)
                <tr>
                    <td>{{ $advice->content }}</td>
                    <td>{{ $advice->plant->common_name ?? 'N/A' }}</td> <!-- Assuming 'name' is an attribute in the Plant model -->
                    <td>{{ $advice->user->name ?? 'Anonymous' }}</td> <!-- Assuming 'name' is an attribute in the User model -->
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.advices.edit', $advice->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                <form action="{{ route('admin.advices.destroy', $advice->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this advice?');">
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
