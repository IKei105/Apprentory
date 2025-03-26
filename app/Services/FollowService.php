<?php

namespace App\Services;

use App\Models\User_follow;
use App\Models\Material_post;
use App\Models\Material_technologie_tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class FollowService
{

    protected $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
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

            //通知テーブルに保存する
            

            $this->discordService->sendFollowMessage($followUserId, $loggedInUserId);

            return [
                'success' => true, // 追加
                'message' => 'フォロー処理成功'
            ];
        } catch (\Exception $e) {
            return ['error' => "フォロー処理に失敗しました", 'details' => $e->getMessage()];
        }
    }

    public function unfollow($loggedInUserId, $followUserId)
    {
        // フォロー状態を取得
        $existingFollow = User_follow::where('follower_id', $loggedInUserId)
        ->where('following_id', $followUserId)
        ->first();

        try {
            if ($existingFollow) {
                // フォロー解除（レコード削除）
                $existingFollow->delete();

                return [
                    'success' => true,
                    'message' => 'フォロー解除成功'
                ];
            } else {
                // すでにフォローしていない場合
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
