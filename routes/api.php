<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PartController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/user', [AuthController::class, 'getAllData']);
    // Route::post('/user', [AuthController::class, 'getAllData']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/get-user-detail', [AuthController::class, 'getDetail']);

    Route::get('/customer', [CustomerController::class, 'getAllData']);
    Route::post('/customer', [CustomerController::class, 'createCustomer']);

    Route::post('/order', [OrderController::class, 'createOrder']);
    Route::get('/order', [OrderController::class, 'getAllData']);
    Route::put('/order/{id}', [OrderController::class, 'updateOrder']);
    Route::get('/order/{id}', [OrderController::class, 'getDataById']);


    Route::get('/part', [PartController::class, 'getAllData']);
    Route::post('/part', [PartController::class, 'createPart']);
});
