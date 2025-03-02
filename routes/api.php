<?php

use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/follow/{user}', [FollowController::class, 'follow'])->name('api.follow');
    Route::post('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('api.unfollow');
});
