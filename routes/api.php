<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\DiscordController;
use Illuminate\Support\Facades\Auth;

Route::post('/follow/{loggedInUserId}/{followUser}', [FollowController::class, 'follow'])->name('api.follow');
Route::post('/unfollow/{loggedInUserId}/{followUser}', [FollowController::class, 'unfollow'])->name('api.unfollow');

Route::post('/send-discord-message', [DiscordController::class, 'sendMessage'])->name('api.discordSample');
