<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

// Index
Route::get('/', function () {
    return view('welcome');
})->middleware('role:admin,sales,user');

require __DIR__.'/categories.php';
require __DIR__.'/clients.php';
require __DIR__.'/delivery_points.php';
require __DIR__.'/fails.php';
require __DIR__.'/package_states.php';
require __DIR__.'/parcels.php';
require __DIR__.'/payment_states.php';
require __DIR__.'/products.php';
require __DIR__.'/providers.php';
require __DIR__.'/users.php';

Route::resource('purchases', PurchaseController::class);
Route::resource('sales', SaleController::class);