<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiscordService
{
    private $botToken;

    public function __construct()
    {
        $this->botToken = env('DISCORD_BOT_TOKEN'); // `.env` に Bot Token を保存
    }

    // 📌 1️⃣ Discord の ID から DM チャンネルを取得
    private function getDmChannelId($userId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . $this->botToken,
            'Content-Type' => 'application/json',
        ])->post('https://discord.com/api/v10/users/@me/channels', [
            'recipient_id' => $userId,
        ]);
    
        if ($response->successful()) {
            Log::info("✅ DM チャンネル取得成功: " . json_encode($response->json()));
            return $response->json()['id']; // DMチャンネル ID を返す
        }
    
        Log::error("DM チャンネル取得失敗: " . $response->body());
        return null;
    }

    public function sendDirectMessage($discordUserId, $message)
    {
        $channelId = $this->getDmChannelId($discordUserId);
        if (!$channelId) {
            Log::error("チャンネル ID の取得に失敗: ユーザーID {$discordUserId}");
        }
    
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . $this->botToken,
            'Content-Type' => 'application/json',
        ])->post("https://discord.com/api/v10/channels/{$channelId}/messages", [
            'content' => $message,
        ]);
    
        if (!$response->successful()) {
            Log::error("メッセージ送信失敗: " . $response->body());
            return [
                'success' => false,
                'message' => 'Discord へのメッセージ送信に失敗しました'
            ];
        }
    }
    
}
