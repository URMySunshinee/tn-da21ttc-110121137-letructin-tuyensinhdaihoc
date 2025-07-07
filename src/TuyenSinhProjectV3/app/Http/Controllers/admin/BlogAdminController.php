<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Đảm bảo đã import DB facade

class BlogAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('blogs')
            ->join('users', 'blogs.author_id', '=', 'users.id')
            ->join('category_blog', 'blogs.category_blog_id', '=', 'category_blog.id')
            ->select(
                'blogs.id',
                'blogs.image_blog',
                'blogs.status_blog',
                'blogs.name_blog',
                'blogs.description_blog',
                'blogs.date_blog',
                'blogs.view_blog',
                'users.name as author_name',
                'category_blog.name_category_blog',
                'blogs.category_blog_id'
            );
        if ($request->filled('category')) {
            $query->where('blogs.category_blog_id', $request->category);
        }
        $dataBlog = $query->orderByDesc('blogs.date_blog')->paginate(6)->appends($request->query());
        $dataCategoryBlog = DB::table('category_blog')->select('*')->get();
        return view('admin.pages.blog.index', compact('dataBlog', 'dataCategoryBlog'));
    }

    public function createBlog(Request $request)
    {
        // Khởi tạo path mặc định
        $path = '';

        // Xử lý tải lên ảnh
        if ($request->hasFile('image_blog1')) { // Chỉ kiểm tra hasFile, không cần kiểm tra != ''
            $request->validate([
                'image_blog1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $file = $request->file('image_blog1');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imagesSource'), $filename);
            $path = '/imagesSource/' . $filename;
        } else if ($request->filled('image_blog2')) { // Sử dụng filled để kiểm tra input có giá trị
            $path = $request->image_blog2;
        }

        try {
            DB::table('blogs')->insert([
                'name_blog' => $request->name_blog,
                'image_blog' => $path,
                'description_blog' => $request->description_blog,
                'content_blog' => $request->content_blog,
                'author_id' => Auth::user()->id,
                'category_blog_id' => $request->category_blog_id,
                'status_blog' => 0, // Thêm giá trị mặc định cho status_blog nếu chưa có
                'date_blog' => now(), // Thêm ngày tạo tự động nếu chưa có
                'view_blog' => 0, // Thêm view mặc định nếu chưa có
            ]);
            return back()->with('success', 'Tạo bài viết mới thành công!');
        } catch (\Exception $e) {
            // Log lỗi để dễ debug hơn
            \Log::error('Lỗi khi tạo bài viết: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi tạo bài viết: ' . $e->getMessage());
        }
    }

    public function updateView($id)
    {
        $dataBlog = DB::table('blogs')
            ->select('*')
            ->where('id', $id)
            ->first();

        if (!$dataBlog) {
            return redirect()->route('admin.blog')->with('error', 'Bài viết không tồn tại.');
        }

        $dataCategoryBlog = DB::table('category_blog')
            ->select('*')
            ->get();

        return view('admin.pages.blog.update', compact('dataBlog', 'dataCategoryBlog'));
    }

    public function updateBlog(Request $request, $id)
    {
        $path = '';
        $currentBlog = DB::table('blogs')->where('id', $id)->first();

        if (!$currentBlog) {
            return redirect()->route('admin.blog')->with('error', 'Bài viết không tồn tại để cập nhật.');
        }

        // Xử lý tải lên ảnh mới
        if ($request->hasFile('image_blog1')) {
            $request->validate([
                'image_blog1' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $file = $request->file('image_blog1');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('imagesSource'), $filename);
            $path = '/imagesSource/' . $filename;

            // Xóa ảnh cũ nếu có và là ảnh được upload
            if ($currentBlog->image_blog && strpos($currentBlog->image_blog, '/imagesSource/') === 0) {
                 @unlink(public_path($currentBlog->image_blog));
            }

        } else if ($request->filled('image_blog2')) {
            $path = $request->image_blog2;
        } else {
            // Nếu không có ảnh mới được upload hoặc từ URL, giữ lại ảnh cũ
            $path = $currentBlog->image_blog;
        }

        try {
            DB::table('blogs')
                ->where('id', $id)
                ->update([
                    'name_blog' => $request->name_blog,
                    'image_blog' => $path,
                    'description_blog' => $request->description_blog,
                    'content_blog' => $request->content_blog,
                    'category_blog_id' => $request->category_blog_id,
                ]);

            return redirect()->route('admin.blog')->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            \Log::error('Lỗi khi cập nhật bài viết: ' . $e->getMessage());
            return redirect()->route('admin.blog')->with('error', 'Có lỗi xảy ra khi cập nhật bài viết: ' . $e->getMessage());
        }
    }

    public function softDeleteBlog($id)
    {
        try {
            $affected = DB::table('blogs')
                ->where('id', $id)
                ->update(['status_blog' => 1]);

            if ($affected) {
                return back()->with('success', 'Vô hiệu hóa bài viết thành công!');
            } else {
                return back()->with('error', 'Không tìm thấy bài viết để xóa mềm hoặc đã được xóa.');
            }
        } catch (\Exception $e) {
            \Log::error('Lỗi khi xóa mềm bài viết: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi xóa mềm bài viết: ' . $e->getMessage());
        }
    }

    public function restoreBlog($id)
    {
        try {
            $affected = DB::table('blogs')
                ->where('id', $id)
                ->update(['status_blog' => 0]);

            if ($affected) {
                return back()->with('success', 'Đã khôi phục bài viết thành công!');
            } else {
                return back()->with('error', 'Không tìm thấy bài viết để khôi phục hoặc đã được khôi phục.');
            }
        } catch (\Exception $e) {
            \Log::error('Lỗi khi khôi phục bài viết: ' . $e->getMessage());
            return back()->with('error', 'Có lỗi xảy ra khi khôi phục bài viết: ' . $e->getMessage());
        }
    }

    public function getBlogByIdCategory(Request $request, $id)
    {
        $perPage = 9; // Giới hạn 9 bài viết mỗi trang

        if ($id == 0) {
            $dataBlog = DB::table('blogs')
                ->join('users', 'blogs.author_id', '=', 'users.id')
                ->join('category_blog', 'blogs.category_blog_id', '=', 'category_blog.id')
                ->where('blogs.status_blog', 0)
                ->select(
                    'blogs.id',
                    'blogs.image_blog',
                    'blogs.name_blog',
                    'blogs.description_blog',
                    'blogs.date_blog',
                    'blogs.view_blog',
                    'users.name as author_name',
                    'category_blog.name_category_blog'
                )
                ->orderByDesc('blogs.date_blog')
                ->limit($perPage)
                ->get();
        } else {
            $dataBlog = DB::table('blogs')
                ->join('users', 'blogs.author_id', '=', 'users.id')
                ->join('category_blog', 'blogs.category_blog_id', '=', 'category_blog.id')
                ->where('blogs.category_blog_id', $id)
                ->where('blogs.status_blog', 0)
                ->select(
                    'blogs.id',
                    'blogs.image_blog',
                    'blogs.name_blog',
                    'blogs.description_blog',
                    'blogs.date_blog',
                    'blogs.view_blog',
                    'users.name as author_name',
                    'category_blog.name_category_blog'
                )
                ->orderByDesc('blogs.date_blog')
                ->limit($perPage)
                ->get();
        }

        return response()->json([
            'dataBlog' => $dataBlog
        ]);
    }
}