<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\auth;


class HomeUserController extends Controller
{
    public function index()
    {
        $dataMajor = DB::table('majors')
        ->select('id','name_major', 'description_major', 'date_updated')
        ->where('status_major', 0)
        ->orderBy('view_major', 'desc')
        ->limit(6)
        ->get();

        $dataMajorAll = DB::table('majors')
        ->select('id','name_major')
        ->where('status_major', 0)
        ->get();

        $dataCity = DB::table('cities')
        ->select('*')
        ->get();

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
    ->limit(3)
    ->get();

        return view('user.pages.index',compact('dataMajor','dataBlog','dataMajorAll','dataCity'));
    }
    public function majorList(){
        $dataMajor = DB::table('majors')
        ->select('id','name_major', 'description_major', 'date_updated')
        ->where('status_major', 0)
        ->orderBy('view_major', 'desc')
        ->get();

        // Lấy danh sách tất cả các category bất kể có ngành học hoạt động hay không
        $dataMajorCategory = DB::table('category_major')
        ->leftJoin('majors', function($join) {
            $join->on('category_major.id', '=', 'majors.category_major_id')
                 ->where('majors.status_major', 0);
        })
        ->select('category_major.*', DB::raw('COUNT(majors.id) as major_count'))
        ->where('category_major.status_category_major', 0)
        ->groupBy('category_major.id', 'category_major.name_category_major', 'category_major.status_category_major')
        ->get();

        return view('user.pages.major-list',compact('dataMajor','dataMajorCategory'));
    }
    public function blogList(Request $request){
        $perPage = 9; // Hiển thị tối đa 9 bài viết mỗi trang
        $categoryId = $request->get('category');

        $query = DB::table('blogs')
            ->join('users', 'blogs.author_id', '=', 'users.id')
            ->join('category_blog', 'blogs.category_blog_id', '=', 'category_blog.id')
            ->where('blogs.status_blog', 0);

        // Filter by category if specified
        if ($categoryId && $categoryId != '0') {
            $query->where('blogs.category_blog_id', $categoryId);
        }

        $dataBlog = $query->select(
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
            ->paginate($perPage);

        // Preserve category filter in pagination links
        if ($categoryId) {
            $dataBlog->appends(['category' => $categoryId]);
        }

        $dataBlogCategory = DB::table('category_blog')
            ->select('*')
            ->where('status_category_blog', 0)
            ->get();

        return view('user.pages.blog-list', compact('dataBlog', 'dataBlogCategory', 'categoryId'));
    }
    public function majorDetail($id){
        // Tạo một bản sao của date_updated hiện tại trước khi cập nhật
        $currentMajor = DB::table('majors')->where('id', $id)->first(['date_updated']);
        $currentDateUpdated = $currentMajor ? $currentMajor->date_updated : null;
        
        // Tăng lượt xem
        DB::statement("UPDATE majors SET view_major = view_major + 1 WHERE id = ?", [$id]);
        
        // Khôi phục date_updated về giá trị ban đầu
        if ($currentDateUpdated) {
            DB::statement("UPDATE majors SET date_updated = ? WHERE id = ?", [$currentDateUpdated, $id]);
        }
        
        $dataMajor = DB::table('majors')
        ->select('*')
        ->where('status_major', 0)
        ->where('id', $id)
        ->first();

        // Lấy thông tin phương thức xét tuyển của ngành học
        $admissionMethods = DB::table('major_admission_methods')
            ->join('admission_methods', 'major_admission_methods.admission_method_id', '=', 'admission_methods.id')
            ->where('major_admission_methods.major_id', $id)
            ->where('admission_methods.is_active', true)
            ->select('admission_methods.*')
            ->orderBy('admission_methods.priority_order')
            ->get();

        // Lấy tổ hợp môn đã được chọn cho ngành học này theo từng phương thức
        $subjectCombinations = collect();
        $subjectCombinationsByMethod = [];
        $hasMethodWithCombinations = $admissionMethods->where('requires_subject_combinations', true)->isNotEmpty();

        if ($hasMethodWithCombinations) {
            $allCombinations = DB::table('major_subject_combinations')
                ->join('subject_combinations', 'major_subject_combinations.subject_combination_id', '=', 'subject_combinations.id')
                ->leftJoin('admission_methods', 'major_subject_combinations.admission_method_id', '=', 'admission_methods.id')
                ->where('major_subject_combinations.major_id', $id)
                ->where('subject_combinations.is_active', true)
                ->select(
                    'subject_combinations.*',
                    'major_subject_combinations.min_score',
                    'major_subject_combinations.admission_method_id',
                    'admission_methods.name as admission_method_name'
                )
                ->orderBy('subject_combinations.priority_order')
                ->orderBy('subject_combinations.code')
                ->get();

            // Nhóm tổ hợp môn theo phương thức
            foreach ($allCombinations as $combination) {
                $methodId = $combination->admission_method_id;
                if (!isset($subjectCombinationsByMethod[$methodId])) {
                    $subjectCombinationsByMethod[$methodId] = collect();
                }
                $subjectCombinationsByMethod[$methodId]->push($combination);
            }

            // Để tương thích với code cũ, lấy tất cả tổ hợp môn (không phân biệt phương thức)
            $subjectCombinations = $allCombinations->unique('id');
        }

        // Lấy điểm chuẩn năm gần nhất (2024)
        $admissionScores = [];
        $currentYear = date('Y');
        $scores = DB::table('admission_scores')
            ->where('major_id', $id)
            ->where('year', $currentYear)
            ->get();

        foreach ($scores as $score) {
            $admissionScores[$score->admission_method_id] = $score->score;
        }

        return view('user.pages.major-detail', compact('dataMajor', 'admissionMethods', 'subjectCombinations', 'subjectCombinationsByMethod', 'admissionScores'));
    }
    public function blogDetail($id){
        try {
            // Debug: Log bắt đầu
            \Log::info('Blog detail started for ID: ' . $id);
            
            // Kiểm tra blog tồn tại trước
            $blogExists = DB::table('blogs')->where('id', $id)->where('status_blog', 0)->exists();
            if (!$blogExists) {
                \Log::warning('Blog not found: ' . $id);
                abort(404, 'Bài viết không tồn tại');
            }
            
            // Lưu thời gian cập nhật hiện tại - blogs không có updated_at
            // Chỉ tăng view_blog mà không cần lưu timestamp
            
            // Tăng lượt xem
            DB::statement("UPDATE blogs SET view_blog = view_blog + 1 WHERE id = ?", [$id]);

            \Log::info('View count updated successfully');

            // Get blog data - Đơn giản hóa query
            $dataBlog = DB::table('blogs')
                ->leftJoin('users', 'blogs.author_id', '=', 'users.id')
                ->leftJoin('category_blog', 'blogs.category_blog_id', '=', 'category_blog.id')
                ->where('blogs.status_blog', 0)
                ->where('blogs.id', $id)
                ->select(
                    'blogs.id',
                    'blogs.image_blog',
                    'blogs.name_blog',
                    'blogs.description_blog',
                    'blogs.date_blog',
                    'blogs.view_blog',
                    'blogs.content_blog',
                    'users.name as author_name',
                    'category_blog.name_category_blog as category_name',
                    'category_blog.id as category_id'
                )
                ->first();

            \Log::info('Main blog query completed');

            // Check if blog exists
            if (!$dataBlog) {
                \Log::warning('Blog data not found after query: ' . $id);
                abort(404, 'Bài viết không tồn tại');
            }

    // Lấy danh sách tất cả danh mục bài viết
    $dataBlogCategory = DB::table('category_blog')
        ->select('*')
        ->where('status_category_blog', 0)
        ->get();
        
    \Log::info('Categories loaded: ' . $dataBlogCategory->count());

    // Lấy 5 bài viết phổ biến nhất (lượt xem cao nhất)
    $popularBlogs = DB::table('blogs')
        ->leftJoin('users', 'blogs.author_id', '=', 'users.id')
        ->leftJoin('category_blog', 'blogs.category_blog_id', '=', 'category_blog.id')
        ->where('blogs.status_blog', 0)
        ->where('blogs.id', '!=', $id) // Loại trừ bài viết hiện tại
        ->select(
            'blogs.id',
            'blogs.image_blog',
            'blogs.name_blog',
            'blogs.view_blog',
            'blogs.date_blog'
        )
        ->orderByDesc('blogs.view_blog')
        ->limit(5)
        ->get();
        
    \Log::info('Popular blogs loaded: ' . $popularBlogs->count());

    // Lấy 5 bài viết mới nhất
    $latestBlogs = DB::table('blogs')
        ->leftJoin('users', 'blogs.author_id', '=', 'users.id')
        ->leftJoin('category_blog', 'blogs.category_blog_id', '=', 'category_blog.id')
        ->where('blogs.status_blog', 0)
        ->where('blogs.id', '!=', $id) // Loại trừ bài viết hiện tại
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
        ->limit(5)
        ->get();
        
    \Log::info('Latest blogs loaded: ' . $latestBlogs->count());
    \Log::info('About to render view');

            return view('user.pages.blog-detail', compact('dataBlog', 'dataBlogCategory', 'popularBlogs', 'latestBlogs'));

        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Blog detail error: ' . $e->getMessage());
            \Log::error('Blog detail stack trace: ' . $e->getTraceAsString());
            
            // Trả về view với thông báo lỗi thay vì abort
            return view('user.pages.blog-detail', [
                'dataBlog' => null,
                'dataBlogCategory' => collect([]),
                'popularBlogs' => collect([]),
                'latestBlogs' => collect([])
            ]);
        }
    }
    public function aiChat(){
        return view('user.pages.Ai-asisst');
    }

    /**
     * Hiển thị trang thông tin xét tuyển
     */
    public function admissionInfo()
    {
        return view('user.pages.admission-info');
    }

    /**
     * Hiển thị trang chi tiết thông tin xét tuyển theo section
     */
    public function admissionDetail($section)
    {
        $title = '';
        
        // Đặt tiêu đề dựa trên section
        switch ($section) {
            case 'targets':
                $title = 'Đối tượng, vùng và chỉ tiêu tuyển sinh';
                break;
            case 'majors':
                $title = 'Danh mục Ngành, tổ hợp và chỉ tiêu tuyển sinh';
                break;
            case 'methods':
                $title = 'Phương thức xét tuyển';
                break;
            case 'timeline':
                $title = 'Thời gian tuyển sinh';
                break;
            case 'policy':
                $title = 'Chính sách ưu tiên';
                break;
            case 'important-dates':
                $title = 'Các mốc thời gian xét tuyển đại học 2025';
                break;
            default:
                $title = 'Thông tin xét tuyển chi tiết';
        }
        
        // Trả về view với section và title
        // Lưu ý: File view chi tiết sẽ được tạo sau theo yêu cầu của bạn
        return view('user.pages.admission-info', compact('section', 'title'));
    }
    /**
     * Hiển thị trang giới thiệu về trường
     */
    public function aboutUs()
    {
        return view('user.pages.about-us');
    }
}
