<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('welcome')->group(function () {
    Route::get('/login', [WelcomeController::class, 'showLoginForm']);
    Route::post('/login', [WelcomeController::class, 'login']);
    Route::post('/logout', [WelcomeController::class, 'logout'])->middleware('auth');
    Route::get('/menu', [WelcomeController::class, 'showIndex'])->middleware('auth');
});