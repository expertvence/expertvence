<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\NewsletterController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\AdminDashboardController;
use App\Http\Controllers\Api\AdminProjectController;
use App\Http\Controllers\Api\AdminTransactionController;
use App\Http\Controllers\Api\AdminShareMemberController;
use App\Http\Controllers\Api\AdminProfitDistributionController;
use App\Http\Controllers\Api\ReadySoftwareDemoController;
use App\Http\Controllers\Api\DemoViewController;

// 🌐 Public Settings Route
Route::get('/settings', [SettingController::class, 'getPublicSettings']);
Route::get('/software-demos', [ReadySoftwareDemoController::class, 'index']);
Route::get('/software-demos/{id}', [ReadySoftwareDemoController::class, 'show']);
Route::post('/software-demo-views', [DemoViewController::class, 'store'])->middleware('throttle:30,1');

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

// 🛡️ Admin API Routes
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth:api', 'admin.only'])->group(function () {
        Route::get('/me', [AdminAuthController::class, 'me']);
        Route::post('/logout', [AdminAuthController::class, 'logout']);

        // Website Settings
        Route::get('/settings', [SettingController::class, 'getAdminSettings']);
        Route::post('/settings', [SettingController::class, 'updateAdminSettings']);

        Route::get('/software-demo-views', [DemoViewController::class, 'index']);
        Route::get('/software-demos', [ReadySoftwareDemoController::class, 'adminIndex']);
        Route::post('/software-demos', [ReadySoftwareDemoController::class, 'store']);
        Route::put('/software-demos/{id}', [ReadySoftwareDemoController::class, 'update']);
        Route::delete('/software-demos/{id}', [ReadySoftwareDemoController::class, 'destroy']);

        // Dashboard Stats
        Route::get('/dashboard-stats', [AdminDashboardController::class, 'stats']);

        // Projects CRUD
        Route::get('/projects', [AdminProjectController::class, 'index']);
        Route::post('/projects', [AdminProjectController::class, 'store']);
        Route::put('/projects/{id}', [AdminProjectController::class, 'update']);
        Route::delete('/projects/{id}', [AdminProjectController::class, 'destroy']);

        // Transactions (Income & Expense) CRUD
        Route::get('/transactions', [AdminTransactionController::class, 'index']);
        Route::post('/transactions', [AdminTransactionController::class, 'store']);
        Route::put('/transactions/{id}', [AdminTransactionController::class, 'update']);
        Route::delete('/transactions/{id}', [AdminTransactionController::class, 'destroy']);

        // Share Members CRUD
        Route::get('/share-members', [AdminShareMemberController::class, 'index']);
        Route::post('/share-members', [AdminShareMemberController::class, 'store']);
        Route::post('/share-members/{id}', [AdminShareMemberController::class, 'update']); // for multipart/form-data support
        Route::put('/share-members/{id}', [AdminShareMemberController::class, 'update']);
        Route::delete('/share-members/{id}', [AdminShareMemberController::class, 'destroy']);

        // Profit Distributions CRUD
        Route::get('/profit-distributions', [AdminProfitDistributionController::class, 'index']);
        Route::post('/profit-distributions', [AdminProfitDistributionController::class, 'store']);
        Route::put('/profit-distributions/{id}', [AdminProfitDistributionController::class, 'update']);
        Route::delete('/profit-distributions/{id}', [AdminProfitDistributionController::class, 'destroy']);
    });
});
