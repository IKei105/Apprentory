<?php

namespace App\Services;

use App\Models\Material;
use App\Models\Material_technologie_tag;
use App\Models\Material_post;
use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User_follow;
use App\Enums\FollowStatus;

class MaterialService
{
    private const FIRST_SELECT_INDEX = 1;
    private const LAST_SELECT_INDEX = 5;

    public function getOfficialRecommendedMaterials(): \Illuminate\Database\Eloquent\Collection
    {
            return Material::whereBetween('id', [6, 12])
            //↑ココいずれ修正！！
            ->with(['posts.user', 'technologies:id,name', 'category'])
            ->withCount('likes')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();
    }

    public function getTopRatedMaterials(): \Illuminate\Database\Eloquent\Collection
    {
        return Material::with(['posts.user.profile', 'technologies:id,name', 'category'])
            ->withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->get();
    }

    public function getLatestMaterials(): \Illuminate\Database\Eloquent\Collection
    {
        return Material::with(['posts.user.profile', 'technologies:id,name', 'category'])
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTagIdsForMaterial(Material $material): array
    {
        return $material->technologies->pluck('id')->toArray();
    }

    public function getPersonalizedRecommendationsBasedOnTags(array $tags)
    {
        $recommendedMaterials = collect();
        $maxRecommendations = 4;

        $alreadySelectedIds = [];

        switch (count($tags)) {
            case 5:
                shuffle($tags);
                $selectedTags = array_slice($tags, 0, 4);

                foreach ($selectedTags as $tagId) {
                    $material = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId);
                        })
                        ->withCount('likes')
                        ->whereNotIn('id', $alreadySelectedIds)
                        ->orderByDesc('likes_count')
                        ->first();

                    if ($material) {
                        $recommendedMaterials->push($material);
                        $alreadySelectedIds[] = $material->id;
                    }
                }
                break;

