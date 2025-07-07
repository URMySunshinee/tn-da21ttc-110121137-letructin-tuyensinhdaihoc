<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $table = 'majors';

    protected $fillable = [
        'name_major',
        'category_major_id',
        'major_code',
        'description',
        'tuition_fee',
        'duration_years',
        'degree_level',
        'training_language',
        'career_prospects',
        'skills_developed',
        'admission_requirements',
        'curriculum_highlights',
        'industry_connections',
        'graduate_employment_rate',
        'average_starting_salary',
        'view_major',
        'status_major',
        'is_active',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tuition_fee' => 'decimal:2',
        'duration_years' => 'integer',
        'graduate_employment_rate' => 'decimal:2',
        'average_starting_salary' => 'decimal:2',
        'view_major' => 'integer',
        'status_major' => 'integer',
        'is_active' => 'boolean',
    ];

    // Quan hệ với category
    public function category()
    {
        return $this->belongsTo(CategoryMajor::class, 'category_major_id');
    }

    // Quan hệ với likes
    public function likes()
    {
        return $this->hasMany(LikeMajorDetail::class, 'major_id');
    }

    // Quan hệ với admission methods
    public function admissionMethods()
    {
        return $this->belongsToMany(AdmissionMethod::class, 'major_admission_methods');
    }

    // Quan hệ với subject combinations
    public function subjectCombinations()
    {
        return $this->belongsToMany(SubjectCombination::class, 'major_subject_combinations');
    }

    // Scope để lọc ngành học đang hoạt động
    public function scopeActive($query)
    {
        return $query->where('status_major', 0);
    }
}
