<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('inicio', function () {
    return view('inicio');
});

Route::resource('categories', 'CategoryController');
Route::resource('clients', 'ClientController');
Route::resource('delivery_points', 'DeliveryPointController');
Route::resource('package_states', 'PackageStateController');
Route::resource('parcels', 'ParcelController');
Route::resource('payment_states', 'PaymentStateController');
Route::resource('products', 'ProductController');
Route::resource('providers', 'ProviderController');
Route::resource('purchases', 'PurchaseController');
Route::resource('sales', 'SaleController');










