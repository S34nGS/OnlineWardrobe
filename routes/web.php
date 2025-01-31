<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClothingController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WardrobeController;
use Illuminate\Support\Facades\Route;

Route::get('/wardrobe', [WardrobeController::class, 'index'])->name('wardrobe.index');
Route::post('/wardrobe', [WardrobeController::class, 'store'])->name('clothing.store');

Route::resource('categories', CategoryController::class);
Route::resource('clothing', ClothingController::class);

// Route for Revert action (patch)
Route::patch('/clothing/{clothing}/revert', [ClothingController::class, 'revert'])->name('clothing.revert');

// Home route - Fetches clothing items and passes them to the view
Route::get('/', [ClothingController::class, 'index'])
    ->middleware('auth')  // Ensure only authenticated users can access the home page
    ->name('home');

// Profile routes - Protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Clothing routes - Protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/clothes', [ClothingController::class, 'index'])->name('clothing.index');
    Route::get('/clothes/create', [ClothingController::class, 'create'])->name('clothing.create');
    Route::post('/clothes', [ClothingController::class, 'store'])->name('clothing.store');
    Route::get('/clothes/{clothing}', [ClothingController::class, 'show'])->name('clothing.show');
    Route::get('/clothes/{clothing}/edit', [ClothingController::class, 'edit'])->name('clothing.edit');
    Route::put('/clothes/{clothing}', [ClothingController::class, 'update'])->name('clothing.update');
    Route::delete('/clothes/{clothing}', [ClothingController::class, 'destroy'])->name('clothing.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/wardrobe', [WardrobeController::class, 'index'])->name('wardrobe.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
    Route::delete('/outfits/{outfit}', [FavoritesController::class, 'destroy'])->name('outfits.destroy');
});

// API Route for fetching updated clothing list dynamically
Route::get('/api/clothing/{categoryId}', [ClothingController::class, 'getClothingByCategory']);

Route::post('/outfits', [OutfitController::class, 'store'])->name('outfits.store');

require __DIR__.'/auth.php';