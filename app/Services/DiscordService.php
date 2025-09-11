<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class DiscordService
{
    private $botToken;

    public function __construct()
    {
        $this->botToken = env('DISCORD_BOT_TOKEN');
    }

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
            return $response->json()['id'];
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

    public function sendFollowMessage($loggedInUserId, $followUserId)
    {
        $followedUser = User::with('profile')->find($followUserId);
        if (!$followedUser || !$followedUser->profile || !$followedUser->profile->discord_id) {
            Log::error("Discord ID が見つかりません: ユーザーID {$followUserId}");
            return false;
        }

        $followedUser = User::with('profile')->find($loggedInUserId);
        if (!$followedUser || !$followedUser->profile) {
            Log::error("Discord ID が見つかりません: ユーザーID {$followUserId}");
            return false;
        }

        $discordUserId = $followedUser->profile->discord_id;
        $message = "あなたは {$followedUser->profile->username} にフォローされました！";

        return $this->sendDirectMessage($discordUserId, $message);
    }

    
    public function sendDiscordRegisterCode($discordUserId, $registerCode)
    {
        $message = "Apprentory 新規登録コード \n\n"
        . "あなたの登録コードは `{$registerCode}` です。\n\n"
        . "会員登録画面でこのコードを入力してください。\n"
        . "コードの有効期限: 明日まで";

        return $this->sendDirectMessage($discordUserId, $message);
    }
}
