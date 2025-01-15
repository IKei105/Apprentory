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

    public function checkUser() 
    {
        dd(Auth::user());
    }

    public function create()
    {
        return view('materials.post_material');
    }

    public function store(MaterialRequest $request)
    {
        // バリデーションを実行してダメなら投稿フォームにリダイレクト、成功したらバリデーション後のデータが配列として渡される
        $validated = $request->validated();

        // 教材を保存するためインスタンスを作成
        $material = new Material();

        //画像をstorageに保存する
        if ($request->hasFile('material-image')) { //画像が投稿されていたら
            //storage/app/public/material_images に保存
            $path = $request->file('material-image')->store('material_images', 'public');
    
            // パスをimage_dirにくれてやる
            $material->image_dir = '/storage/' . $path;
        }

        //インスタンスに値をセット
        $material->title = $validated['material-title'];
        $material->material_detail = $validated['material-thoughts'];
        $material->rating_id = $validated['material-rate'];
        $material->price = $validated['material-price'];
        $material->material_url = $validated['material-url'];

        //教材テーブルに保管する
        $material->save();

        // 保存した時の主キーを取得
        $materialId = $material->id;

        // 教材ポストテーブルに保存します！
        $materialPost = new Material_post();

        $userid = Auth::user()->userid;

        $material->material_id = $materialId;
        $materialPost->posted_user_id = $materialId;


    }

}