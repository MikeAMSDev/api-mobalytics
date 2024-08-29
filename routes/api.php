<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthAdminController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\AdminItemController;
use App\Http\Controllers\Api\SynergyController;
use App\Http\Controllers\Api\AdminSynergyController;
use App\Http\Controllers\Api\AugmentController;
use App\Http\Controllers\Api\ChampionController;
use App\Models\Augment;

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

Route::group(['prefix' => 'admin'], function () {
    Route::get('/index', [AuthAdminController::class, 'index'])->middleware(['auth:sanctum']);
    Route::post('/login', [AuthAdminController::class, 'login']);
    Route::post('/logout', [AuthAdminController::class, 'logout'])->middleware(['auth:sanctum']);

    Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum', 'App\Http\Middleware\CheckUserRole']], function () {
        Route::get('/', [AdminUserController::class, 'index']);
        Route::get('/{id}', [AdminUserController::class, 'show']);
        Route::post('/create', [AdminUserController::class, 'register']);
        Route::put('/update/{id}/update', [AdminUserController::class, 'update']);
        Route::delete('/delete/{id}/delete', [AdminUserController::class, 'destroy']);
    });

    Route::group(['prefix' => 'item', 'middleware' => ['auth:sanctum', 'App\Http\Middleware\CheckUserRole']], function () {
        Route::get('/', [AdminItemController::class, 'index']);
        Route::get('/{id}', [AdminItemController::class, 'show']);
        Route::post('/create', [AdminItemController::class, 'create']);
        Route::put('/update/{id}', [AdminItemController::class, 'update']);
        Route::delete('/delete/{id}', [AdminItemController::class, 'destroy']);
    });


    Route::group(['prefix' => 'synergy', 'middleware' => ['auth:sanctum', 'App\Http\Middleware\CheckUserRole']], function () {
        Route::get('/', [AdminSynergyController::class, 'index']);
        Route::get('/{id}', [AdminSynergyController::class, 'show']);
        Route::post('/create', [AdminSynergyController::class, 'create']);
        Route::put('/update/{id}', [AdminSynergyController::class, 'update']);
        Route::delete('/delete/{id}', [AdminSynergyController::class, 'destroy']);
    });

});

Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UserController::class, 'register']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/update', [UserController::class, 'update']);
        Route::delete('/delete/{id}/delete', [UserController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'item'], function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/recipe', [ItemController::class, 'recipes']);
});

Route::group(['prefix' => 'synergy'], function () {
    Route::get('/', [SynergyController::class, 'index']);
});

Route::group(['prefix' => 'augment'], function () {
    Route::get('/', [AugmentController::class, 'index']);
});

Route::group(['prefix' => 'champion'], function () {
    Route::get('/', [ChampionController::class, 'index']);
    Route::get('/{name}', [ChampionController::class, 'show']);
});

Route::get('/index', [AuthController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
