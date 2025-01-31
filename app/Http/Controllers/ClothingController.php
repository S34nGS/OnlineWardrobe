<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Clothing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    // Destroy a clothing item
    public function destroy($id)
    {
        // Find the clothing item by ID
        $clothing = Clothing::findOrFail($id);

        // Delete the associated file from storage
        if (Storage::exists($clothing->file_path)) {
            Storage::delete($clothing->file_path);
        }

        // Delete the clothing item from the database
        $clothing->delete();

        // Redirect back with a success message
        return redirect()->route('clothing.index')->with('success', 'Clothing item deleted successfully.');
    }
}
