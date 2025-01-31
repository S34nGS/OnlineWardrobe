<?php

namespace App\Http\Controllers;

use App\Models\Clothing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClothingController extends Controller
{
    // Kledingkast: Alle kleding van de ingelogde gebruiker
    public function wardrobe()
    {
        $clothes = Auth::user()->clothing;  // Alle kleding van de ingelogde gebruiker
        return view('clothing.wardrobe', compact('clothes'));
    }

    // Favorieten: Alle favoriete kleding van de ingelogde gebruiker
    public function favorites()
    {
        $favorites = Auth::user()->clothes;  // Hier wordt aangenomen dat je favorieten via een relatie met 'clothes' hebt
        return view('clothing.favorites', compact('favorites'));
    }

    // Andere methoden voor kleding zoals show, create, etc.
    public function show(Clothing $clothing)
    {
        return view('clothing.show', compact('clothing'));
    }
}
