<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdvertiseController;

Route::get('/ping', function() {
    return response()->json(['pong' => true]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/unnauthorized', [AuthController::class, 'unnauthorized'])->name('login');
Route::put('/unnauthorized', [AuthController::class, 'unnauthorized'])->name('login');
Route::post('/unnauthorized', [AuthController::class, 'unnauthorized'])->name('login');
Route::delete('/unnauthorized', [AuthController::class, 'unnauthorized'])->name('login');

Route::controller(AuthController::class)->group(function() {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::middleware('auth:sanctum')->post('logout', 'logout');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResources([
        'users' => UserController::class,
        'states' => StateController::class,
        'categories' => CategoryController::class,
        'advertises' => AdvertiseController::class,
    ]);
});