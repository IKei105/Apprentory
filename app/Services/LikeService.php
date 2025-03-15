<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User_like;
use App\Models\Material;
use App\Services\DiscordService;

class LikeService
{
    protected $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    public function toggleLike($table, $articleId)
    {
        $userId = Auth::id(); // ログイン中のユーザーID

        $modelClass = $this->resolveModel($table);

        if (!$modelClass) {
            return ['error' => 'テーブルが見つかりません'];
        }

        $material = Material::with('postedUserProfile')->find($articleId);

        if (!$material) {
            return ['error' => '教材が見つかりません'];
        }

        $userArticleLike = $modelClass::where('user_id', $userId)
            ->where('material_id', $articleId)
            ->first();

        if ($userArticleLike) {
            // いいねを削除
            $userArticleLike->delete();
            return ['message' => 'Like removed'];
        } else {
            // いいねを登録
            $modelClass::create([
                'user_id' => $userId,
                'material_id' => $articleId,
            ]);

            //ここでディスコードに送信します
            if ($material && $material->postedUserProfile && $material->postedUserProfile->discord_id) {
                $discordUserId = $material->postedUserProfile->discord_id; // 教材投稿者の Discord ID
                $likedUser = Auth::user()->profile->username;
                $message = "{$likedUser} さんがあなたの教材投稿にいいねしました！";
            
                $this->discordService->sendDirectMessage($discordUserId, $message);
            }
            return ['message' => 'Like added'];
        }
    }

    protected function resolveModel($table)
    {
        $models = [
            'user_like' => User_Like::class,
        ];

        return $models[$table] ?? null;
    }

    private function sendLikeNotification($materialId, $likingUserId)
    {
        // 投稿された教材の情報を取得
        $material = Material::with('posts.user.profile')->find($materialId);

        if (!$material || !$material->posts->first() || !$material->posts->first()->user->profile->discord_id) {
            return;
        }

        $discordUserId = $material->posts->first()->user->profile->discord_id; // 教材投稿者の Discord ID
        $likingUser = Auth::user()->name; // いいねしたユーザーの名前

        $message = "📢 {$likingUser} さんがあなたの教材にいいねしました！";

        // Discord API で通知を送信
        $this->discordService->sendDirectMessage($discordUserId, $message);
    }
}
