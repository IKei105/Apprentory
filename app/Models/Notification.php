<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'from_user_id',
        'notification_type_id',
        'notifiable_type',
        'notifiable_id',
        'is_read',
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function notificationType()
    {
        return $this->belongsTo(NotificationType::class, 'notification_type_id');
    }
    
    public function notifiable()
    {
        return $this->morphTo();
    }

}
