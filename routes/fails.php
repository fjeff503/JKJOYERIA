<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FailController;

// ===RUTAS PARA ERRORES===
//Ruta para mostrar
Route::get('/bugs', [FailController::class, 'index'])->middleware('role:admin');
