<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageStateController;

// ===RUTAS PARA ESTADOS DE PAQUETES===
Route::middleware(['role:admin'])->group(function () {
    //Ruta para mostrar
    Route::get('/package_states', [PackageStateController::class, 'index']);

    //Ruta para Crear (FrontEnd)
    Route::get('/package_states/create', [PackageStateController::class, 'create']);

    //Ruta para Crear (BackEnd)
    Route::post('/package_states/store', [PackageStateController::class, 'store']);

    //Ruta para Modificar (FrontEnd)
    Route::get('/package_states/edit/{package_state}', [PackageStateController::class, 'edit']);

    //Ruta para Modificar (BackEnd)
    Route::put('/package_states/update/{package_state}', [PackageStateController::class, 'update']);

    //Ruta para Eliminar (BackEnd)
    Route::delete('/package_states/destroy/{package_state}', [PackageStateController::class, 'destroy']);
});