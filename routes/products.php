<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// ===RUTAS PARA PRODUCTOS===
//Ruta para mostrar
Route::get('/products', [ProductController::class, 'index'])->middleware('role:admin,sales');

//Ruta para mostrar por codigo
Route::get('/products/buscar/{codigo}', [ProductController::class, 'buscarPorCodigo']);

//Ruta para Crear (FrontEnd)
Route::get('/products/create', [ProductController::class, 'create'])->middleware('role:admin');

//Ruta para Crear (BackEnd)
Route::post('/products/store', [ProductController::class, 'store'])->middleware('role:admin');

//Ruta para Modificar (FrontEnd)
Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->middleware('role:admin');

//Ruta para Modificar (BackEnd)
Route::put('/products/update/{product}', [ProductController::class, 'update'])->middleware('role:admin');

//Ruta para Eliminar (BackEnd)
Route::delete('/products/destroy/{product}', [ProductController::class, 'destroy'])->middleware('role:admin');
