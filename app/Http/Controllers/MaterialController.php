<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        return view('materials.index');
    }

    public function create()
    {
        //ここに投稿ページを返すコードを書きます
    }

    public function store(Request $request)
    {
        //ここに教材データを保存するコードを書きます
    }
}