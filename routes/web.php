<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;

//ルートディレクトリ設定,自動生成の除外設定
Route::get('/', [MaterialController::class, 'index'])->name('materials.index');
Route::resource('materials', MaterialController::class)->except(['index']);

//以下ユーザー情報関連

// ユーザー登録
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

// ログイン
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);

//マイページ表示
Route::get('/mypage', [UserController::class, 'showMyPage'])->name('mypage');

// ログアウト
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

//ユーザー情報関連ここまで


Route::get('/top_rated_materials', function () {
    return view('materials/top_rated_materials');
});

Route::get('/recommended_material', function () {
    return view('materials/recommended_materials');
});

Route::get('/material_detail', function () {
    return view('materials/material_detail');
});

Route::get('/material_index', function () {
    return view('materials/material_index');
});

Route::get('/post_material', function () {
    return view('materials/post_material');
});

Route::get('/post_product', function () {
    return view('products/create');
});

Route::resource("materials",MaterialController::class);
Route::resource("products",ProductController::class);

//新規登録確認用
Route::get('/register/confirmation', [UserController::class, 'showConfirmation'])->name('register.confirmation');
//ログイン確認用
Route::get('/logindashboard', [UserController::class, 'logindashboard'])->middleware('auth')->name('logindashboard');
//オリプロ投稿確認用
