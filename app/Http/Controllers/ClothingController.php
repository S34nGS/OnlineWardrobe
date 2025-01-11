<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use App\Models\Category;
use Illuminate\Http\Request;

class ClothingController extends Controller
{
    // Show the index page with all clothing items
    public function index()
    {
        // Retrieve all clothing items and their associated categories
        $clothings = Clothing::all(); // Get all clothing items
        $categories = Category::all(); // Get all categories

        // Group clothing items by category_id
        $groupedClothings = $clothings->groupBy('category_id'); // Group clothing items by category_id

        // Pass both categories and grouped clothing items to the view
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
        // Validate the request
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id', 
            'name' => 'required|string|max:255', 
            'color' => 'required|string|max:255', 
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048' // Allow JPG, JPEG, PNG, GIF with max size 2MB
        ]);

        // Handle the image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $imagePath = $image->store('clothes', 'public');
        }

        // Check if a clothing item already exists in the selected category
        $existingClothing = Clothing::where('category_id', $validated['category_id'])->first();

        if ($existingClothing) {
            // If a clothing item exists for the category, update it (i.e., replace the image)
            $existingClothing->update([
                'name' => $validated['name'],
                'color' => $validated['color'],
                'file_path' => $imagePath ?? $existingClothing->file_path, // Retain previous image if new image isn't provided
            ]);
        } else {
            // If no clothing exists, create a new one
            Clothing::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'color' => $validated['color'],
                'file_path' => $imagePath ?? null,
            ]);
        }

        return redirect()->route('clothing.index');
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

    // Revert the clothing item image to the previous image
    public function revert(Request $request, Clothing $clothing)
    {
        // Check if there is a previous image available
        $previousClothing = Clothing::where('category_id', $clothing->category_id)
                                     ->whereNotNull('file_path')
                                     ->where('id', '!=', $clothing->id)
                                     ->latest()
                                     ->first();

        if ($previousClothing) {
            // Update the current clothing to use the previous image
            $clothing->update([
                'file_path' => $previousClothing->file_path,  // Set the file path of the previous image
            ]);

            return redirect()->route('clothing.index')->with('success', 'Image reverted successfully.');
        }

        return redirect()->route('clothing.index')->with('error', 'No previous image found.');
    }
}
