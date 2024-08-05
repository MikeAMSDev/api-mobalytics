<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthAdminController;
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
});

Route::get('/index', [AuthController::class, 'index'])->middleware(['auth:sanctum']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
