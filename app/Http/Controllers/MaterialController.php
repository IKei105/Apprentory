<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;

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

    public function store(MaterialRequest $request)
    {
        //ここに教材データを保存するコードを書きます


    }
}