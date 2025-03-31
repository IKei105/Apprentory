<?php

namespace App\Services;

use App\Models\Original_product_comment;
use App\Models\Original_product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommentService
{

    protected $discordService;
    protected $notificationService;

    public function __construct(DiscordService $discordService, NotificationService $notificationService)
    {
        $this->discordService = $discordService;
        $this->notificationService = $notificationService;
    }

    public function createComment(array $data, int $productId)
{
    try {
        //コメントをデータベースに登録
        $comment = Original_product_comment::create([
            'original_product_id' => $productId,
            'commented_user_id' => Auth::id(),
            'comment' => $data['original-product-comment'],
        ]);

        //コメントしたユーザーの情報
        $commentingUser = Auth::user();
        $commentText = $data['original-product-comment'];

        //オリプロの投稿者の情報を取得
        $originalProduct = Original_product::with(['profile', 'postedUser'])->find($productId);

        $postedUserId = $originalProduct->postedUser?->id;
            if ($postedUserId) {
                $this->notificationService->store(
                    toUserId: $postedUserId,
                    fromUserId: $commentingUser->id,
                    typeName: 'comment',
                    notifiable: $originalProduct
                );
            }

        if ($originalProduct && $originalProduct->profile && $originalProduct->profile->discord_id) {
            $discordUserId = $originalProduct->profile->discord_id;
            $commentingUserName = $commentingUser->profile->username ?? $commentingUser->userid; // コメント投稿者の名前

            //Discord に送信するメッセージを作成
            $message = "{$commentingUserName}** さんがあなたのオリプロにコメントしました。\n\n **コメント内容:\n> {$commentText}";

            //Discord に通知を送信
            $this->discordService->sendDirectMessage($discordUserId, $message);
        }

        return $comment;
    } catch (\Exception $e) {
        Log::error("オリプロコメント作成エラー: " . $e->getMessage());

        return response()->json([
            'error' => 'コメントの作成に失敗しました。',
            'details' => $e->getMessage()
        ], 500);
    }
}

}
