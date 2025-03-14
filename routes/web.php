<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;

// ログインが必要なルート
Route::middleware(['auth'])->group(function () {
    Route::get('/', [MaterialController::class, 'index'])->name('materials.index');
    Route::resource('materials', MaterialController::class)->except(['index']);
    Route::get('/mypage', [UserController::class, 'showMyPage'])->name('mypage');
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
});

Route::resource("materials",MaterialController::class);
Route::resource("products",ProductController::class);

// ログイン不要のルート
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// 特定のルートは除外
Route::get('/register/confirmation', [UserController::class, 'showConfirmation'])->name('register.confirmation');
Route::get('/logindashboard', [UserController::class, 'logindashboard'])->name('logindashboard');

// 投稿後の確認ページ
Route::get('products/{id}/test-confirmation', [ProductController::class, 'testConfirmation'])->name('products.test-confirmation');

//検索用
Route::get('/search', [SearchController::class, 'index'])->name('search.index');

//コメント
Route::resource('comments', CommentController::class);
Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('comments.store');

//テストルート
Route::get('/test', function () {
    return 'Hello World';
});
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

