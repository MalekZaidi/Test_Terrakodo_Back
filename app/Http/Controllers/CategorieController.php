<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Category;

use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // Function to display the categories (front)
    public function index()
    {
        $categories = Category::all(); // Retrieve all categories
        return view('categories.index', compact('categories')); // Return the view with the categories
    }

    // Function to display the categories (admin)
    public function indexAdmin()
    {
        $categories = Category::all(); // Retrieve all categories
        return view('backoffice.categories.index', compact('categories')); // Return the admin view with categories
    }

    // Function to show the form for creating a new category (front)
    public function create()
    {
        return view('categories.create'); // Return the view to create a category
    }

    // Function to show the form for creating a new category (admin)
    public function createAdmin()
    {
        return view('backoffice.categories.create'); // Return the admin view to create a category
    }

    // Function to store a newly created category (front)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Name is required
            'description' => 'nullable|string',  // Description is optional
        ]);

        Category::create($request->all()); // Create a new category

        return redirect()->route('categories.index')->with('success', 'Category created successfully.'); // Redirect with success message
    }

    // Function to store a newly created category (admin)
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Name is required
            'description' => 'nullable|string',  // Description is optional
        ]);

        Category::create($request->all()); // Create a new category

        return redirect()->route('categories.index.admin')->with('success', 'Category created successfully in the admin dashboard!'); // Redirect with success message
    }

    // Function to show the form for editing a category (front)
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category')); // Return the view to edit the category
    }

    // Function to show the form for editing a category (admin)
    public function editAdmin(Category $category)
    {
        return view('backoffice.categories.edit', compact('category')); // Return the admin view to edit the category
    }

    // Function to update a category (front)
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Name is required
            'description' => 'nullable|string',  // Description is optional
        ]);

        $category->update($request->all()); // Update the category

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!'); // Redirect with success message
    }

    // Function to update a category (admin)
    public function updateAdmin(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Name is required
            'description' => 'nullable|string',  // Description is optional
        ]);

        $category->update($request->all()); // Update the category

        return redirect()->route('categories.index.admin')->with('success', 'Category updated successfully in the admin dashboard!'); // Redirect with success message
    }

    // Function to delete a category (front)
    public function destroy(Category $category)
    {
        $category->delete(); // Delete the category

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!'); // Redirect with success message
    }

    // Function to delete a category (admin)
    public function destroyAdmin(Category $category)
    {
        $category->delete(); // Delete the category

        return redirect()->route('categories.index.admin')->with('success', 'Category deleted successfully in the admin dashboard!'); // Redirect with success message
    }
}