<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\AdminController;


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [PasswordResetController::class, 'sendOtp']);
    Route::post('/reset-password', [PasswordResetController::class, 'reset']);

    // 🔐 JWT Protected
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:api');
    Route::post('/contact', [ContactController::class, 'store']);
    Route::get('/detect-country', [ContactController::class, 'detectCountry']);
    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe']);
});

// 🔐 Admin Routes
Route::prefix('admin')->middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'getDashboard']);
    Route::get('/users', [AdminController::class, 'getAllUsers']);
    Route::get('/users/{id}', [AdminController::class, 'getUserDetails']);
    Route::put('/users/{id}/role', [AdminController::class, 'updateUserRole'])->middleware('super_admin');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->middleware('super_admin');
});


