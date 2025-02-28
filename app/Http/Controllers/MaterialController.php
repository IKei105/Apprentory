<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use App\Models\Material_post;
use App\Models\Material_technologie_tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\MaterialService;

class MaterialController extends Controller
{
    private const FIRST_POST_INDEX = 0;
    private const FIRST_SELECT_INDEX = 1;
    private const LAST_SELECT_INDEX = 5;

    protected $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }
    
    public function index()
    {
        // ここで各情報を出力します
        $recommendedMaterials = Material::whereBetween('id', [16, 27])
            ->with(['posts.user', 'technologies:id,name']) // posts を介して user をロード
            ->withCount('likes')   // likes の数をカウント
            ->get();
            
        $topRatedMaterials = Material::with(['posts.user.profile', 'technologies:id,name']) // posts を介して user と profile をロード
            ->withCount('likes') // likes の数を取得
            ->orderBy('likes_count', 'desc') // likes_count の降順で並べ替え
            ->get();

        $latestMaterials = Material::with(['posts.user.profile', 'technologies:id,name']) // posts を介して user と profile をロード
            ->withCount('likes')   // likes の数を取得
            ->orderBy('created_at', 'desc') // created_at の降順で並べ替え
            ->get();
        

        return view('materials.material_index', compact('recommendedMaterials', 'topRatedMaterials', 'latestMaterials'));
    }

    public function create()
    {
        return view('materials.post_material');
    }

    public function store(StoreMaterialRequest $request)
    {
        // バリデーションを実行してダメなら投稿フォームにリダイレクト、成功したらバリデーション後のデータが配列として渡される
        $validated = $request->validated();

        //教材情報を保存する
        $materialId = $this->materialService->storeMaterial($validated);

        //タグを保存する
        $this->materialService->storeMaterialTechnologiesTags($request, $materialId);

        //投稿日時を保存する
        $this->materialService->storeMaterialPostDateTime($materialId);

        return $this->index();
    }

    public function show(Material $material)
    {
        // ログイン中のユーザーidを取得
        $loggedInUserId = Auth::id();
        
        // Materialモデルのリレーションをロード
        $material->load(['posts.user.profile', 'likes', 'technologies']); //posts.user.profileはposts → user → profileの順に取得しています

        // 投稿者が現在のユーザーかどうかを判定
        $isOwner = $material->posts->contains('posted_user_id', $loggedInUserId);

        // 現在のユーザーが「いいね」したかを確認
        $isLikedByCurrentUser = $material->likes->contains($loggedInUserId);

        // likesの数をカウント
        $likeCount = $material->likes->count();

        // postsリレーションを取得し、最初の投稿を選択
        $posts = $material->posts;
        $post = $posts[self::FIRST_POST_INDEX] ?? null; // 投稿がない場合の安全策

        $tagIds = $this->materialService->getTagIdsForMaterial($material);

        $recommendedMaterials = $this->materialService->getRecommendedMaterialsBasedOnTags($tagIds);

        // compactを使用してデータをビューに渡す
        return view('materials.material_detail', compact('material', 'likeCount', 'post', 'isOwner', 'isLikedByCurrentUser', 'recommendedMaterials'));
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

    public function update(Material $material, UpdateMaterialRequest $request)
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        // 教材情報を更新
        $this->materialService->updateMaterial($material, $validated);

        // タグ情報を更新
        $this->materialService->updateMaterialTechnologiesTags($material, $validated);

        return redirect()->route('materials.show', ['material' => $material->id]);
    }

    public function destroy(Material $material) {

        $material->delete();

        return redirect()->route('materials.index');
    }

}
