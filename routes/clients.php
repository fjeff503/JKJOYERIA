<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

// ===RUTAS PARA CLIENTES===
Route::middleware(['role:admin,sales'])->group(function () {
    //Ruta para mostrar
    Route::get('/clients', [ClientController::class, 'index']);

    //Ruta para Crear (FrontEnd)
    Route::get('/clients/create', [ClientController::class, 'create']);

    //Ruta para Crear (BackEnd)
    Route::post('/clients/store', [ClientController::class, 'store']);

    //Ruta para Modificar (FrontEnd)
    Route::get('/clients/edit/{client}', [ClientController::class, 'edit']);

    //Ruta para Modificar (BackEnd)
    Route::put('/clients/update/{client}', [ClientController::class, 'update']);

    //Ruta para Eliminar (BackEnd)
    Route::delete('/clients/destroy/{client}', [ClientController::class, 'destroy']);
});