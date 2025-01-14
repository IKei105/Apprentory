<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use App\Models\Material_post;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        return view('materials.index');
    }

    public function create()
    {
        //ここに投稿ページを返すコードを書きます
        return view('materials.post_material');
    }

    public function store(MaterialRequest $request)
    {
        //やることとしてはバリデーションを行う
        // バリデーション済みのデータを取得
        $validated = $request->validated();
        //画像をstorageに保存する

        //教材データベースにデータを保存する

        //教材ポストテーブルに保管する


    }

}