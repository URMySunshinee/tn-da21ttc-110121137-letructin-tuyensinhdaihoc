<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMajor extends Model
{
    use HasFactory;

    protected $table = 'category_major';

    protected $fillable = [
        'name_category_major',
        'description',
        'icon',
        'color',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Quan hệ với majors
    public function majors()
    {
        return $this->hasMany(Major::class, 'category_major_id');
    }

    // Quan hệ với majors đang hoạt động
    public function activeMajors()
    {
        return $this->hasMany(Major::class, 'category_major_id')->where('status_major', 0);
    }
}
