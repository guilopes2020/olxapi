<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdvertiseController;

Route::apiResources([
    'users' => UserController::class,
    'states' => StateController::class,
    'categories' => CategoryController::class,
    'advertises' => AdvertiseController::class,
]);
