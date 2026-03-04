<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrajetController;
use App\Http\Controllers\VehiculeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/trajets', [TrajetController::class, 'index'])->name('trajets.index');
Route::get('/trajets/create', [TrajetController::class, 'create'])->name('trajets.create');

Route::get('/trajets/{trajet}', [TrajetController::class, 'show'])->name('trajets.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::prefix('vehicule')->name('vehicule.')->group(function () {
        Route::get('/create', [VehiculeController::class, 'create'])->name('create');
        Route::post('/', [VehiculeController::class, 'store'])->name('store');
        Route::get('/', [VehiculeController::class, 'show'])->name('show');
        Route::get('/edit', [VehiculeController::class, 'edit'])->name('edit');
        Route::put('/{vehicule}', [VehiculeController::class, 'update'])->name('update');
    });
    
    Route::get('/mes-trajets', [TrajetController::class, 'mesTrajets'])->name('trajets.mes');
    
    Route::post('/trajets', [TrajetController::class, 'store'])->name('trajets.store');
    Route::get('/trajets/{trajet}/edit', [TrajetController::class, 'edit'])->name('trajets.edit');
    Route::put('/trajets/{trajet}', [TrajetController::class, 'update'])->name('trajets.update');
    Route::delete('/trajets/{trajet}', [TrajetController::class, 'destroy'])->name('trajets.destroy');
});

require __DIR__.'/auth.php';