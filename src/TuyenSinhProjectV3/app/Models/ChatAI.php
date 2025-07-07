<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAI extends Model
{
    use HasFactory;

    protected $table = 'chat_ai';

    protected $fillable = [
        'user_id',
        'message_content',
        'type_message',
        'date_message'
    ];

    protected $casts = [
        'date_message' => 'datetime',
        'type_message' => 'integer',
    ];

    // Định nghĩa lại các cột timestamp
    const CREATED_AT = 'date_message';
    const UPDATED_AT = null; // Bảng không có cột updated_at

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
