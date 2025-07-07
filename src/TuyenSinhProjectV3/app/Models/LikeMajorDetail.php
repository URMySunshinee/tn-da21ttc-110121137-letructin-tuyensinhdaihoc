<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeMajorDetail extends Model
{
    use HasFactory;

    protected $table = 'like_major_details';

    protected $fillable = [
        'user_id',
        'major_id',
        'liked_at'
    ];

    protected $casts = [
        'liked_at' => 'datetime',
    ];

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với major
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}
