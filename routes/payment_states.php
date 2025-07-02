<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentStateController;

// ===RUTAS PARA ESTADOS DE PAGOS===
Route::middleware(['role:admin'])->group(function () {
    //Ruta para mostrar
    Route::get('/payment_states', [PaymentStateController::class, 'index']);

    //Ruta para Crear (FrontEnd)
    Route::get('/payment_states/create', [PaymentStateController::class, 'create']);

    //Ruta para Crear (BackEnd)
    Route::post('/payment_states/store', [PaymentStateController::class, 'store']);

    //Ruta para Modificar (FrontEnd)
    Route::get('/payment_states/edit/{payment_state}', [PaymentStateController::class, 'edit']);

    //Ruta para Modificar (BackEnd)
    Route::put('/payment_states/update/{payment_state}', [PaymentStateController::class, 'update']);

    //Ruta para Eliminar (BackEnd)
    Route::delete('/payment_states/destroy/{payment_state}', [PaymentStateController::class, 'destroy']);
});