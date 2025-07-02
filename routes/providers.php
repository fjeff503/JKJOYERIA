<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProviderController;

// ===RUTAS PARA PROVEEDORES===
Route::middleware(['role:admin'])->group(function () {
    //Ruta para mostrar
    Route::get('/providers', [ProviderController::class, 'index']);

    //Ruta para Crear (FrontEnd)
    Route::get('/providers/create', [ProviderController::class, 'create']);

    //Ruta para Crear (BackEnd)
    Route::post('/providers/store', [ProviderController::class, 'store']);

    //Ruta para Modificar (FrontEnd)
    Route::get('/providers/edit/{provider}', [ProviderController::class, 'edit']);

    //Ruta para Modificar (BackEnd)
    Route::put('/providers/update/{provider}', [ProviderController::class, 'update']);

    //Ruta para Eliminar (BackEnd)
    Route::delete('/providers/destroy/{provider}', [ProviderController::class, 'destroy']);
});