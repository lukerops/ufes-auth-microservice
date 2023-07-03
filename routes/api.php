<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {

    //Auth routes
    Route::get('/me', [AuthController::class, 'me']);
    Route::delete('/logout',  [AuthController::class, 'logout']);
    Route::get('/refresh-token', [AuthController::class, 'refreshToken']);

    //User routes
    Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index'])->name('users.index');
    Route::put('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{id}', [\App\Http\Controllers\Api\UserController::class, 'destroy'])->name('users.destroy');
});
