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

// RUTAS PARA CATEGORIAS
//Ruta para mostrar productos
Route::get('/categories', [CategoryController::class, 'index']);

//Ruta para Crear Producto (FrontEnd)
Route::get('/categories/create', [CategoryController::class, 'create']);

//Ruta para Crear Producto (BackEnd)
Route::post('/categories/store', [CategoryController::class, 'store']);

//Ruta para Modificar Producto (FrontEnd)
Route::get('/categories/edit/{category}', [CategoryController::class, 'edit']);

//Ruta para Modificar Producto (BackEnd)
Route::put('/categories/update/{category}', [CategoryController::class, 'update']);

//Ruta para Eliminar Producto (BackEnd)
Route::delete('/categories/destroy/{category}', [CategoryController::class, 'destroy']);




Route::resource('clients', ClientController::class);
Route::resource('delivery_points', DeliveryPointController::class);
Route::resource('package_states', PackageStateController::class);
Route::resource('parcels', ParcelController::class);
Route::resource('payment_states', PaymentStateController::class);
Route::resource('products', ProductController::class);
Route::resource('providers', ProviderController::class);
Route::resource('purchases', PurchaseController::class);
Route::resource('sales', SaleController::class);
