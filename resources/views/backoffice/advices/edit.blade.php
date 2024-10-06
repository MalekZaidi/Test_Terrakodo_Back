@extends('backoffice.back')

@section('title', 'Edit Advice')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Edit Advice</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Advice</h5>
                    <small class="text-muted float-end">Edit the advice details below</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.advices.update', $advice->id) }}" method="POST">
                        @csrf
                        @method('PATCH')    
                        <div class="mb-3">
                            <label class="form-label" for="content">Advice Content</label>
                            <textarea id="content" name="content" class="form-control" placeholder="Enter advice here..." required>{{ old('content', $advice->content) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="plant_id">Select Plant</label>
                            <select id="plant_id" name="plant_id" class="form-control" required>
                                <option value="">-- Select a Plant --</option>
                                @foreach ($plants as $plant)
                                    <option value="{{ $plant->id }}" {{ (old('plant_id', $advice->plant_id) == $plant->id) ? 'selected' : '' }}>
                                        {{ $plant->common_name }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Advice</button>
                        <a href="{{ route('admin.advices.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
