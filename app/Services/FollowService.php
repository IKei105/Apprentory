<?php

namespace App\Services;

use App\Models\User_follow;
use App\Models\Material_post;
use App\Models\Material_technologie_tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Services\NotificationService;

class FollowService
{

    protected $discordService;
    protected $notificationService;

    public function __construct(DiscordService $discordService, NotificationService $notificationService)
    {
        $this->discordService = $discordService;
        $this->notificationService = $notificationService;
    }

    public function follow($loggedInUserId, $followUserId)
    {
        if ($loggedInUserId == $followUserId) {
            return ['error' => "自分自身をフォローすることはできません"];
        }

        if (User_follow::where('follower_id', $loggedInUserId)->where('following_id', $followUserId)->exists()) {
            return ['error' => "すでにフォロー済みです"];
        }

        try {
            User_follow::create([
                'follower_id' => $loggedInUserId,
                'following_id' => $followUserId
            ]);

            $fromUser = User::find($loggedInUserId);

            $this->notificationService->store(
                toUserId: $followUserId,
                fromUserId: $loggedInUserId,
                typeName: 'follow',
                notifiable: $fromUser
            );

            $this->discordService->sendFollowMessage($loggedInUserId, $followUserId);

            return [
                'success' => true,
                'message' => 'フォロー処理成功',
                'user' => $loggedInUserId,
            ];
        } catch (\Exception $e) {
            return ['error' => "フォロー処理に失敗しました", 'details' => $e->getMessage()];
        }
    }

    public function unfollow($loggedInUserId, $followUserId)
    {
        $existingFollow = User_follow::where('follower_id', $loggedInUserId)
        ->where('following_id', $followUserId)
        ->first();

        try {
            if ($existingFollow) {
                $existingFollow->delete();

                return [
                    'success' => true,
                    'message' => 'フォロー解除成功'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'フォローしていません'
                ];
            }
        } catch (Exception $e) {
            return [
                'error' => "フォロー解除に失敗しました",
                'details' => $e->getMessage()
            ];
        }
    }
}
