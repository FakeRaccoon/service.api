<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PartController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/get-user', [AuthController::class, 'getAllData']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get-user-detail', [AuthController::class, 'getDetail']);

    Route::post('/order-create', [OrderController::class, 'createOrder']);
    Route::post('/customer-create', [CustomerController::class, 'createCustomer']);

    Route::post('/get-order', [OrderController::class, 'getAllData']);
    Route::get('/get-order/{id}', [OrderController::class, 'getDataById']);
});