            case 4:
                foreach ($tags as $tagId) {
                    $material = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId);
                        })
                        ->withCount('likes')
                        ->whereNotIn('id', $alreadySelectedIds)
                        ->orderByDesc('likes_count')
                        ->first();

                    if ($material) {
                        $recommendedMaterials->push($material);
                        $alreadySelectedIds[] = $material->id;
                    }
                }
                break;

            case 3:
                foreach ($tags as $tagId) {
                    $material = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId);
                        })
                        ->withCount('likes')
                        ->whereNotIn('id', $alreadySelectedIds)
                        ->orderByDesc('likes_count')
                        ->first();

                    if ($material) {
                        $recommendedMaterials->push($material);
                        $alreadySelectedIds[] = $material->id;
                    }
                }

                $secondBestMaterials = collect();

                foreach ($tags as $tagId) {
                    $secondMaterial = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId);
                        })
                        ->withCount('likes')
                        ->whereNotIn('id', $alreadySelectedIds)
                        ->orderByDesc('likes_count')
                        ->skip(1)
                        ->first();

                    if ($secondMaterial) {
                        $secondBestMaterials->push($secondMaterial);
                    }
                }

                if ($secondBestMaterials->isNotEmpty()) {
                    $materialToAdd = $secondBestMaterials->sortByDesc('likes_count')->first();
                    $recommendedMaterials->push($materialToAdd);
                    $alreadySelectedIds[] = $materialToAdd->id;
                }
                break;

            case 2:
                foreach ($tags as $tagId) {
                    $materials = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId);
                        })
                        ->withCount('likes')
                        ->whereNotIn('id', $alreadySelectedIds)
                        ->orderByDesc('likes_count')
                        ->take(2)
                        ->get();

                    $materials->each(function ($material) use (&$recommendedMaterials, &$alreadySelectedIds) {
                        $recommendedMaterials->push($material);
                        $alreadySelectedIds[] = $material->id;
                    });
                }
                break;

            case 1:
                $materials = Material::whereHas('technologies', function ($query) use ($tags) {
                        $query->where('id', $tags[0]);
                    })
                    ->withCount('likes')
                    ->whereNotIn('id', $alreadySelectedIds)
                    ->orderByDesc('likes_count')
                    ->take($maxRecommendations)
                    ->get();

                $recommendedMaterials = $recommendedMaterials->merge($materials);
                break;

            default:
                break;
        }

        return $recommendedMaterials->unique('id')->take($maxRecommendations);
    }

    public function storeMaterial($validatedRequest)
    {
        try {
            $price = isset($validatedRequest['is_free']) ? $validatedRequest['is_free'] : $validatedRequest['material-price'];
            $path = request()->file('material-image')->store('material_images', 'public');
            $material = Material::create([
                'title' => $validatedRequest['material-title'],
                'material_detail' => $validatedRequest['material-thoughts'],
                'rating_id' => $validatedRequest['material-rate'],
                'price' => $price,
                'material_url' => $validatedRequest['material-url'],
                'image_dir' => '/storage/' . $path,
                'category_id' => $validatedRequest['material-category'],
            ]);
    
            return $material->id;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error('Material creation failed: ' . $e->getMessage());
            return null;
        }
    }

    public function storeMaterialTechnologiesTags($request, $materialId)
    {
        $selectedTechnologieTags = $this->getSelectedTechnologieTags($request);
    
        if (empty($selectedTechnologieTags)) {
            return;
        }
    
        $insertData = [];
        foreach ($selectedTechnologieTags as $tagId) {
            $insertData[] = [
                'material_id' => $materialId,
                'technologie_id' => $tagId,
            ];
        }

        Material_technologie_tag::insert($insertData);
    }
    

    private function getSelectedTechnologieTags(array $validatedData): array
    {
        $selectedTags = [];

        for ($i = self::FIRST_SELECT_INDEX; $i <= self::LAST_SELECT_INDEX; $i++) {
            $selectName = "select$i";

            if (!empty($validatedData[$selectName])) {
                $selectedTags[] = $validatedData[$selectName];
            }
        }

        return array_unique($selectedTags);
    }


    public function storeMaterialPostDateTime($materialId)
    {
        try {
            $materialPost = Material_post::create([
                'material_id' => $materialId,
                'posted_user_id' => Auth::user()->id,
            ]);
        } catch (\Exception $e) {
            Log::error('MaterialPost creation failed: ' . $e->getMessage());
            return null;
        }

        return true;
    }

    public function updateMaterial(Material $material, array $validatedRequest)
    {
        try {
            if (request()->hasFile('material-image')) {
                $path = request()->file('material-image')->store('material_images', 'public');
                $validatedRequest['image_dir'] = '/storage/' . $path;
            }

            $material->update([
                'title' => $validatedRequest['material-title'],
                'material_detail' => $validatedRequest['material-thoughts'],
                'rating_id' => $validatedRequest['material-rate'],
                'price' => $validatedRequest['material-price'],
                'material_url' => $validatedRequest['material-url'],
                'image_dir' => $validatedRequest['image_dir'] ?? $material->image_dir,
            ]);

            return $material;
        } catch (\Exception $e) {
            Log::error('Material update failed: ' . $e->getMessage());
            return null;
        }
    }

    public function updateMaterialTechnologiesTags(Material $material, array $request)
    {
        try {
            $selectedTechnologieTags = array_unique($this->getSelectedTechnologieTags($request));
            $currentTags = $material->technologies->pluck('id')->toArray();
            $tagsToAdd = array_diff($selectedTechnologieTags, $currentTags);
            $tagsToRemove = array_diff($currentTags, $selectedTechnologieTags);

            if (!empty($tagsToAdd)) {
                $insertData = array_map(fn($tagId) => [
                    'material_id' => $material->id,
                    'technologie_id' => $tagId,
                ], $tagsToAdd);

                Material_technologie_tag::insert($insertData);
            }

            if (!empty($tagsToRemove)) {
                Material_technologie_tag::where('material_id', $material->id)
                    ->whereIn('technologie_id', $tagsToRemove)
                    ->delete();
            }
        } catch (\Exception $e) {
            Log::error('MaterialTechnologiesTags update failed: ' . $e->getMessage());
        }
    }

    public function loadMaterialRelations(Material $material): void
    {
        $material->load(['posts.user.profile', 'likes', 'technologies']);
    }

    public function isOwner(Material $material, int $loggedInUserId): bool
    {
        return $material->posts->contains('posted_user_id', $loggedInUserId);
    }

    public function isLikedByUser(Material $material, int $loggedInUserId): bool
    {
        return $material->likes->contains($loggedInUserId);
    }

    public function getLikeCount(Material $material): int
    {
        return $material->likes->count();
    }

    public function getFirstPost(Material $material)
    {
        return $material->posts->first();
    }

    public function getPersonalizedRecommendations(Material $material)
    {
        $tagIds = $this->getTagIdsForMaterial($material);
        return $this->getPersonalizedRecommendationsBasedOnTags($tagIds);
    }

    public function getFollowStatus(Material $material, int $loggedInUserId)
    {
        $isOwner = $this->isOwner($material, $loggedInUserId);

        return match (true) {
            $isOwner => FollowStatus::SELF,
            Auth::user()?->isFollowing($material->posts->first()->posted_user_id) => FollowStatus::FOLLOWING,
            default => FollowStatus::NOT_FOLLOWING,
        };
    }
}
