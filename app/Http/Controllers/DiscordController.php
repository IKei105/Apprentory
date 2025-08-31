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

    public function sendMessage(Request $request)
    {
        $discordUserId = $request->input('discord_id');
        $message = $request->input('message');
        
        $success = $this->discordService->sendDirectMessage($discordUserId, $message);

        return response()->json([
            'success' => $success,
            'message' => $success ? "メッセージを送信しました！" : "送信に失敗しました"
        ]);
    }
}
