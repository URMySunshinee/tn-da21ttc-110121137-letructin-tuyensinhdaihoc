<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = 'visits';
    
    // Tắt timestamps mặc định vì bảng này dùng visited_at
    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'referer',
        'user_id',
        'session_id',
        'country',
        'city',
        'device_type',
        'browser',
        'platform',
        'visited_at'
    ];

    protected $dates = [
        'visited_at'
    ];

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
