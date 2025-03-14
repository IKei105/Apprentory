<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LikeService;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function toggleLike(Request $request, $table)
    {
        $articleId = $request->input('material_id');

        $result = $this->likeService->toggleLike($table, $articleId);

        return response()->json($result);
    }
}
