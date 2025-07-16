<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseDetailController;

// ===RUTAS PARA CATEGORIAS===
Route::middleware(['role:admin'])->group(function () {
    //Ruta para mostrar
    Route::get('/purchases', [PurchaseController::class, 'index']);

    //Ruta para Crear (FrontEnd)
    Route::get('/purchases/create', [PurchaseController::class, 'create']);

    //Ruta para Crear (BackEnd)
    Route::post('/purchases/store', [PurchaseController::class, 'store']);

    //Ruta para Modificar (FrontEnd)
    Route::get('/purchases/edit/{purchase}', [PurchaseController::class, 'edit']);

    //Ruta para Modificar (BackEnd)
    Route::put('/purchases/update/{purchase}', [PurchaseController::class, 'update']);

    //Ruta para Eliminar (BackEnd)
    Route::delete('/purchases/destroy/{purchase}', [PurchaseController::class, 'destroy']);

    //Ruta para Eliminar PurchaseDetail (BackEnd)
    Route::delete('/purchase-details/destroy/{purchase}', [PurchaseDetailController::class, 'destroy']);
});