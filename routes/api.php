<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ItemAccountGroupController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\ItemGroupController;
use App\Http\Controllers\Api\ItemTypeController;
use App\Http\Controllers\Api\ItemUnitController;
use App\Http\Controllers\Api\StockIssueController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/ping', fn() => response()->json(['message' => 'authenticated']));

    Route::prefix('/user')->name('user.')->controller(UserController::class)->group(function () {
        Route::get('/{id}', 'detail')->name('detail');
        Route::post('/', 'store')->name('store');
        Route::post('/save', 'save')->name('save');
        Route::delete('/delete', 'delete')->name('delete');
    });

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

    Route::prefix('/company')->name('company.')->controller(CompanyController::class)->group(function () {
        Route::get('/list', 'list')->name('list');
        Route::get('/detail/{id}', 'detail')->name('detail');
    });
    Route::prefix('/itemGroup')->name('itemGroup.')->controller(ItemGroupController::class)->group(function () {
        Route::get('/list', 'list')->name('list');
    });
    Route::prefix('/itemUnit')->name('itemUnit.')->controller(ItemUnitController::class)->group(function () {
        Route::get('/list', 'list')->name('list');
    });
    Route::prefix('/account')->name('account.')->controller(AccountController::class)->group(function () {
        Route::get('/list', 'list')->name('list');
    });

    Route::prefix('/itemAccountGroup')->name('itemAccountGroup.')->controller(ItemAccountGroupController::class)->group(function () {
        Route::get('/list', 'list')->name('list');
    });
    Route::prefix('/itemType')->name('itemType.')->controller(ItemTypeController::class)->group(function () {
        Route::get('/getTypeByName/{name}', 'getTypeByName')->name('getTypeByName');
    });

});
