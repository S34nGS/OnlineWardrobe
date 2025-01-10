<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use App\Models\Category;
use Illuminate\Http\Request;


class ClothingController extends Controller
{
    public function index()
    {
        $clothings = Clothing::all(); // Alle kleding ophalen
        $categories = Category::all(); // Alle categorieën ophalen
        
        // Groepeer de kledingitems per categorie
        $groupedClothings = $clothings->groupBy('category_id');
    
        return view('clothing.index', compact('groupedClothings', 'categories'));
    }
    
    
    // Show the form for creating a new clothing item
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('clothing.create', compact('categories'));
    }

    // Store a new clothing item
    public function store(Request $request)
{
    // Validate incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'color' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'image' => 'required|image|max:10240', // Validate the image file
    ]);

    // Store the image and get the file path
    $imagePath = $request->file('image')->store('clothes', 'public');

    // Create a new clothing item and assign the authenticated user's ID
    $clothing = Clothing::create([
        'name' => $request->name,
        'color' => $request->color,
        'category_id' => $request->category_id,
        'file_path' => $imagePath,
        'user_id' => auth()->id(), // Automatically assign the user_id
    ]);

    // Redirect the user with a success message
    return redirect()->route('clothing.index')->with('success', 'Clothing added successfully!');
}

    

    // Show a specific clothing item
    public function show(Clothing $clothing)
    {
        return view('clothing.show', compact('clothing'));
    }

    // Show the form for editing a clothing item
    public function edit(Clothing $clothing)
    {
        $categories = Category::all(); // Fetch all categories
        return view('clothing.edit', compact('clothing', 'categories'));
    }

    // Update a clothing item
    public function update(Request $request, Clothing $clothing)
    {
        $request->validate([
            'name' => 'required|string',
            'color' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // Store the uploaded file and get its path if there is a new image
        $filePath = $request->file('image') ? $request->file('image')->store('clothes', 'public') : $clothing->file_path;

        // Update the clothing item
        $clothing->update([
            'name' => $request->name,
            'color' => $request->color,
            'category_id' => $request->category_id,
            'file_path' => $filePath, // Update the image file path
        ]);

        return redirect()->route('clothing.index')->with('success', 'Clothing item updated successfully.');
    }

    // Delete a clothing item
    public function destroy(Clothing $clothing)
    {
        // Delete the clothing item and the image file if it exists
        if ($clothing->file_path) {
            \Storage::disk('public')->delete($clothing->file_path);
        }

        $clothing->delete();

        return redirect()->route('clothing.index')->with('success', 'Clothing item deleted successfully.');
    }
}
