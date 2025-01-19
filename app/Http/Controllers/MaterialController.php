<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use App\Models\Material;
use App\Models\Material_post;
use App\Models\Material_technologie_tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    private const FIRST_POST_INDEX = 0;
    private const FIRST_SELECT_INDEX = 1;
    private const LAST_SELECT_INDEX = 5;
    

    public function index()
    {
        // ここで各情報を出力します
        $recommendedMaterials = Material::whereBetween('id', [1, 5])
            ->with(['posts.user']) // posts を介して user をロード
            ->withCount('likes')   // likes の数をカウント
            ->get();

        $topRatedMaterials = Material::with(['posts.user.profile']) // posts を介して user と profile をロード
            ->withCount('likes')   // likes の数を取得
            ->orderBy('created_at', 'desc') // created_at の降順で並べ替え
            ->get();

        $latestMaterials = Material::with(['posts.user.profile']) // posts を介して user と profile をロード
            ->withCount('likes')   // likes の数を取得
            ->orderBy('created_at', 'desc') // created_at の降順で並べ替え
            ->get();
        
        $material = Material::with(['posts.user.profile'])->findOrFail(5);

        // データ確認用
        //dd($topRatedMaterials);


        return view('materials.material_index', compact('recommendedMaterials', 'topRatedMaterials', 'latestMaterials'));
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

        //ここでテクノロジータグテーブルにデータを保存します
        $materialTechnologieTag = new Material_technologie_tag();
        $materialTechnologieTag->material_id = $materialId;

        $selectedTechnologieTags = [];
        for ($i = self::FIRST_SELECT_INDEX; $i <= self::LAST_SELECT_INDEX; $i++) {
            $selectName = "select$i";
            if ($request->$selectName) {
                $selectedTechnologieTags[] = $request->$selectName;
                
            }
        }

        $uniqueSelectedTechnologieTags =  array_unique($selectedTechnologieTags);
        foreach ($uniqueSelectedTechnologieTags as $uniqueSelectedTechnologieTag) {
            $materialTechnologieTag = new Material_technologie_tag();
            $materialTechnologieTag->material_id = $materialId;
            $materialTechnologieTag->technologie_id = $uniqueSelectedTechnologieTag;
            $materialTechnologieTag->save();
        }

        // 教材ポストテーブルに保存します！
        $materialPost = new Material_post();

        $materialPost->material_id = $materialId;
        $materialPost->posted_user_id = Auth::user()->id;

        $materialPost->save();
    }

    public function show(Material $material)
    {

        // ログイン中のユーザーidを取得
        $loggedInUserId = Auth::id();
        $isOwner = $material->posts->contains('posted_user_id', $loggedInUserId);
        // Materialモデルのpostsとlikesリレーションをロード
        $material->load(['posts', 'likes']);

        // 必要に応じてリレーションデータを加工
        $likeCount = $material->likes->count(); // likesの数をカウント
        $posts = $material->posts;             // postsリレーションを取得
        $post = $posts[self::FIRST_POST_INDEX];

        // compactを使用してデータをビューに渡す
        return view('materials.material_detail', compact('material', 'likeCount', 'post', 'isOwner'));
    }

    public function edit(Material $material)
    {
        $loggedInUserId = Auth::id();
        $technologieIds = $material->technologies->pluck('id'); // technologie_idのリストを取得

        if (!$material->posts->contains('posted_user_id', $loggedInUserId)) {
            return view('materials.index');
        }

        return view('materials.material_edit', compact('material', 'technologieIds'));
    }

    public function update(Material $material, Request $request)
    {

        if ($request->hasFile('material_image')) { //画像が投稿されていたら
            $path = $request->file('material_image')->store('material_images', 'public');
    
            $material->image_dir = '/storage/' . $path;
        }

        // ここでデータの更新を行なっていきます
        $material->title = $request->material_title;
        $material->material_detail = $request->material_thoughts;
        $material->rating_id = $request->material_rate;
        $material->price = $request->material_price;
        $material->material_url = $request->material_url;

        $material->save();

        $materialId = $material->id;

        // ここでタグが存在しないのならば保存する
        $selectedTechnologieTags = [];
        for ($i = self::FIRST_SELECT_INDEX; $i <= self::LAST_SELECT_INDEX; $i++) {
            $selectName = "select$i";
            if ($request->$selectName) {
                $selectedTechnologieTags[] = $request->$selectName;
            }
        }

        $currentTags = $material->technologies->pluck('id')->toArray();
        $tagsToAdd = array_diff($selectedTechnologieTags, $currentTags); // 追加が必要なタグ
        $tagsToRemove = array_diff($currentTags, $selectedTechnologieTags); // 削除が必要なタグ

        if (!empty($tagsToAdd)) {
            foreach ($tagsToAdd as $tagToAdd){
            $materialTechnologieTag = new Material_technologie_tag();
            $materialTechnologieTag->material_id = $materialId;
            $materialTechnologieTag->technologie_id = $tagToAdd;

            $materialTechnologieTag->save();
            }
        }

        if (!empty($tagsToRemove)) {
            foreach ($tagsToRemove as $tagToRemove) {
                // 中間テーブルから該当するタグを削除
                Material_technologie_tag::where('material_id', $materialId)
                    ->where('technologie_id', $tagToRemove)
                    ->delete();
            }
        }
    }

    public function destroy(Material $material) {
        $material->delete();
    }


}