<?php

namespace App\Http\Controllers;

use App\Services\FollowService;

class FollowController extends Controller
{
    protected $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    } 

    public function follow($loggedInUserId, $followUserId)
    {
        $result = $this->followService->follow($loggedInUserId, $followUserId);
        return response()->json($result);
    }

    public function unfollow($loggedInUserId, $followUserId)
    {
        $result = $this->followService->unfollow($loggedInUserId, $followUserId);
        return response()->json($result);
    }
}
