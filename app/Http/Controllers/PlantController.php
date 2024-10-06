<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plant;
use Illuminate\Http\Request;

use App\Models\Advice;
use App\Models\Rating;

class PlantController extends Controller
{
    // Method to display a list of all plants (front)
    public function index()
    {
        $plants = Plant::all(); // Retrieve all plants
        return view('plants.index', compact('plants')); // Return the view with the plants
    }

    // Method to display a list of all plants (admin)
    public function indexAdmin()
    {
        $plants = Plant::all(); // Retrieve all plants
        return view('backoffice.plants.index', compact('plants')); // Return the admin view with the plants
    }

    // Method to show the form for creating a new plant (front)
    public function create()
    {
        $categories = Category::all(); // Get all categories
        return view('plants.create', compact('categories')); // Return the view to create a plant
    }

    // Method to show the form for creating a new plant (admin)
    public function createAdmin()
    {
        $categories = Category::all(); // Get all categories
        return view('backoffice.plants.create', compact('categories')); // Return the admin view to create a plant
    }

    // Method to store a newly created plant (front)
    public function store(Request $request)
    {
        $request->validate([
            'scientific_name' => 'required|string|max:255',
            'common_name' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        Plant::create($request->all()); // Create the plant

        return redirect()->route('plants.index')->with('success', 'Plant created successfully!'); // Redirect with success message
    }

    // Method to store a newly created plant (admin)
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'scientific_name' => 'required|string|max:255',
            'common_name' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        Plant::create($request->all()); // Create the plant

        return redirect()->route('plants.index.admin')->with('success', 'Plant created successfully in admin dashboard!'); // Redirect with success message
    }

    // Method to show the form for editing a plant (front)
    public function edit(Plant $plant)
    {
        $categories = Category::all(); // Get all categories
        return view('plants.edit', compact('plant', 'categories')); // Return the view to edit the plant
    }

    // Method to show the form for editing a plant (admin)
    public function editAdmin(Plant $plant)
    {
        $categories = Category::all(); // Get all categories
        return view('backoffice.plants.edit', compact('plant', 'categories')); // Return the admin view to edit the plant
    }

    // Method to update a plant (front)
    public function update(Request $request, Plant $plant)
    {
        $request->validate([
            'scientific_name' => 'required|string|max:255',
            'common_name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $plant->update($request->all()); // Update the plant

        return redirect()->route('plants.index')->with('success', 'Plant updated successfully!'); // Redirect with success message
    }

    // Method to update a plant (admin)
    public function updateAdmin(Request $request, Plant $plant)
    {
        $request->validate([
            'scientific_name' => 'required|string|max:255',
            'common_name' => 'required|string|max:255',
            'origin' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $plant->update($request->all()); // Update the plant

        return redirect()->route('plants.index.admin')->with('success', 'Plant updated successfully in admin dashboard!'); // Redirect with success message
    }

    // Method to delete a plant (front)
    public function destroy(Plant $plant)
    {
        $plant->delete(); // Delete the plant

        return redirect()->route('plants.index')->with('success', 'Plant deleted successfully!'); // Redirect with success message
    }

    // Method to delete a plant (admin)
    public function destroyAdmin(Plant $plant)
    {
        $plant->delete(); // Delete the plant

        return redirect()->route('plants.index.admin')->with('success', 'Plant deleted successfully in admin dashboard!'); // Redirect with success message
    }





//rayen

    // public function index()
    // {
        
    //     $plants = Plant::all();

        
    //     return view('plants.index', compact('plants'));
    // }




    public function show($id)
{
    $plant = Plant::findOrFail($id);

    $advices = Advice::withCount('ratings')
                     ->where('plant_id', $plant->id)
                     ->orderBy('ratings_count', 'desc') 
                     ->get();
    
    foreach ($advices as $advice) {
        $advice->average_rating = $advice->ratings()->average('score');
    }

    // Pass the plant and advices to the view
    return view('plants.details', compact('plant', 'advices'));
}

}
