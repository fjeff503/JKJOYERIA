<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryPointController;

// ===RUTAS PARA PUNTOS DE ENTREGA===
//Ruta para mostrar
Route::get('/delivery_points', [DeliveryPointController::class, 'index'])->middleware('role:admin,sales,user');

//Ruta para Crear (FrontEnd)
Route::get('/delivery_points/create', [DeliveryPointController::class, 'create'])->middleware('role:admin');

//Ruta para Crear (BackEnd)
Route::post('/delivery_points/store', [DeliveryPointController::class, 'store'])->middleware('role:admin');

//Ruta para Modificar (FrontEnd)
Route::get('/delivery_points/edit/{delivery_point}', [DeliveryPointController::class, 'edit'])->middleware('role:admin');

//Ruta para Modificar (BackEnd)
Route::put('/delivery_points/update/{delivery_point}', [DeliveryPointController::class, 'update'])->middleware('role:admin');

//Ruta para Eliminar (BackEnd)
Route::delete('/delivery_points/destroy/{delivery_point}', [DeliveryPointController::class, 'destroy'])->middleware('role:admin');
