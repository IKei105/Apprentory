<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DiscordService;

class DiscordController extends Controller
{
    protected $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    //メッセージを送るメソッドです、apiのurlで教材投稿者のidを取得して、それを元にディスコードのurlを取得します
    public function sendMessage(Request $request)
    {
        // フロントエンドから送信されたデータを取得
        $discordUserId = $request->input('discord_id'); // 送る相手の Discord ID
        $message = $request->input('message'); // 送るメッセージ
        
        // Discord API を使って DM を送信
        $success = $this->discordService->sendDirectMessage($discordUserId, $message);

        return response()->json([
            'success' => $success,
            'message' => $success ? "メッセージを送信しました！" : "送信に失敗しました"
        ]);
    }
}
