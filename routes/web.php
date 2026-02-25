<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings.show');
    Route::get('/feedbacks', [FeedbackController::class, 'show'])->name('feedbacks.show');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});