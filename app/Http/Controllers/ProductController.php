<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Original_product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'product_detail' => 'required|string|max:5000',
            'product_url' => 'required|url|max:2048',
            'github_url' => 'nullable|url|max:2048',
            'radio' => 'required|in:need-tester,need-review',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'required|array|max:5',
            'tags.*' => 'exists:technologies,id', // タグは存在するIDのみ許可
        ]);
    
        // 1. Original_product にデータを保存
        $product = Original_product::create([
            'element' => $validatedData['radio'],
            'title' => $validatedData['title'],
            'subtitle' => $validatedData['subtitle'],
            'product_detail' => $validatedData['product_detail'],
            'product_url' => $validatedData['product_url'],
            'github_url' => $validatedData['github_url'],
        ]);
    
        // 2. 画像を保存
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/products_image'); // 画像を保存してパスを取得
                Original_product_image::create([
                    'original_product_id' => $product->id,
                    'image_dir' => $path,
                ]);
            }
        }
    
        // 3. タグを紐づけ
        $product->technologies()->attach($validatedData['tags']);
    
        // 成功メッセージを付けてリダイレクト
        return redirect()->route('products.index')->with('success', 'オリプロの投稿が完了しました。');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       // プロダクトをIDで取得し、関連するタグと画像も一緒に取得
        $product = Original_product::with(['technologies', 'images'])->findOrFail($id);    
        
        return view('products.show', compact('product'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
