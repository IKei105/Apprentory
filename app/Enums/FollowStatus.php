<?php

namespace App\Enums;

enum FollowStatus: string
{
    case SELF = 'self';
    case FOLLOWING = 'following';
    case NOT_FOLLOWING = 'not_following';

    public function label(): string
    {
        return match($this) {
            self::SELF => '自分の投稿',
            self::FOLLOWING => 'フォロー中',
            self::NOT_FOLLOWING => 'フォローしていません',
        };
    }
}
