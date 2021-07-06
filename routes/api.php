<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\FormController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\PartController;


Route::middleware(['auth:api'])->group(function () {
    Route::prefix('/form')->group(function () {
        Route::get('/', [FormController::class, 'getData']);
        Route::post('create', [FormController::class, 'create']);
        Route::post('update', [FormController::class, 'update']);
        Route::post('update/fee', [FormController::class, 'updateFinalFee']);
        Route::post('update/status', [FormController::class, 'statusUpdate']);
        Route::post('update/repair', [FormController::class, 'repairStatus']);
        Route::post('update/total', [FormController::class, 'updateTotal']);
    });
    Route::prefix('parts')->group(function () {
        Route::get('/', [PartController::class, 'getData']);
        Route::post('create', [PartController::class, 'create']);
        Route::post('update', [PartController::class, 'update']);
        Route::post('delete', [PartController::class, 'delete']);
    });
});

Route::post('/admin/user-register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
Route::get('/user', [RegisterController::class, 'getData']);
Route::get('/user/test', [RegisterController::class, 'index']);

Route::get('items', [ItemController::class, 'index']);
