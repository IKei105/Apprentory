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
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
    
        DB::beginTransaction();
    
        try {
            // 1. original_products テーブルに保存
            $product = new Original_product();
            $product->fill([
                'element' => $validated['element'],
                'title' => $validated['title'],
                'subtitle' => $validated['subtitle'],
                'product_detail' => $validated['product_detail'],
                'product_url' => $validated['product_url'],
                'github_url' => $validated['github_url'],
            ]);
            $product->save();
    
            // 2. original_product_images に画像を保存
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if (!$image->isValid()) {
                        throw new \Exception('無効な画像がアップロードされました。');
                    }
                    $path = $image->store('product_images', 'public');
                    $productImage = new Original_product_image([
                        'image_dir' => '/storage/' . $path,
                    ]);
                    $product->images()->save($productImage);
                }
            }
    
            // 3. タグ情報を保存
            if (!empty($validated['tag-select'])) {
                $product->technologies()->sync($validated['tag-select']);
            }
    
            // 4. original_product_posts に投稿情報を保存
            \App\Models\Original_product_post::create([
                'original_product_id' => $product->id,
                'posted_user_id' => \Auth::id(),
            ]);
    
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => '投稿中に問題が発生しました: ' . $e->getMessage()
            ]);
        }
    
        return redirect()->route('products.test-confirmation', ['id' => $product->id]);
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
