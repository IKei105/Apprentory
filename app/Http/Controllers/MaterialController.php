<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Material;
use App\Models\Material_post;
use App\Models\Material_technologie_tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\MaterialService;
use App\Enums\FollowStatus;

class MaterialController extends Controller
{
    private const FIRST_POST_INDEX = 0;

    protected $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }
    
    public function index()
    {
        // ここで各情報を出力します
        $officialRecommendedMaterials = Material::whereBetween('id', [16, 27])
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
        

        return view('materials.material_index', compact('officialRecommendedMaterials', 'topRatedMaterials', 'latestMaterials'));
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
        $this->materialService->loadMaterialRelations($material);

        // 投稿者が現在のユーザーかどうかを判定
        $isOwner = $this->materialService->isOwner($material, $loggedInUserId);

        // ログイン中のユーザーがいいねをしたか取得
        $isLikedByCurrentUser = $this->materialService->isLikedByUser($material, $loggedInUserId);

        //教材についていいね数の取得
        $likeCount = $this->materialService->getLikeCount($material);

        //投稿記事の取得
        $post = $this->materialService->getFirstPost($material);

        //教材タグの取得
        $tagIds = $this->materialService->getTagIdsForMaterial($material);

        //おすすめ教材の取得
        $getPersonalizedRecommendations = $this->materialService->getPersonalizedRecommendations($material);
        $isFollow = $this->materialService->getFollowStatus($material, $loggedInUserId);

        // compactを使用してデータをビューに渡す
        return view('materials.material_detail', compact('material', 'likeCount', 'post', 'isOwner', 'isLikedByCurrentUser', 'getPersonalizedRecommendations', 'isFollow'));
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
