<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDetailController;

// ===RUTAS PARA Ventas===
Route::middleware(['role:admin'])->group(function () {
    //Ruta para mostrar
    Route::get('/sales', [SaleController::class, 'index']);

    //Ruta para Crear (FrontEnd)
    Route::get('/sales/create', [SaleController::class, 'create']);

    //Ruta para Crear (BackEnd)
    Route::post('/sales/store', [SaleController::class, 'store']);

    //Ruta para Modificar (FrontEnd)
    Route::get('/sales/edit/{sale}', [SaleController::class, 'edit']);

    //Ruta para Modificar (BackEnd)
    Route::put('/sales/update/{sale}', [SaleController::class, 'update']);

    //Ruta para Eliminar (BackEnd)
    Route::delete('/sales/destroy/{sale}', [SaleController::class, 'destroy']);

    //Ruta para Eliminar saleDetail (BackEnd)
    Route::delete('/sale-details/destroy/{sale}', [SaleDetailController::class, 'destroy']);
});