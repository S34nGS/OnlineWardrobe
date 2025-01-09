<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use Illuminate\Http\Request;

class ClothingController extends Controller
{
    /**
     * Display a listing of the resource (Home page).
     */
    public function index()
    {
        // Retrieve all clothing items
        $clothings = Clothing::all();

        // Return the 'home' view and pass the clothing data
        return view('home', compact('clothings'));
    }

    /**
     * Show the form for creating a new clothing item.
     */
    public function create()
    {
        return view('clothing.create');
    }

    /**
     * Store a newly created clothing item in storage.
     */
    public function store(Request $request)
    {
        // Validation for incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'file_path' => 'required|string',  // You might want to handle file uploads separately
        ]);

        // Create a new clothing item and save to the database
        $clothing = Clothing::create([
            'name' => $validated['name'],
            'color' => $validated['color'],
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(), // Save the user id (assuming logged in user)
            'file_path' => $validated['file_path'],
        ]);

        return redirect()->route('clothing.index')->with('success', 'Clothing item created successfully!');
    }

    /**
     * Display the specified clothing item.
     */
    public function show(Clothing $clothing)
    {
        return view('clothing.show', compact('clothing'));
    }

    /**
     * Show the form for editing the specified clothing item.
     */
    public function edit(Clothing $clothing)
    {
        return view('clothing.edit', compact('clothing'));
    }

    /**
     * Update the specified clothing item in storage.
     */
    public function update(Request $request, Clothing $clothing)
    {
        // Validation for incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'file_path' => 'nullable|string',  // Handle file update if needed
        ]);

        // Update clothing item data
        $clothing->update([
            'name' => $validated['name'],
            'color' => $validated['color'],
            'category_id' => $validated['category_id'],
            'file_path' => $validated['file_path'] ?? $clothing->file_path, // Only update file_path if provided
        ]);

        return redirect()->route('clothing.index')->with('success', 'Clothing item updated successfully!');
    }

    /**
     * Remove the specified clothing item from storage.
     */
    public function destroy(Clothing $clothing)
    {
        // Delete the clothing item
        $clothing->delete();

        return redirect()->route('clothing.index')->with('success', 'Clothing item deleted successfully!');
    }
}
