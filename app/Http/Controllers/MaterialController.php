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
    }

    public function store(MaterialRequest $request)
{
    return redirect()->route('materials.index')->with('success', '投稿が完了しました！');
    // バリデーション
    $validated = $request->validated();

    // 新しい Material を保存
    $material = new Material();

    if ($request->hasFile('material_image')) {
        $path = $request->file('material_image')->store('material_images', 'public');
        dd($path);
        $material->image_dir = '/storage/' . $path;
    } else {
        $path = 'お前の負け';
        dd($path);
    }

    $material->title = $validated['material-title'];
    $material->price = $validated['material-price'];
    $material->material_detail = $validated['material-thoughts'];
    $material->material_url = $validated['material-url'];
    $material->rating_id = $validated['material-rate'];
    $material->save();

    // 成功後にリダイレクト
    return redirect()->route('materials.index')->with('success', '投稿が完了しました！');
}

}