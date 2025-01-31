<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Outfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outfits = Outfit::where('user_id', Auth::id())->with('clothings')->get();
        return view('favorites.index', compact('outfits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Outfit $outfit)
    {
        // Ensure the outfit belongs to the authenticated user
        if ($outfit->user_id !== Auth::id()) {
            return redirect()->route('favorites.index')->with('error', 'You are not authorized to delete this outfit.');
        }

        // Delete the outfit
        $outfit->delete();

        return redirect()->route('favorites.index')->with('success', 'Outfit deleted successfully.');
    }
}
