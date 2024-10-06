<?php

namespace App\Http\Controllers;

use App\Models\Jardin;
use App\Models\Evenement;
use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Models\User;

class EvenementController extends Controller
{    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function show($id)
    {
        $evenement = Evenement::with('jardin')->findOrFail($id);
        $address = $evenement->jardin->adresse;

        // Journaliser l'adresse
        \Log::info('Jardin Address:', ['address' => $address]);

        // Utiliser l'adresse du jardin pour obtenir les données météo
        $city = $evenement->jardin->adresse; // Assurez-vous que c'est un format compatible avec l'API (par ex. "Paris, FR")
        
        // Obtenez la météo pour la localisation
        $weather = $this->weatherService->getWeatherByLocation($city);

        // Journaliser la réponse météo
        \Log::info('Weather Data:', $weather ?? ['status' => 'No weather data received', 'city' => $city]);

        // Vérifiez si les données météo sont présentes
        if (!$weather) {
            \Log::warning('Weather data is null for city:', ['city' => $city]);
        }

        // Récupérer les prévisions météo
        $forecast = $this->weatherService->getWeatherForecastByLocation($city);

        // Logique pour définir les messages en fonction des conditions météo
        $weatherAlert = null;
        $alternatives = null;
        $goodWeatherMessage = null;

        if ($weather && isset($weather['weather'][0]['main'])) {
            $weatherCondition = $weather['weather'][0]['main'];
            \Log::info('Weather Condition:', ['condition' => $weatherCondition]);
        
            if ($weatherCondition == 'Rain') {
                $weatherAlert = 'Il pleut actuellement, envisagez de reprogrammer l\'événement.';
                $alternatives = 'Vous pouvez proposer un événement en intérieur ou reprogrammer.';
            } elseif ($weatherCondition == 'Thunderstorm') {
                $weatherAlert = 'Des orages sont prévus, veuillez envisager une alternative.';
                $alternatives = 'L\'événement peut être reprogrammé ou déplacé à une date ultérieure.';
            } elseif ($weatherCondition == 'Clouds') {
                $weatherAlert = 'Le temps est nuageux. Bien qu\'il n\'y ait pas de pluie prévue, cela peut affecter l\'ambiance de l\'événement.';
                $alternatives = 'Envisagez des activités en intérieur ou préparez-vous à des changements de dernière minute.';
            }
             elseif (in_array($weather['weather'][0]['main'], ['Clear', 'Sunny', 'Fair'])) {
                $goodWeatherMessage = 'Il fait beau, l\'événement peut se dérouler comme prévu ! Profitez-en !';
            }
        } else {
            \Log::warning('Weather data is missing or does not contain main condition.');
        }
        
        return view('backoffice.evenements.show', compact('evenement', 'weather', 'forecast', 'weatherAlert', 'alternatives', 'goodWeatherMessage'));
    }
    public function frontDetaille($id)
    {
        $evenement = Evenement::with('jardin')->findOrFail($id);
        $address = $evenement->jardin->adresse;

        // Journaliser l'adresse
        \Log::info('Jardin Address:', ['address' => $address]);

        // Utiliser l'adresse du jardin pour obtenir les données météo
        $city = $evenement->jardin->adresse; // Assurez-vous que c'est un format compatible avec l'API (par ex. "Paris, FR")
        
        // Obtenez la météo pour la localisation
        $weather = $this->weatherService->getWeatherByLocation($city);

        // Journaliser la réponse météo
        \Log::info('Weather Data:', $weather ?? ['status' => 'No weather data received', 'city' => $city]);

        // Vérifiez si les données météo sont présentes
        if (!$weather) {
            \Log::warning('Weather data is null for city:', ['city' => $city]);
        }

        // Récupérer les prévisions météo
        $forecast = $this->weatherService->getWeatherForecastByLocation($city);

        // Logique pour définir les messages en fonction des conditions météo
        $weatherAlert = null;
        $alternatives = null;
        $goodWeatherMessage = null;

        if ($weather && isset($weather['weather'][0]['main'])) {
            $weatherCondition = $weather['weather'][0]['main'];
            \Log::info('Weather Condition:', ['condition' => $weatherCondition]);
        
            if ($weatherCondition == 'Rain') {
                $weatherAlert = 'Il pleut actuellement, envisagez de reprogrammer l\'événement.';
                $alternatives = 'Vous pouvez proposer un événement en intérieur ou reprogrammer.';
            } elseif ($weatherCondition == 'Thunderstorm') {
                $weatherAlert = 'Des orages sont prévus, veuillez envisager une alternative.';
                $alternatives = 'L\'événement peut être reprogrammé ou déplacé à une date ultérieure.';
            } elseif ($weatherCondition == 'Clouds') {
                $weatherAlert = 'Le temps est nuageux. Bien qu\'il n\'y ait pas de pluie prévue, cela peut affecter l\'ambiance de l\'événement.';
                $alternatives = 'Envisagez des activités en intérieur ou préparez-vous à des changements de dernière minute.';
            }
             elseif (in_array($weather['weather'][0]['main'], ['Clear', 'Sunny', 'Fair'])) {
                $goodWeatherMessage = 'Il fait beau, l\'événement peut se dérouler comme prévu ! Profitez-en !';
            }
        } else {
            \Log::warning('Weather data is missing or does not contain main condition.');
        }
        
        return view('evenements.show', compact('evenement', 'weather', 'forecast', 'weatherAlert', 'alternatives', 'goodWeatherMessage'));
    }




