<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Clothing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClothingController extends Controller
{
    // Display the clothing items
    public function index()
    {
        $categories = Category::with('clothings')->get(); // Get all categories with associated clothing items
        return view('clothing.index', compact('categories'));
    }

    // Show the form to create new clothing
    public function create()
    {
        $categories = Category::all(); // Get all categories to display in the dropdown
        return view('clothing.create', compact('categories'));
    }

    // Store new clothing
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the file upload and store the image path
        $filePath = $request->file('image')->store('clothing', 'public');

        // Create the new clothing item and associate it with the logged-in user and category
        Clothing::create([
            'name' => $request->name,
            'color' => $request->color,
            'category_id' => $request->category_id,
            'file_path' => $filePath, // Store the image path in the database
            'user_id' => Auth::id(), // Associate clothing with the authenticated user
        ]);

        // Redirect the user back to the clothing index page with success message
        return redirect()->route('clothing.index')->with('success', 'Clothing added successfully!');
    }

    // Show the form to edit a specific clothing item
    public function edit(Clothing $clothing)
    {
        $categories = Category::all(); // Get all categories to display in the dropdown
        return view('clothing.edit', compact('clothing', 'categories'));
    }

    // Update the clothing item
    public function update(Request $request, Clothing $clothing)
    {
        // Validate the incoming request
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle the file upload and store the image path (only if there's a new image)
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('clothing', 'public');
            $clothing->file_path = $filePath; // Update the image path
        }

        // Update the clothing item
        $clothing->update([
            'name' => $request->name,
            'color' => $request->color,
            'category_id' => $request->category_id,
            // The file_path is only updated if a new image is uploaded
        ]);

        // Redirect the user back to the clothing index page with success message
        return redirect()->route('clothing.index')->with('success', 'Clothing updated successfully!');
    }

    // Destroy the clothing item
    public function destroy(Clothing $clothing)
    {
        // Delete the clothing item and its image from storage
        $clothing->delete();

        // Redirect back to the clothing index page with success message
        return redirect()->route('clothing.index')->with('success', 'Clothing deleted successfully!');
    }

    // Additional methods like revert can go here...
}
