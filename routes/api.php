<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthAdminController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

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
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UserController::class, 'register']);

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/update', [UserController::class, 'update']);
        Route::delete('/delete/{id}/delete', [UserController::class, 'destroy']);
    });
});

Route::get('/index', [AuthController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
