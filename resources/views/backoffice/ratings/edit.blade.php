@extends('backoffice.back')

@section('title', 'Edit Rating')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Edit Rating</h4>

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Rating</h5>
                    <small class="text-muted float-end">Edit the rating details below</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ratings.update', $rating->id) }}" method="POST">
                        @csrf
                        @method('PATCH')    
                        
                        <!-- Score Field -->
                        <div class="mb-3">
                            <label class="form-label" for="score">Rating Score</label>
                            <select id="score" name="score" class="form-control" required>
                                <option value="">-- Select a Score --</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ (old('score', $rating->score) == $i) ? 'selected' : '' }}>
                                        {{ $i }} 
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Comment Field -->
                        <div class="mb-3">
                            <label class="form-label" for="comment">Comment</label>
                            <textarea id="comment" name="comment" class="form-control" placeholder="Enter comment here..." maxlength="255">{{ old('comment', $rating->comment) }}</textarea>
                        </div>

                        <!-- Advice Related to the Rating (optional, just for reference) -->
                        <div class="mb-3">
                            <label class="form-label" for="advice_id">Advice Related to Rating</label>
                            <select id="advice_id" name="advice_id" class="form-control" disabled>
                                @foreach ($advices as $advice)
                                    <option value="{{ $advice->id }}" {{ (old('advice_id', $rating->advice_id) == $advice->id) ? 'selected' : '' }}>
                                        {{ $advice->content }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Rating</button>
                        <a href="{{ route('admin.ratings.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
