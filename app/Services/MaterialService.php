<?php

namespace App\Services;

use App\Models\Material;
use App\Models\Material_technologie_tag;
use App\Models\Material_post;
use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MaterialService
{
    private const FIRST_SELECT_INDEX = 1;
    private const LAST_SELECT_INDEX = 5;

    public function getTagIdsForMaterial(Material $material): array
    {
        return $material->technologies->pluck('id')->toArray();
    }

    public function getRecommendedMaterialsBasedOnTags(array $tags)
    {
        $recommendedMaterials = collect(); // 最終的に表示するおすすめ教材
        $maxRecommendations = 4;           //  最大表示数

        // 取得済み教材のIDを追跡するための配列
        $alreadySelectedIds = [];

        switch (count($tags)) {
            case 5:
                //【タグが5つの場合】タグをシャッフルして先頭4つを使用
                shuffle($tags);
                $selectedTags = array_slice($tags, 0, 4);

                foreach ($selectedTags as $tagId) {
                    $material = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId); //  タグが一致する教材を検索
                        })
                        ->withCount('likes')             //  いいね数を取得
                        ->whereNotIn('id', $alreadySelectedIds) // すでに選んだ教材は除外
                        ->orderByDesc('likes_count')     //  いいねが多い順
                        ->first();                       //  1番いいねが多い教材を取得

                    if ($material) {
                        $recommendedMaterials->push($material);  // 教材を追加
                        $alreadySelectedIds[] = $material->id;   //  取得済みIDを記録
                    }
                }
                break;

            case 4:
                //【タグが4つの場合】各タグから1つずつ取得
                foreach ($tags as $tagId) {
                    $material = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId);
                        })
                        ->withCount('likes')
                        ->whereNotIn('id', $alreadySelectedIds) // 重複教材を除外
                        ->orderByDesc('likes_count')
                        ->first();

                    if ($material) {
                        $recommendedMaterials->push($material);
                        $alreadySelectedIds[] = $material->id;
                    }
                }
                break;

            case 3:
                //【タグが3つの場合】各タグから1つずつ取得
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

                //残りの1枠を確保 (2番目に多い教材の中で最もいいね数が多いもの)
                $secondBestMaterials = collect();

                foreach ($tags as $tagId) {
                    $secondMaterial = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId);
                        })
                        ->withCount('likes')
                        ->whereNotIn('id', $alreadySelectedIds) // すでに取得した教材は除外
                        ->orderByDesc('likes_count')
                        ->skip(1)  //  2番目にいいねが多い教材を取得
                        ->first();

                    if ($secondMaterial) {
                        $secondBestMaterials->push($secondMaterial);
                    }
                }

                // 2番目の候補から最もいいねが多い教材を1つ追加
                if ($secondBestMaterials->isNotEmpty()) {
                    $materialToAdd = $secondBestMaterials->sortByDesc('likes_count')->first();
                    $recommendedMaterials->push($materialToAdd);
                    $alreadySelectedIds[] = $materialToAdd->id;
                }
                break;

            case 2:
                //【タグが2つの場合】各タグから2つずつ取得
                foreach ($tags as $tagId) {
                    $materials = Material::whereHas('technologies', function ($query) use ($tagId) {
                            $query->where('id', $tagId);
                        })
                        ->withCount('likes')
                        ->whereNotIn('id', $alreadySelectedIds) // 既に取得済み教材を除外
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
                //【タグが1つの場合】1つのタグから上位4つ取得
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
                //【タグがない場合】おすすめは空
                break;
        }

        // 📢 最終的に重複を除外し、最大4つを返却
        return $recommendedMaterials->unique('id')->take($maxRecommendations);
    }

    public function storeMaterial($validatedRequest)
    {
        try {
            $path = request()->file('material-image')->store('material_images', 'public');
    
            $material = Material::create([
                'title' => $validatedRequest['material-title'],
                'material_detail' => $validatedRequest['material-thoughts'],
                'rating_id' => $validatedRequest['material-rate'],
                'price' => $validatedRequest['material-price'],
                'material_url' => $validatedRequest['material-url'],
                'image_dir' => '/storage/' . $path, // 画像パスをセット
            ]);
    
            //dd($material->id);
            return $material->id;
        } catch (\Exception $e) {
            Log::error('Material creation failed: ' . $e->getMessage());
            return null; // エラー時はnullを返す（呼び出し元で対処）
        }
    }

    //タグを保存するメソッド
    public function storeMaterialTechnologiesTags($request, $materialId)
    {
        // 選択されたタグを取得（重複を削除）
        $selectedTechnologieTags = $this->getSelectedTechnologieTags($request);
    
        // タグが1つも選択されていない場合は処理をスキップ
        if (empty($selectedTechnologieTags)) {
            return;
        }
    
        // 一括挿入用のデータを準備
        $insertData = [];
        foreach ($selectedTechnologieTags as $tagId) {
            $insertData[] = [
                'material_id' => $materialId,
                'technologie_id' => $tagId,
            ];
        }

        //dd($insertData);
    
        // まとめてDBに保存
        Material_technologie_tag::insert($insertData);
    }
    
    /**
     * リクエストから選択されたテクノロジータグを取得
     */
    private function getSelectedTechnologieTags($request)
    {
        $selectedTags = [];
    
        for ($i = self::FIRST_SELECT_INDEX; $i <= self::LAST_SELECT_INDEX; $i++) {
            $selectName = "select$i";
            if (!empty($request->$selectName)) {
                $selectedTags[] = $request->$selectName;
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
            return null; // エラー時はnullを返す（呼び出し元で対処）
        }

        return true;
    }

    public function updateMaterial(Material $material, array $validatedRequest)
    {
        try {
            // 画像がアップロードされていれば更新
            if (request()->hasFile('material-image')) {
                $path = request()->file('material-image')->store('material_images', 'public');
                $validatedRequest['image_dir'] = '/storage/' . $path;
            }

            // 教材情報を一括更新
            $material->update([
                'title' => $validatedRequest['material-title'],
                'material_detail' => $validatedRequest['material-thoughts'],
                'rating_id' => $validatedRequest['material-rate'],
                'price' => $validatedRequest['material-price'],
                'material_url' => $validatedRequest['material-url'],
                'image_dir' => $validatedRequest['image_dir'] ?? $material->image_dir, // 画像なしの場合は元の値を維持
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
            // 選択されたタグを取得（重複を削除）
            $selectedTechnologieTags = array_unique($this->getSelectedTechnologieTags($request));

            // 現在のタグを取得
            $currentTags = $material->technologies->pluck('id')->toArray();

            // 追加が必要なタグ
            $tagsToAdd = array_diff($selectedTechnologieTags, $currentTags);

            // 削除が必要なタグ
            $tagsToRemove = array_diff($currentTags, $selectedTechnologieTags);

            // タグを追加
            if (!empty($tagsToAdd)) {
                $insertData = array_map(fn($tagId) => [
                    'material_id' => $material->id,
                    'technologie_id' => $tagId,
                ], $tagsToAdd);

                Material_technologie_tag::insert($insertData);
            }

            // タグを削除
            if (!empty($tagsToRemove)) {
                Material_technologie_tag::where('material_id', $material->id)
                    ->whereIn('technologie_id', $tagsToRemove)
                    ->delete();
            }
        } catch (\Exception $e) {
            Log::error('MaterialTechnologiesTags update failed: ' . $e->getMessage());
        }
    }

}
