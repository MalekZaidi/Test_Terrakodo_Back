<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = '89766ae403da729b34f6670debadb02f';
    }

    public function getWeatherByLocation($city)
    {
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$this->apiKey}";
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url, [
            'verify' => false, // Ignorer la vérification SSL
        ]);

        $weatherData = json_decode($response->getBody(), true);

        // Conversion de la température de Kelvin à Celsius
        if (isset($weatherData['main']['temp'])) {
            $weatherData['main']['temp'] = $this->convertKelvinToCelsius($weatherData['main']['temp']);
        }

        return $weatherData;
    }

    public function getWeatherForecastByLocation($city)
    {
        $url = "https://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$this->apiKey}";
        $client = new \GuzzleHttp\Client();
        $response = $client->get($url, [
            'verify' => false, // Ignorer la vérification SSL
        ]);

        $forecastData = json_decode($response->getBody(), true);

        // Conversion de toutes les températures de Kelvin à Celsius
        foreach ($forecastData['list'] as &$forecast) {
            if (isset($forecast['main']['temp'])) {
                $forecast['main']['temp'] = $this->convertKelvinToCelsius($forecast['main']['temp']);
            }
        }

        return $forecastData;
    }

    // Fonction utilitaire pour convertir Kelvin en Celsius
    private function convertKelvinToCelsius($kelvinTemp)
    {
        return $kelvinTemp - 273.15;
    }
}