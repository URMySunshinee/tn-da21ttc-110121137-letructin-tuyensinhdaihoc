<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'name_blog',
        'image_blog',
        'description_blog',
        'view_blog',
        'content_blog',
        'author_id',
        'category_blog_id',
        'date_blog',
        'status_blog'
    ];

    protected $casts = [
        'date_blog' => 'datetime',
        'view_blog' => 'integer',
        'status_blog' => 'integer',
    ];

    // Định nghĩa lại các cột timestamp
    const CREATED_AT = 'date_blog';
    const UPDATED_AT = null; // Bảng không có cột updated_at

    // Quan hệ với user (author)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Quan hệ với category blog
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_blog_id');
    }

    // Quan hệ với likes
    public function likes()
    {
        return $this->hasMany(BlogLike::class);
    }
}
