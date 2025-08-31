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
        $officialRecommendedMaterials = $this->materialService->getOfficialRecommendedMaterials();
        $topRatedMaterials = $this->materialService->getTopRatedMaterials();
        $latestMaterials = $this->materialService->getLatestMaterials();

        return view('materials.material_index', compact('officialRecommendedMaterials', 'topRatedMaterials', 'latestMaterials'));
    }

    public function create()
    {
        return view('materials.post_material');
    }

    public function store(MaterialRequest $request)
    {
        $validated = $request->validated();
        $materialId = $this->materialService->storeMaterial($validated);

        $this->materialService->storeMaterialTechnologiesTags($validated, $materialId);
        $this->materialService->storeMaterialPostDateTime($materialId);

        return $this->index();
    }

    public function show(Material $material)
    {
        $loggedInUserId = Auth::id();

        $this->materialService->loadMaterialRelations($material);
        $isOwner = $this->materialService->isOwner($material, $loggedInUserId);
        $isLikedByCurrentUser = $this->materialService->isLikedByUser($material, $loggedInUserId);
        $likeCount = $this->materialService->getLikeCount($material);
        $post = $this->materialService->getFirstPost($material);
        $tagIds = $this->materialService->getTagIdsForMaterial($material);
        $getPersonalizedRecommendations = $this->materialService->getPersonalizedRecommendations($material);
        $isFollow = $this->materialService->getFollowStatus($material, $loggedInUserId);

        return view('materials.show_material', compact('material', 'likeCount', 'post', 'isOwner', 'isLikedByCurrentUser', 'getPersonalizedRecommendations', 'isFollow'));
    }

    public function edit(Material $material)
    {
        $loggedInUserId = Auth::id();
        $technologieIds = $material->technologies->pluck('id');

        if (!$material->posts->contains('posted_user_id', $loggedInUserId)) {
            return view('materials.index');
        }

        return view('materials.material_edit', compact('material', 'technologieIds'));
    }

    public function update(Material $material, UpdateMaterialRequest $request)
    {
        $validated = $request->validated();
        $this->materialService->updateMaterial($material, $validated);
        $this->materialService->updateMaterialTechnologiesTags($material, $validated);

        return redirect()->route('materials.show', ['material' => $material->id]);
    }

    public function destroy(Material $material) {
        $material->delete();

        return redirect()->route('materials.index');
    }

}
