<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('service-orders')->group(function () {
    $controller = 'App\Http\Controllers\Api\ServiceOrderController';
    Route::get('index', $controller . '@index')->name('service-orders.index');
    Route::post('store', $controller . '@store')->name('service-orders.store');
});
