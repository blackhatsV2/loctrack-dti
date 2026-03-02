<?php

use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/api/location', [LocationController::class, 'store'])->name('location.store');
    
    // Admin routes
    Route::get('/admin/map', function () {
        return view('admin.map');
    })->name('admin.map');
    
    Route::get('/api/locations', [LocationController::class, 'index'])->name('location.index');
});

require __DIR__.'/auth.php';
