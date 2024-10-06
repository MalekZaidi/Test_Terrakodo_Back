<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Jardin;
use Illuminate\Http\Request;

class JardinController extends Controller
{
    // Fonction pour afficher les jardins (front)
    public function index()
    {
        $jardins = Jardin::all();
        return view('jardins.index', compact('jardins'));
    }

    // Fonction pour afficher les jardins (admin)
    public function indexAdmin()
    {
        $jardins = Jardin::all();
        return view('backoffice.jardins.index', compact('jardins'));
    }

    // Fonction pour créer un jardin (front)
    public function create()
    {
        return view('jardins.create');
    }

    // Fonction pour créer un jardin (admin)
    public function createAdmin()
    {
        return view('backoffice.jardins.create');
    }

    // Fonction pour stocker un jardin (front)
    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required',
        'adresse' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Valider l'image
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        // Stocker l'image dans le dossier public (vous pouvez choisir un autre endroit)
        $imagePath = $request->file('image')->store('jardins', 'public');
    }

    Jardin::create([
        'nom' => $request->nom,
        'description' => $request->description,
        'adresse' => $request->adresse,
        'image' => $imagePath, // Stocker le chemin de l'image dans la base de données
    ]);

    return redirect()->route('gardens.index')->with('success', 'Jardin créé avec succès.');
}

    // Fonction pour stocker un jardin (admin)
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
            'adresse' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Valider l'image
        ]);
    
        $imagePath = null;
    
        if ($request->hasFile('image')) {
            // Stocker l'image dans le dossier public (vous pouvez choisir un autre endroit)
            $imagePath = $request->file('image')->store('jardins', 'public');
        }
    
        Jardin::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'adresse' => $request->adresse,
            'image' => $imagePath, 
        ]);
        return redirect()->route('gardens.index.admin')->with('success', 'Jardin créé avec succès dans le tableau de bord admin !');
    }

    // Fonction pour afficher un jardin (front)
    public function show(Jardin $jardin)
    {
        return view('jardins.show', compact('jardin'));
    }

    // Fonction pour supprimer un jardin (front)
    public function destroy(Jardin $jardin)
    {
        $jardin->delete();
        return redirect()->route('gardens.index')->with('success', 'Jardin supprimé avec succès !');
    }

    // Fonction pour supprimer un jardin (admin)
    public function destroyAdmin(Jardin $jardin)
    {
        $jardin->delete();
        return redirect()->route('gardens.index.admin')->with('success', 'Jardin supprimé avec succès dans le tableau de bord admin !');
    }

    // Fonction pour éditer un jardin (front)
    public function edit(Jardin $jardin)
    {
        return view('jardins.edit', compact('jardin'));
    }

    // Fonction pour éditer un jardin (admin)
    public function editAdmin(Jardin $jardin)
    {
        return view('backoffice.jardins.edit', compact('jardin'));
    }

    // Fonction pour mettre à jour un jardin (front)
    public function update(Request $request, Jardin $jardin)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
            'adresse' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($jardin->image) {
                Storage::disk('public')->delete($jardin->image); // Utilisation de Storage
            }

            // Stocker la nouvelle image
            $imagePath = $request->file('image')->store('jardins', 'public');
            $jardin->image = $imagePath;
        }

        $jardin->update($request->all());

        return redirect()->route('gardens.index.admin')->with('success', 'Jardin mis à jour avec succès dans le tableau de bord admin !');
    } public function updateAdmin(Request $request, Jardin $jardin)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required',
            'adresse' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($jardin->image) {
                Storage::disk('public')->delete($jardin->image);
            }
    
            // Stocker la nouvelle image
            $imagePath = $request->file('image')->store('jardins', 'public');
            $jardin->image = $imagePath;
        }
    
        // Mise à jour des autres champs
        $jardin->nom = $request->nom;
        $jardin->description = $request->description;
        $jardin->adresse = $request->adresse;
    
        $jardin->save();
    
        return redirect()->route('gardens.index.admin')->with('success', 'Jardin mis à jour avec succès dans le tableau de bord admin !');
    }
    
}