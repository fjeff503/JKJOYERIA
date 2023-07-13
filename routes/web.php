<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DeliveryPointController;
use App\Http\Controllers\PackageStateController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\PaymentStateController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Index
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('inicio', function () {
    return view('inicio');
});

Route::resource('delivery_points', DeliveryPointController::class);
Route::resource('package_states', PackageStateController::class);
Route::resource('parcels', ParcelController::class);
Route::resource('payment_states', PaymentStateController::class);
Route::resource('products', ProductController::class);
Route::resource('providers', ProviderController::class);
Route::resource('purchases', PurchaseController::class);
Route::resource('sales', SaleController::class);

// ===RUTAS PARA CLIENTES===
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


// ===RUTAS PARA CATEGORIAS===
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





