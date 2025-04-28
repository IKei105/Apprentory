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
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User;
use App\Models\Original_product_comment;
use App\Http\Requests\OriginalProductCommentRequest;
use Illuminate\Support\Facades\Log;
use App\Services\ProductService;



class ProductController extends Controller
{
    private const FIRST_POST_INDEX = 0;
    private const FIRST_SELECT_INDEX = 1;
    private const LAST_SELECT_INDEX = 5;    
    
    /**
     * service呼び出し
    */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $products = $this->productService->index(); // ← サービス経由でプロダクト取得
        $popularTags = $this->productService->getPopularTags(); // ← サービス経由で人気タグ取得

        return view('products.index', compact('products','popularTags'));
    }

    public function indexTag($id)
    {
        $products = $this->productService->getProductsByTag($id); // ← サービス経由
        $popularTags = $this->productService->getPopularTags();
    
        return view('products.index', compact('products', 'popularTags'));
        return view('products.index', compact('products', 'popularTags'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create2');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        
        $product = new Original_product();

        $product->element = $request->element;
        $product->title = $request->title;
        $product->subtitle = $request->subtitle;
        $product->product_detail = $request->product_detail;
        if ($request->filled('product_url')) {
            $product->product_url = $request->product_url;
        }
        if ($request->filled('github_url')) {
            $product->github_url = $request->github_url;
        }

        $product->save();
        // 保存した時の主キーを取得
        $productlId = $product->id;

        // タグの保存を行うコード
        $originalProductTechnologieTag = new Original_product_technologie_tag();
        
        $originalProductTechnologieTag->original_product_id = $productlId;

        $selectedTechnologieTags = [];
        for ($i = self::FIRST_SELECT_INDEX; $i <= self::LAST_SELECT_INDEX; $i++) {
            $tagNum = "tag_select$i";
            if ($request->$tagNum) {
                $selectedTechnologieTags[] = $request->$tagNum;
                
            }
        }


        $uniqueSelectedTechnologieTags =  array_unique($selectedTechnologieTags);
        foreach ($uniqueSelectedTechnologieTags as $uniqueSelectedTechnologieTag) {
            $originalProductTechnologieTag = new Original_product_technologie_tag();
            $originalProductTechnologieTag->original_product_id = $productlId;
            $originalProductTechnologieTag->technologie_id = $uniqueSelectedTechnologieTag;
            $originalProductTechnologieTag->save();
        }

        // 画像の保存
        $originalProductImage = new Original_product_image();
        

        $images = $request->file('images');

        if ($images && is_array($images)) {
            foreach ($images as $image) {
                // ファイルがアップロードされたか確認
                if ($image instanceof \Illuminate\Http\UploadedFile) {
                    // ファイルを保存してパスを取得
                    $path = $image->store('original_product_images', 'public');                         //ここ修正してね(他力本願)

                    $originalProductImage = new Original_product_image();
                    $originalProductImage->original_product_id = $productlId;
                    $originalProductImage->image_dir = '/storage/' . $path;

                    $originalProductImage->save();
                }
            }
        }

        // 投稿者と日時の保存
        $originalProductPost = new Original_product_post();

        $originalProductPost->original_product_id = $productlId;
        $originalProductPost->posted_user_profile_id = Auth::user()->id;

        $originalProductPost->save();

        return redirect()->route('products.show', ['product' => $product->id]);


        // アップロードされたファイルを確認
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                Log::info("ファイル {$index}: " . $file->getClientOriginalName());
            }
        } else {
            Log::info('imagesキーにファイルが存在しません。');
        }        
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
                foreach ($request->file('images') as $index=>$image) {
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
            } else {  //デバッグ用
                Log::info("画像がアップロードされていません");
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
            // 正常なレスポンスをJSONで返す
            return response()->json([
            'status' => 'success',
            'id' => $product->id,
            'message' => '投稿が成功しました。',
        ]);
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
        /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // プロダクトをIDで取得し、関連するタグと画像も一緒に取得
        $product = Original_product::with([
            'technologies', 
            'images', 
            'profile', 
            'comments' => function ($query) {
                $query->orderBy('created_at', 'desc'); // 新しい順に並べ替え
            }, 
            'comments.user.profile'
        ])->findOrFail($id);
        
        
        // 現在のログインユーザーのプロフィールを取得
        $user = auth()->user();

        if (!$user || !$user->profile) {
            return redirect()->route('login');
        }

        $profile = $user->profile;
        

        //dd($product);
        
        return view('products.show', compact('product','profile'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $loggedInUserId = Auth::id();

        // 必要なリレーションを一度にロード
        $product = Original_product::with(['technologies', 'images', 'posts'])->findOrFail($id);
    
        // 投稿者でない場合は一覧ページにリダイレクト
        if (!$product->posts->contains('posted_user_profile_id', $loggedInUserId)) {
            return redirect()->route('products.index');
        }
        // 投稿者以外がアクセスした場合は403エラー
        if (auth()->id() !== $product->profile->user_id) {
            abort(403, '許可されていない操作です。');
        }


        // $image = $product->images[0]->image_dir;

        // dd($image);

        $technologieIds = $product->technologies->pluck('id');
        return view('products.edit2', compact('product','technologieIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    
    $product = Original_product::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'subtitle' => 'required|string|max:255',
        'product_detail' => 'required|string',
        'product_url' => 'nullable|url',
        'github_url' => 'nullable|url',
        'element' => 'required|string|in:need-tester,need-review',
        'tag_ids' => 'nullable|array',
        'tag_ids.*' => 'exists:technologies,id',
    ]);

    DB::beginTransaction();

    try {
        // 基本情報更新
        $product->update($validated);

        // タグ更新
        $selectedTags = [];
        for ($i = self::FIRST_SELECT_INDEX; $i <= self::LAST_SELECT_INDEX; $i++) {
            $select = "tag_select$i";
            if ($request->$select) {
                $selectedTags[] = $request->$select;
            }
        }
        $product->technologies()->sync(array_unique($selectedTags));

        // 画像処理
        $existingImageIds = $request->input('existing_image_ids', []);
        $deletedImageIds = $request->input('deleted_image_ids', []);
        $newImages = $request->file('images');

        foreach ($existingImageIds as $index => $imageId) {
            $image = Original_product_image::find($imageId);
        
            // 差し替え優先（削除対象にもなってるが、新しい画像があるなら差し替え）
            if (isset($newImages[$index]) && $newImages[$index] instanceof \Illuminate\Http\UploadedFile && $newImages[$index]->isValid()) {
                if ($image) {
                    \Storage::delete(str_replace('/storage/', 'public/', $image->image_dir));
                    $path = $newImages[$index]->store('original_product_images', 'public');
                    $image->image_dir = '/storage/' . $path;
                    $image->save(); // 上書き保存（順番保持）
                }
                continue; // 削除対象でも差し替えたので、削除処理スキップ
            }
        
            // 削除だけの場合
            if (in_array($imageId, $deletedImageIds)) {
                if ($image) {
                    \Storage::delete(str_replace('/storage/', 'public/', $image->image_dir));
                    $image->delete();
                }
            }
        }
        
        

        // 空スロットへの新規追加
        if ($newImages) {
            foreach ($newImages as $index => $file) {
                if ($file && $file->isValid() && empty($existingImageIds[$index])) {
                    $path = $file->store('original_product_images', 'public');
                    Original_product_image::create([
                        'original_product_id' => $product->id,
                        'image_dir' => '/storage/' . $path,
                    ]);
                }
            }
        }

        //dd($existingImageIds, $newImages, $deletedImageIds);

        DB::commit();
        return redirect()->route('products.show', ['product' => $product->id])
            ->with('success', '更新が完了しました！');

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->withErrors([
            'error' => '更新中にエラーが発生しました：' . $e->getMessage()
        ]);
    }

    
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

    public function indexTag(string $id)
    {
        $products = Original_product::with(['technologies', 'images', 'posts.user.profile'])
        ->whereHas('technologies', function ($query) use ($id) {
            $query->where('id', $id); // technologiesのidが一致するものを取得
        })
        ->orderBy('created_at', 'desc') // 作成日時で降順
        ->get();
        
        return view('products.index', compact('products'));
    }
}