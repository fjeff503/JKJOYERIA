<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// ===RUTAS PARA USUARIOS===
Route::middleware(['role:admin'])->group(function () {
    //Ruta para mostrar
    Route::get('/users', [UserController::class, 'index']);
    
    //Ruta para Modificar (FrontEnd)
    Route::get('/users/edit/{user}', [UserController::class, 'edit']);
    
    //Ruta para Modificar (BackEnd)
    Route::put('/users/update/{user}', [UserController::class, 'update']);
    
    //Ruta para Eliminar (BackEnd)
    Route::delete('/users/destroy/{user}', [UserController::class, 'destroy']);
});