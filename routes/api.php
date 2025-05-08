<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\StockIssueController;
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

    Route::prefix('/stockissue')->name('stockissue.')->controller(StockIssueController::class)->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::post('/', 'store')->name('store');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
        
        Route::prefix('/detail/{stockIssueId}')->group(function () {
            Route::get('/', 'detail')->name('detail');
            Route::post('/', 'storeDetail')->name('detail.store');
            Route::post('/{id}', 'updateDetail')->name('detail.update');
            Route::delete('/{id}', 'deleteDetail')->name('detail.delete');
        });
    });
});
