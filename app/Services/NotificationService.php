<?php

namespace App\Services;

use App\Models\User_follow;
use App\Models\Material_post;
use App\Models\Material_technologie_tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\Notification;
use App\Models\NotificationType;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function store(int $toUserId, int $fromUserId, string $typeName, ?object $notifiable = null)
    {
        try {
            $type = NotificationType::where('name', $typeName)->first();
    
            if (!$type) {
                throw new \Exception("通知タイプ '{$typeName}' が見つかりません");
            }
    
            Notification::create([
                'user_id' => $toUserId,
                'from_user_id' => $fromUserId,
                'notification_type_id' => $type->id,
                'notifiable_type' => $notifiable ? get_class($notifiable) : null,
                'notifiable_id' => $notifiable?->id,
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('通知の保存に失敗しました: ' . $e->getMessage());
        }
    }
}