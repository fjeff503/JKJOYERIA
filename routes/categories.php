<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

// ===RUTAS PARA CATEGORIAS===
Route::middleware(['role:admin'])->group(function () {
    //Ruta para mostrar
    Route::get('/categories', [CategoryController::class, 'index']);

    //Ruta para Crear (FrontEnd)
    Route::get('/categories/create', [CategoryController::class, 'create']);

    //Ruta para Crear (BackEnd)
    Route::post('/categories/store', [CategoryController::class, 'store']);

    //Ruta para Modificar (FrontEnd)
    Route::get('/categories/edit/{category}', [CategoryController::class, 'edit']);

    //Ruta para Modificar (BackEnd)
    Route::put('/categories/update/{category}', [CategoryController::class, 'update']);

    //Ruta para Eliminar (BackEnd)
    Route::delete('/categories/destroy/{category}', [CategoryController::class, 'destroy']);
});