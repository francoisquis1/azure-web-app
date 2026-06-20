<?php

use App\Http\Controllers\CanchaController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

// Página principal = listado de canchas
Route::get('/', [CanchaController::class, 'index'])->name('canchas.index');

// Gestión de canchas (admin simple)
Route::get('/canchas/nueva', [CanchaController::class, 'create'])->name('canchas.create');
Route::post('/canchas', [CanchaController::class, 'store'])->name('canchas.store');

// Reservas
Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
Route::get('/reservas/nueva', [ReservaController::class, 'create'])->name('reservas.create');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
Route::patch('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');

// Ruta de salud para verificar que la app y la BD responden
Route::get('/health', function () {
    try {
        \App\Models\Cancha::count();
        return response()->json(['estado' => 'ok', 'bd' => 'conectada']);
    } catch (\Throwable $e) {
        return response()->json(['estado' => 'error', 'mensaje' => $e->getMessage()], 500);
    }
});
