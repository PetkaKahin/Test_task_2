<?php

use App\Http\Controllers\YandexReviewsController;
use Illuminate\Support\Facades\Route;

//auth:sanctum guest
Route::middleware('auth:sanctum')->group(function () {
    Route::get('yandex_reviews', [YandexReviewsController::class, 'index'])->name('yandex_reviews.index');
});
