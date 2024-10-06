@extends('layouts.app')

@section('content')

    <section class="team-15 team section" id="team">
        <!-- Section Title -->
        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2></h2>
            <p>List of plants</p>
        </div><!-- End Section Title -->

        @if ($plants->isEmpty())
            <p>No plants available.</p>
        @else
            <div class="container">
                <div class="row">
                    @foreach ($plants as $index => $plant)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="person">
                                <figure>
                                    <a href="{{ url('plants/details/' . $plant->id) }}">
                                        <img src="{{ asset('/img/plant.png') }}" alt="Image" class="img-fluid">
                                    </a>
                                    
                                </figure>
                                <div class="person-contents">
                                    <h3>{{ $plant->common_name }}</h3>
                                    <span class="position">({{ $plant->scientific_name }})</span>
                                </div>
                            </div>
                        </div>

                        <!-- Close and start a new row after every 3 plants -->
                        @if (($index + 1) % 3 == 0)
                            </div><div class="row">
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </section>

@endsection
