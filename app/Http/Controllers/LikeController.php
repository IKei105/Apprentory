<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User_like;

class LikeController extends Controller
{
    //
    public function toggleLike(Request $request, $table) 
    {
        $userId = Auth::user()->id; // ログイン中のユーザーID
        $articleId = $request->input('material_id'); // リクエストから対象IDを取得

        $modelClass = $this->resolveModel($table);

        if (!$modelClass) {
            return response()->json(['error' => 'Invalid table name'], 400);
        }
    
        $userArticleLike = $modelClass::where('user_id', $userId)
                            ->where('material_id', $articleId)
                            ->first();

        if ($userArticleLike) {
            $userArticleLike->delete();
            return response()->json(['message' => 'Like removed']);
        } else {
            $modelClass::create([
                'user_id' => $userId,
                'material_id' => $articleId,
            ]);
            return response()->json(['message' => 'Like added']);
        }
    }

    protected function resolveModel($table)
    {
        $models = [
            'user_like' => User_Like::class,
        ];

        return $models[$table] ?? null;
    }
}
