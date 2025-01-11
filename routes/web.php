<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClothingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::resource('categories', CategoryController::class);

Route::resource('clothing', ClothingController::class);

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
    Route::get('/clothes/{clothing}/edit', [ClothingController::class, 'edit'])->name('clothing.edit'); // Fixed route for edit
    Route::put('/clothes/{clothing}', [ClothingController::class, 'update'])->name('clothing.update'); // Updated the URL to match the HTTP method correctly
    Route::delete('/clothes/{clothing}', [ClothingController::class, 'destroy'])->name('clothing.destroy');
});

require __DIR__.'/auth.php';
