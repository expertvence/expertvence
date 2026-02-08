<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;

Route::get('/verify-email', [AuthController::class, 'verifyEmail']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
