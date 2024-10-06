@extends('layouts.app')

@section('content') <style>
        .container {
            text-align: right;
            background-color: lightgrey;
            padding: 20px;
        }
        .right-align {
            display: inline-block;
            width: 200px;
            height: 100px;
            background-color: lightblue;
        }
    </style>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Event Details Card -->
        <div class="card mb-4">
            <h5 class="card-header">Détails de l'Événement</h5>
            <div class="card-body">
                <!-- Event Name and Description -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <h3>{{ $evenement->nom }}</h3>
                        <p>{{ $evenement->description }}</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <h5><i class="bx bx-calendar"></i> Date: {{ $evenement->date }}</h5>
                        <h5><i class="bx bx-leaf"></i> Jardin: {{ $evenement->jardin->nom }}</h5>
                        <h5><i class="bx bx-map"></i> Adresse: {{ $evenement->jardin->adresse }}</h5>
                    </div>
                </div>

                <!-- Weather Widget and Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><i class="bx bx-cloud"></i> Météo actuelle à {{ $evenement->jardin->adresse }} :</h5>
                        <div id="openweathermap-widget-11"></div>
                        <script src='//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/d3.min.js'></script>
                        <script>
                            window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];
                            window.myWidgetParam.push({
                                id: 11,
                                cityid: '2464461', // Remplacez par l'ID correct si nécessaire
                                appid: '89766ae403da729b34f6670debadb02f',
                                units: 'metric',
                                containerid: 'openweathermap-widget-11',
                            });
                            (function() {
                                var script = document.createElement('script');
                                script.async = true;
                                script.charset = "utf-8";
                                script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";
                                var s = document.getElementsByTagName('script')[0];
                                s.parentNode.insertBefore(script, s);
                            })();
                        </script>
                    </div>
                <!-- Weather Alerts -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        @if ($weatherAlert)
                            <div class="alert alert-warning mb-3">
                                <i class="bx bx-error"></i> <strong>Alerte :</strong> {{ $weatherAlert }}
                            </div>
                        @endif

                        @if ($alternatives)
                            <div class="alert alert-info mb-3">
                                <i class="bx bx-info-circle"></i> <strong>Suggestion :</strong> {{ $alternatives }}
                            </div>
                        @endif
                        
                        @if ($goodWeatherMessage)
                            <div class="alert alert-success mb-3">
                                <i class="bx bx-sun"></i> <strong>Info :</strong> {{ $goodWeatherMessage }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Weather Forecast -->
                @if(isset($forecast))
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5><i class="bx bx-calendar-alt"></i> Prévisions météo pour le {{ $evenement->date }} :</h5>
                            @foreach($forecast['list'] as $day)
                                @if(\Carbon\Carbon::parse($day['dt_txt'])->toDateString() === $evenement->date)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <p><strong>{{ \Carbon\Carbon::parse($day['dt_txt'])->format('d M Y H:i') }}</strong> :</p>
                                            <p>Température: <strong>{{ $day['main']['temp'] }}°C</strong></p>
                                            <p>Météo: <strong>{{ $day['weather'][0]['description'] }}</strong></p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Event Actions -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('evenements.edit', $evenement->id) }}" class="btn btn-primary me-2">
                        <i class="bx bx-edit-alt"></i> Modifier
                    </a>
                    <form action="{{ route('evenements.destroy', $evenement->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bx bx-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
@endsection
