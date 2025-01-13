<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClothingController extends Controller
{
    // Show the index page with all clothing items
    public function index()
    {
        // Retrieve all categories with the count of their associated clothing items
        $categories = Category::withCount('clothings')->get();

        return view('clothing.index', compact('categories'));
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
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Store the image file and get its path
        $imagePath = $request->file('image')->store('clothes', 'public');

        // Create a new clothing item
        Clothing::create([
            'name' => $request->name,
            'color' => $request->color,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),  // Assign the authenticated user ID
            'file_path' => $imagePath,
        ]);

        return redirect()->route('clothing.index')->with('success', 'Clothing item added successfully!');
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
            'file_path' => $filePath, // Update the image file path if new image exists
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
        // Fetch the previous clothing item within the same category
        $previousClothing = Clothing::where('category_id', $clothing->category_id) // same category
                                    ->where('id', '<', $clothing->id) // previous item (lower id)
                                    ->orderBy('id', 'desc') // Get the latest one
                                    ->first();

        if ($previousClothing) {
            // Revert the current item to the previous item's image
            $clothing->update([
                'file_path' => $previousClothing->file_path, // Set the file path of the previous item
            ]);

            return redirect()->route('clothing.index')->with('success', 'Image reverted successfully.');
        }

        return redirect()->route('clothing.index')->with('error', 'No previous item found in this category.');
    }
}
