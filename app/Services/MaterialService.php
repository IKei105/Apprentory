<?php

namespace App\Services;

use App\Models\Material;

class MaterialService
{
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

}
