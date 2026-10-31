<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\GoogleAuthController;

Route::get('/verify-email', [AuthController::class, 'verifyEmail']);
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
