<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\ReservaController;
use Illuminate\Support\Facades\Route;

// Página principal = listado de canchas
Route::get('/', [CanchaController::class, 'index'])->name('canchas.index');

// --- Login (opcional) ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Reservas (abiertas, sin login) ---
Route::get('/reservas', [ReservaController::class, 'index'])->name('reservas.index');
Route::get('/reservas/nueva', [ReservaController::class, 'create'])->name('reservas.create');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');

// --- Acciones SOLO ADMIN ---
Route::middleware(\App\Http\Middleware\SoloAdmin::class)->group(function () {
    // Gestión de canchas
    Route::get('/canchas/nueva', [CanchaController::class, 'create'])->name('canchas.create');
    Route::post('/canchas', [CanchaController::class, 'store'])->name('canchas.store');
    Route::delete('/canchas/{id}', [CanchaController::class, 'destroy'])->name('canchas.destroy');

    // Cancelar reservas
    Route::patch('/reservas/{id}/cancelar', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');

    // Exportar reservas
    Route::get('/reservas/exportar/csv', [ReservaController::class, 'exportarCsv'])->name('reservas.csv');
    Route::get('/reservas/exportar/excel', [ReservaController::class, 'exportarExcel'])->name('reservas.excel');
});

// Ruta de salud
Route::get('/health', function () {
    try {
        \App\Models\Cancha::count();
        return response()->json(['estado' => 'ok', 'bd' => 'conectada']);
    } catch (\Throwable $e) {
        return response()->json(['estado' => 'error', 'mensaje' => $e->getMessage()], 500);
    }
});