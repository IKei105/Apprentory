<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User_like;
use App\Models\Material;
use App\Services\DiscordService;

class LikeService
{
    protected $discordService;
    protected $notificationService;

    public function __construct(DiscordService $discordService, NotificationService $notificationService)
    {
        $this->discordService = $discordService;
        $this->notificationService = $notificationService;
    }

    public function toggleLike($table, $articleId)
    {
        $userId = Auth::id();

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
            $userArticleLike->delete();
            return ['message' => 'Like removed'];
        } else {
            $modelClass::create([
                'user_id' => $userId,
                'material_id' => $articleId,
            ]);

            $postedUserId = $material->posts->first()?->posted_user_id;

            $this->notificationService->store(
                toUserId: $postedUserId,
                fromUserId: $userId,
                typeName: 'like',
                notifiable: $material
            );

            if ($material && $material->postedUserProfile && $material->postedUserProfile->discord_id) {
                $discordUserId = $material->postedUserProfile->discord_id;
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
        $material = Material::with('posts.user.profile')->find($materialId);

        if (!$material || !$material->posts->first() || !$material->posts->first()->user->profile->discord_id) {
            return;
        }

        $discordUserId = $material->posts->first()->user->profile->discord_id;
        $likingUser = Auth::user()->name;

        $message = "{$likingUser} さんがあなたの教材にいいねしました！";

        $this->discordService->sendDirectMessage($discordUserId, $message);
    }
}
