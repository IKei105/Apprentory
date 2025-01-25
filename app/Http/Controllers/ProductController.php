<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Technologie;
use App\Models\Original_product;
use App\Models\Original_product_image;
use App\Models\Original_product_technologie_tag;
use App\Models\Original_product_post;
use App\Http\Requests\ProductRequest;



class ProductController extends Controller
{
    private const FIRST_POST_INDEX = 0;
    private const FIRST_SELECT_INDEX = 1;
    private const LAST_SELECT_INDEX = 5;    
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
        dd($request->file('images'));

    
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
                        'original_product_id' => $product->id,
                        'image_dir' => '/storage/' . $path,
                    ]);
                    $product->images()->save($productImage);
                }
            }
            // 3. タグ情報を保存
            // 保存した時の主キーを取得
            $productId = $product->id;

            //ここでテクノロジータグテーブルにデータを保存します
            $productTechnologieTag = new Original_product_technologie_tag();
            $productTechnologieTag->product_id = $productId;

            $selectedTechnologieTags = [];
            for ($i = self::FIRST_SELECT_INDEX; $i <= self::LAST_SELECT_INDEX; $i++) {
                $selectName = "tag_select$i";
                if ($request->$selectName) {
                    $selectedTechnologieTags[] = $request->$selectName;
                    
                }
            }

            $uniqueSelectedTechnologieTags =  array_unique($selectedTechnologieTags);
            foreach ($uniqueSelectedTechnologieTags as $uniqueSelectedTechnologieTag) {
                $productTechnologieTag = new Original_product_technologie_tag();
                $productTechnologieTag->original_product_id = $productId;
                $productTechnologieTag->technologie_id = $uniqueSelectedTechnologieTag;
                $productTechnologieTag->save();
            }
            // 4. original_product_posts に投稿情報を保存
            \App\Models\Original_product_post::create([
                'original_product_id' => $product->id,
                'posted_user_profile_id' => \Auth::id(),
            ]);
    
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => '投稿中に問題が発生しました: ' . $e->getMessage()
            ]);
        }
    
        return redirect()->route('products.show', ['product' => $product->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // プロダクトをIDで取得し、関連するタグと画像も一緒に取得
        $product = Original_product::with(['technologies', 'images','profile'])->findOrFail($id);    
        
        // 現在のログインユーザーのプロフィールを取得
        $profile = auth()->user()->profile;
        
        return view('products.show', compact('product','profile'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Original_product::with('images', 'technologies')->findOrFail($id);
        $technologies = Technologie::all(); // 全タグを取得
        
        // 投稿者以外がアクセスした場合は403エラー
        if (auth()->id() !== $product->profile->user_id) {
            abort(403, '許可されていない操作です。');
        }
    
        return view('products.edit', compact('product','technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Original_product::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'product_detail' => 'required|string',
            'product_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'element' => 'required|string|in:need-tester,need-review',
            'tag_ids' => 'nullable|array', // タグ用
            'tag_ids.*' => 'exists:technologies,id', // タグIDがtechnologiesテーブルに存在することを確認
        ]);
    
        // プロダクト情報を更新
        $product->update([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'product_detail' => $validated['product_detail'],
            'product_url' => $validated['product_url'],
            'github_url' => $validated['github_url'],
            'element' => $validated['element'],
        ]);
    
        // タグの同期
        $product->technologies()->sync($validated['tag_ids'] ?? []);
    
        // 更新完了後、詳細ページなどにリダイレクト
        return redirect()->route('products.show', $product->id)->with('success', '更新が完了しました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Original_product::findOrFail($id);

        // 投稿者以外が削除しようとした場合は403エラー
        if (auth()->id() !== $product->profile->user_id) {
            abort(403, '許可されていない操作です。');
        }
    
        $product->delete();
    
        return redirect()->route('products.index')->with('success', '投稿が削除されました。');
    }
    public function testConfirmation($id)
    {
        $product = Original_product::with('images', 'technologies')->findOrFail($id);
    
        return view('tests.product_confirmation', ['product' => $product]);
    }
}
