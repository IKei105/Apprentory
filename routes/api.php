<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;
use Illuminate\Support\Facades\Auth;

Route::post('/follow/{loggedInUserId}/{followUser}', [FollowController::class, 'follow'])->name('api.follow');
Route::post('/unfollow/{loggedInUserId}/{followUser}', [FollowController::class, 'unfollow'])->name('api.unfollow');
