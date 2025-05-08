<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/ping', fn() => response()->json(['message' => 'authenticated']));

    Route::prefix('/item')->name('item.')->controller(ItemController::class)->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::post('/', 'store')->name('store');
        Route::post('/save', 'save')->name('save');
        Route::delete('/delete', 'delete')->name('delete');
    });
});