    // Fonction pour afficher les événements (front)
    public function index()
    {
        $evenements = Evenement::all();
        return view('evenements.index', compact('evenements'));
    }

    // Fonction pour afficher les événements (admin)
    public function indexAdmin()
    {
        $evenements = Evenement::all();
        return view('backoffice.evenements.index', compact('evenements'));
    }

    // Fonction pour créer un événement (front)
    public function create()
    {
        $jardins = Jardin::all();
        return view('evenements.create', compact('jardins'));
    }

    // Fonction pour créer un événement (admin)
    public function createAdmin()
    {
        $jardins = Jardin::all();
        return view('backoffice.evenements.create', compact('jardins'));
    }

    // Fonction pour stocker un événement (front)
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:3|max:255',
            'description' => 'required|nullable|min:10|string',
            'date' => 'required|date|after_or_equal:today',
            'jardin_id' => 'required|exists:jardins,id',
        ]);

        Evenement::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'date' => $request->date,
            'jardin_id' => $request->jardin_id,
            'user_id' => auth()->id(), // Associer l'utilisateur connecté
        ]);

        return redirect()->route('evenements.index')->with('success', 'Événement créé avec succès !');
    }

    // Fonction pour stocker un événement (admin)
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|min:3|max:255',
            'description' => 'nullable|min:10|string',
            'date' => 'required|date|after_or_equal:today',
            'jardin_id' => 'required|exists:jardins,id',
        ]);
    
        Evenement::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'date' => $request->date,
            'jardin_id' => $request->jardin_id,
            'user_id' => auth()->id(), // Associer l'utilisateur connecté
        ]);
    
        return redirect()->route('evenements.index.admin')->with('success', 'Événement créé avec succès dans le tableau de bord admin !');
    }
    

    // Fonction pour éditer un événement (admin)
    public function edit(Evenement $evenement)
    {
        if ($evenement->user_id !== auth()->id()) {
            return redirect()->route('evenements.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cet événement.');
        }
    
        $jardins = Jardin::all();
        return view('evenements.edit', compact('evenement', 'jardins'));
    }
    

    // Fonction pour mettre à jour un événement (admin)
    public function update(Request $request, Evenement $evenement)
    {
        if ($evenement->user_id !== auth()->id()) {
            return redirect()->route('evenements.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cet événement.');
        }
    
        $request->validate([
            'nom' => 'required|string|min:3|max:255',
            'description' => 'nullable|min:10|string',
            'date' => 'required|date',
            'jardin_id' => 'required|exists:jardins,id',
        ]);
    
        $evenement->update($request->all());
    
        return redirect()->route('evenements.index')->with('success', 'Événement mis à jour avec succès.');
    }
    public function editAdmin(Evenement $evenement)
    {
        $jardins = Jardin::all();
        return view('backoffice.evenements.edit', compact('evenement', 'jardins'));
    }
    public function updateAdmin(Request $request, Evenement $evenement)
    {
        $request->validate([
            'nom' => 'required|string|min:3|max:255',
            'description' => 'required|nullable|min:10|string',
            'date' => 'required|date',
            'jardin_id' => 'required|exists:jardins,id',
        ]);

        $evenement->update($request->all());


        return redirect()->route('evenements.index.admin')->with('success', 'Evenemnt mis à jour avec succès dans le tableau de bord admin !');
    }
    // Fonction pour supprimer un événement (admin)
    public function destroy(Evenement $evenement)
    {
        if ($evenement->user_id !== auth()->id()) {
            return redirect()->route('evenements.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer cet événement.');
        }
    
        $evenement->delete();
    
        return redirect()->route('evenements.index')->with('success', 'Événement supprimé avec succès.');
    }
    
    public function destroyAdmin(Evenement $evenement)
    {
        $evenement->delete();

        return redirect()->route('evenements.index.admin')->with('success', 'Événement supprimé avec succès dans le tableau de bord admin !');
    }
    public function calendrierAdmin()
    {
        $evenements = Evenement::with('jardin')->get()->map(function($evenement) {
            return [
                'id' => $evenement->id,
                'title' => $evenement->nom,
                'start' => $evenement->date,
                'description' => $evenement->description,
                'adresse' => $evenement->jardin->adresse // Inclure l'adresse du jardin associé
            ];
        });
    
        return view('backoffice.evenements.calendar', compact('evenements'));
    }
    
    
    
}
