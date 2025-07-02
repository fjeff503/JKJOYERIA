<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParcelController;

// ===RUTAS PARA ENCOMENDISTAS===
//Ruta para mostrar
Route::get('/parcels', [ParcelController::class, 'index'])->middleware('role:admin,sales');

//Ruta para Crear (FrontEnd)
Route::get('/parcels/create', [ParcelController::class, 'create'])->middleware('role:admin');

//Ruta para Crear (BackEnd)
Route::post('/parcels/store', [ParcelController::class, 'store'])->middleware('role:admin');

//Ruta para Modificar (FrontEnd)
Route::get('/parcels/edit/{parcel}', [ParcelController::class, 'edit'])->middleware('role:admin');

//Ruta para Modificar (BackEnd)
Route::put('/parcels/update/{parcel}', [ParcelController::class, 'update'])->middleware('role:admin');

//Ruta para Eliminar (BackEnd)
Route::delete('/parcels/destroy/{parcel}', [ParcelController::class, 'destroy'])->middleware('role:admin');