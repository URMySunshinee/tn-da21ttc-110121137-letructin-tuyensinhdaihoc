<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;

class BlogCategoryAdminController extends Controller
{
    public function index()
    {
        // Sửa lại chỉ lấy đúng cột name_category_blog nếu bảng không có cột name
        $categories = BlogCategory::select(['id', 'name_category_blog'])
            ->orderBy('id', 'desc')->paginate(10);
        return view('admin.pages.blogCategory.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.blogCategory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_category_blog' => 'required|string|max:255',
        ]);

        // Kiểm tra xem danh mục đã tồn tại chưa (không phân biệt hoa thường)
        $exists = BlogCategory::whereRaw('LOWER(name_category_blog) = ?', [strtolower($request->name_category_blog)])->exists();
        
        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Danh mục bài viết này đã tồn tại!');
        }
        
        BlogCategory::create(['name_category_blog' => $request->name_category_blog]);
        return redirect()->route('admin.blogCategory')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);
        return view('admin.pages.blogCategory.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_category_blog' => 'required|string|max:255',
        ]);
        
        $category = BlogCategory::findOrFail($id);
        
        // Kiểm tra nếu tên không thay đổi thì không cần kiểm tra trùng
        if (strtolower($category->name_category_blog) !== strtolower($request->name_category_blog)) {
            // Kiểm tra xem danh mục đã tồn tại chưa (không phân biệt hoa thường)
            $exists = BlogCategory::whereRaw('LOWER(name_category_blog) = ?', [strtolower($request->name_category_blog)])
                                ->where('id', '!=', $id)
                                ->exists();
            
            if ($exists) {
                return redirect()->back()->withInput()->with('error', 'Danh mục bài viết này đã tồn tại!');
            }
        }
        
        $category->update(['name_category_blog' => $request->name_category_blog]);
        return redirect()->route('admin.blogCategory')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = BlogCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.blogCategory')->with('success', 'Xóa danh mục thành công!');
    }
}
