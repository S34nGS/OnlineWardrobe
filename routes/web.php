<?php

use App\Http\Controllers\ClothingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('home');})
    ->middleware('auth')
    ->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/clothes', [ClothingController::class, 'index'])->name('clothing.index');
Route::get('/clothes/create', [ClothingController::class, 'create'])->name('clothing.create');
Route::post('/clothes', [ClothingController::class, 'store'])->name('clothing.store');
Route::get('/clothes/{clothing}', [ClothingController::class, 'show'])->name('clothing.show');
Route::get('/clothes/{clothing}', [ClothingController::class, 'edit'])->name('clothing.edit');
Route::put('/clothes/{clothing}/edit', [ClothingController::class, 'update'])->name('clothing.update');
Route::delete('/clothes/{clothing}', [ClothingController::class, 'destroy'])->name('clothing.destroy');

require __DIR__.'/auth.php';
