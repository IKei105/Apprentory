<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        if (Auth::user()->isFollowing($user->id)) {
            return response()->json(['message' => '既にフォロー済みです'], 400);
        }

        Auth::user()->follow($user);
        return response()->json(['message' => 'フォローしました', 'isFollowing' => true]);
    }

    public function unfollow(User $user)
    {
        if (!Auth::user()->isFollowing($user->id)) {
            return response()->json(['message' => 'フォローしていません'], 400);
        }

        Auth::user()->unfollow($user);
        return response()->json(['message' => 'フォロー解除しました', 'isFollowing' => false]);
    }
}

