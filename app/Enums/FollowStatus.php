<?php

namespace App\Enums;

enum FollowStatus: string
{
    case SELF = 'self';              // 自分の投稿
    case FOLLOWING = 'following';    // フォロー中
    case NOT_FOLLOWING = 'not_following'; // フォローしていない

    /**
     * ラベルを取得するメソッド
     */
    public function label(): string
    {
        return match($this) {
            self::SELF => '自分の投稿',
            self::FOLLOWING => 'フォロー中',
            self::NOT_FOLLOWING => 'フォローしていません',
        };
    }
}
