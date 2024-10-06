    @extends('layouts.app')

    @section('content')
    <section id="contact" class="contact section">
        <div class="container aos-init aos-animate" data-aos="fade">
            <div class="row gy-5 gx-lg-5">
                <div class="col-lg-4">
                    <div class="info">
                        <!-- Display plant image -->
                        <img src="{{ asset('/img/plant.png') }}" alt="Image" class="img-fluid">
                        <!-- Display plant details -->
                        <h2>{{ $plant->common_name }}</h2>
                        <h2>{{ $plant->scientific_name }}</h2>
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- Create form for user to add advice -->
                    <section id="blog-comments" class="blog-comments section mt-5">
                        <div class="container">
                            <h4 class="comments-count">{{ $advices->count() }} Advices</h4>

                            @foreach ($advices as $advice)
                            <div id="comment-{{ $advice->id }}" class="comment">
                            <div class="d-flex position-relative">
    <div class="comment-img">
        <img src="{{ asset('assets/img/user-placeholder.png') }}" alt="">
    </div>
    <div>
        <h5>
            <a href="">{{ $advice->user->name }}</a>
            <button type="button" class="btn btn-link" 
    @if (Auth::id() === $advice->user_id) 
        disabled 
    @endif 
    data-bs-toggle="modal" 
    data-bs-target="#ratingModal{{ $advice->id }}">
    Rate
</button>

        </h5>
        <time datetime="{{ $advice->created_at }}">{{ $advice->created_at->format('d M, Y') }}</time>
        <p>{{ $advice->content }}</p>

        <div class="average-rating position-absolute top-0 end-0 me-2 mt-2">
            <span class="text-warning">
                @if ($advice->average_rating)
                    @for ($i = 0; $i < floor($advice->average_rating); $i++)
                        ★
                    @endfor
                    @if ($advice->average_rating - floor($advice->average_rating) >= 0.5)
                        ★
                    @endif
                    @for ($i = 0; $i < (5 - ceil($advice->average_rating)); $i++)
                        ☆
                    @endfor
                @else
                    No ratings yet
                @endif
            </span>
        </div>
    </div>
</div>

    </div>

                            
<div class="modal fade" id="ratingModal{{ $advice->id }}" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel{{ $advice->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ratingModalLabel{{ $advice->id }}">Rate Advice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
    <p>To help us get better, please rate this advice.</p>
    <form action="{{ route('ratings.store') }}" method="POST">
        @csrf
        <input type="hidden" name="advice_id" value="{{ $advice->id }}">
        
        <!-- Star Rating -->
        <div class="rate">
            @php
                // Get the user's existing rating if available
                $existingRating = $advice->ratings()->where('user_id', Auth::id())->first();
            @endphp
            
            <input type="radio" id="star5-{{ $advice->id }}" name="score" value="5" required @if($existingRating && $existingRating->score == 5) checked @endif/>
            <label for="star5-{{ $advice->id }}" title="5 stars">5 stars</label>
            <input type="radio" id="star4-{{ $advice->id }}" name="score" value="4" @if($existingRating && $existingRating->score == 4) checked @endif/>
            <label for="star4-{{ $advice->id }}" title="4 stars">4 stars</label>
            <input type="radio" id="star3-{{ $advice->id }}" name="score" value="3" @if($existingRating && $existingRating->score == 3) checked @endif/>
            <label for="star3-{{ $advice->id }}" title="3 stars">3 stars</label>
            <input type="radio" id="star2-{{ $advice->id }}" name="score" value="2" @if($existingRating && $existingRating->score == 2) checked @endif/>
            <label for="star2-{{ $advice->id }}" title="2 stars">2 stars</label>
            <input type="radio" id="star1-{{ $advice->id }}" name="score" value="1" @if($existingRating && $existingRating->score == 1) checked @endif/>
            <label for="star1-{{ $advice->id }}" title="1 star">1 star</label>
        </div>
        
        <div class="form-group">
            <textarea name="comment" class="form-control" placeholder="Your comment (optional)">{{ $existingRating->comment ?? '' }}</textarea>
        </div>
        
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

        </div>
    </div>
</div>


                            @endforeach
                        </div>
                    </section>

                    <section id="comment-form" class="comment-form section">
                        <div class="container">
                        <form action="{{ route('advice.store') }}" method="POST">
        @csrf
        <h4>Help with your advice</h4>
        <input type="hidden" name="plant_id" value="{{ $plant->id }}">
        <div class="row">
            <div class="col form-group">
                <textarea name="content" class="form-control" placeholder="Your advice" required></textarea>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Post it</button>
        </div>
    </form>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </section>
    @endsection

    @push('styles')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position: absolute;
            display: none;
        }
        .rate:not(:checked) > label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }
        .star-rating-complete {
            color: #c59b08;
        }
        .rating-container .form-control:hover, .rating-container .form-control:focus {
            background: #fff;
            border: 1px solid #ced4da;
        }
        .rating-container textarea:focus, .rating-container input:focus {
            color: #000;
        }



        .average-rating {
    font-size: 16px; /* Adjust size as needed */
    color: #ffc700; /* Gold color for the star rating */
    margin-top: 10px;
    margin-right:0px /* Spacing from the advice content */
}


.text-warning {
    color: #ffc107; /* Bootstrap warning color for stars */
}
    </style>


    @endpush
