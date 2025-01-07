<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('users/login');
});

Route::get('/register', function () {
    return view('users/register');
});


Route::get('/material_index', function () {
    return view('materials/top_rated_materials');
});

Route::resource("materials",MaterialController::class);
Route::resource("products",ProductController::class);