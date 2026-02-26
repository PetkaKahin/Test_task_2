<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   if (Auth::check()) {
       return redirect(route('reviews.show'));
   } else {
       return redirect(route('login'));
   }
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings.show');
    Route::patch('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/reviews', [ReviewController::class, 'show'])->name('reviews.show');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
