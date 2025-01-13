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
        //ここに教材データを保存するコードを書きます
        $material = new Material();

        $material->title = $request->title;
        $material->price = $request->price;
        $material->material_detail = $request->material_detail;
        $material->material_url = $request->material_url;
        $material->rating_id = $request->rating_id;
        $material->image_dir = $request->image_dir;

    }
}