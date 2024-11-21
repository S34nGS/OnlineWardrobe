<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use Illuminate\Http\Request;

class ClothingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clothings = Clothing::all();
        return view('clothing.index', compact('clothings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clothing.create');
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
    public function show(Clothing $clothing)
    {
        return view('clothing.show', compact('clothing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clothing = Clothing::findOrFail($id);
        return view('clothing.edit', compact('clothing'));
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
    public function destroy(string $id)
    {
        //
    }
}
