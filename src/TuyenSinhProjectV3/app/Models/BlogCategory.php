<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $table = 'category_blog'; // Sửa lại đúng tên bảng trong CSDL
    protected $fillable = ['name_category_blog'];
    public $timestamps = false;
}
