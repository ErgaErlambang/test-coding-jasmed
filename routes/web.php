<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\ObatController;


Route::middleware('guest')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::get('/', 'login')->name('login');
        Route::post('/signin', 'signin')->name('signin');
    });
});

Route::middleware('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function() {
        return view('pages.dashboard');
    })->name('dashboard');

    Route::controller(PasienController::class)->prefix('pasien')->group(function() {
        Route::get('/', 'index')->name('pasien.index');
        Route::get('/create', 'create')->name('pasien.create');
        Route::post('/store', 'store')->name('pasien.store');
        Route::get('/{id}/edit', 'edit')->name('pasien.edit');
        Route::post('/{id}/update', 'update')->name('pasien.update');
        Route::delete('/{id}/destroy', 'destroy')->name('pasien.destroy');

        Route::get('/{id}/rekam-medis', 'rekamMedis')->name('pasien.rekam-medis');
        Route::post('/{id}/rekam-medis', 'saveEMR')->name('pasien.rekam-medis-store');
    });

    Route::controller(ObatController::class)->prefix('obat')->group(function() {
        Route::get('/', 'index')->name('obat.index');
        Route::get('/create', 'create')->name('obat.create');
        Route::post('/store', 'store')->name('obat.store');
        Route::get('/{id}/edit', 'edit')->name('obat.edit');
        Route::post('/{id}/update', 'update')->name('obat.update');
        Route::delete('/{id}/destroy', 'destroy')->name('obat.destroy');
    });
});