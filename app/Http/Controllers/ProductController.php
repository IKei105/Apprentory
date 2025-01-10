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
        // バリデーションの定義
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'product_detail' => 'required|string|max:5000',
            'product_url' => 'required|url|max:2048',
            'github_url' => 'nullable|url|max:2048',
        ]);

        // バリデーション済みデータを使用してレコードを作成
        Original_product::create($validatedData);

        return redirect()->back()->with('success', 'オリプロの投稿が完了しました。');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //以下ダミーデータ
        $product = (object)[
        'id' => $id,
        'title' => 'ダミープロダクトのタイトル',
        'subtitle' => 'ダミープロダクトのサブタイトル、こんな事ができます',
        'product_detail' => 'ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。ここにはダミーのプロダクト詳細が表示されます。',
        'product_url' => 'https://example.com',
        'github_url' => 'https://github.com/example',
        'created_at' => '2025-01-08',
        'tags' => ['タグ1', 'タグ2'], // ダミータグを追加
        'element'=>'テスター募集'
        ];
        // $product = Original_product::findOrFail($id);
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
