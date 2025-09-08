<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [MaterialController::class, 'index'])->name('materials.index');
    Route::resource('materials', MaterialController::class)->except(['index']);
    Route::get('/mypage', [UserController::class, 'showMyPage'])->name('mypage');
    Route::get('/users/{user}', [UserController::class, 'showUserPage'])->name('users.show');
    Route::get('/top_rated_materials', fn() => view('materials/top_rated_materials'));
    Route::get('/recommended_material', fn() => view('materials/recommended_materials'));
    Route::get('/material_detail', fn() => view('materials/material_detail'));
    Route::get('/material_index', fn() => view('materials/material_index'));
    Route::get('/post_material', fn() => view('materials/post_material'));
    Route::get('/post_product', fn() => view('products/create'));
    Route::resource('products', ProductController::class);
    Route::post('/like/{table}', [LikeController::class, 'toggleLike'])->name('like.toggle');
    Route::get('/products/tag/{id}', [ProductController::class, 'indexTag'])
    ->name('products.indexTag');
    Route::resource('comments', CommentController::class);
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('products/{id}/test-confirmation', [ProductController::class, 'testConfirmation'])->name('products.test-confirmation');
    Route::resource("materials",MaterialController::class);
    Route::resource("products",ProductController::class);
});

Route::get('/register', [UserController::class, 'showRegisterForm1'])->name('register1');
Route::get('/register2', [UserController::class, 'showRegisterForm2'])->name('register2');
Route::post('/register', [UserController::class, 'sendDiscordRegisterCode'])->name('register1');
Route::post('/register2', [UserController::class, 'newRegister'])->name('register2');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
