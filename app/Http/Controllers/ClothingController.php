<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use App\Models\Category;
use Illuminate\Http\Request;

class ClothingController extends Controller
{
    // Show the list of clothing items
    public function index()
    {
        $clothings = Clothing::all(); // Fetch all clothing items
        return view('clothing.index', compact('clothings'));
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
        $request->validate([
            'name' => 'required|string',
            'color' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
        ]);

        // Store the uploaded file and get its path
        $filePath = $request->file('image') ? $request->file('image')->store('clothes', 'public') : null;

        // Create the clothing item and associate it with the category
        Clothing::create([
            'name' => $request->name,
            'color' => $request->color,
            'category_id' => $request->category_id,
            'file_path' => $filePath, // Save the image file path
        ]);

        return redirect()->route('clothing.index')->with('success', 'Clothing item added successfully.');
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
