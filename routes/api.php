<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
Route::post('forgot-password', [\App\Http\Controllers\Api\Auth\LoginController::class, 'forgotPassword']);
Route::post('reset-password', [\App\Http\Controllers\Api\Auth\LoginController::class, 'resetPassword']);
Route::post('register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::apiResources([
        'users' => \App\Http\Controllers\Api\UserController::class,
        'tasks' => \App\Http\Controllers\Api\TaskController::class,
    ]);
});
