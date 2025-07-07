<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\admin\VisitAdminController;

class ReportAdminController extends Controller
{
    public function index()
    {

        $mostPopularMajorsFilter = [];
        $label = [];
    $view_major=[];

if ((request('year') || request('quarter')) && request('category_major_id')) {
    $year = request('year');
    $quarter = request('quarter');
    $category_major_id = request('category_major_id');

    $query = DB::table('majors')
        ->leftJoin('like_major_details', 'like_major_details.major_id', '=', 'majors.id')
        ->leftJoin('question_request', 'question_request.major_id', '=', 'majors.id')
        ->leftJoin('cities', 'question_request.city_id', '=', 'cities.id')
        ->select(
            'majors.id',
            'name_major',
            'view_major',
            DB::raw('COUNT(DISTINCT like_major_details.id) as total_like'),
            DB::raw('COUNT(DISTINCT question_request.id) as total_request'),
            DB::raw('GROUP_CONCAT(DISTINCT cities.name_city SEPARATOR ", ") as related_cities')
        )
        ->where('category_major_id',$category_major_id);

    if ($year) {
        $query->where(function ($q) use ($year) {
            $q->whereNull('like_major_details.date_like')
              ->orWhereYear('like_major_details.date_like', $year);
        });

        $query->where(function ($q) use ($year) {
            $q->whereNull('question_request.date_request')
              ->orWhereYear('question_request.date_request', $year);
        });
    }

    if ($quarter) {
        $monthRanges = [
            1 => [1, 3],
            2 => [4, 6],
            3 => [7, 9],
            4 => [10, 12],
        ];
        [$startMonth, $endMonth] = $monthRanges[$quarter];

        $query->where(function ($q) use ($startMonth, $endMonth) {
            $q->whereNull('like_major_details.date_like')
              ->orWhereRaw('MONTH(like_major_details.date_like) BETWEEN ? AND ?', [$startMonth, $endMonth]);
        });

        $query->where(function ($q) use ($startMonth, $endMonth) {
            $q->whereNull('question_request.date_request')
              ->orWhereRaw('MONTH(question_request.date_request) BETWEEN ? AND ?', [$startMonth, $endMonth]);
        });
    }

    $query->groupBy('majors.id', 'name_major', 'view_major')
    ->having('total_like','>',0)
        ->orHaving('total_request','>',0)
        ->orderByDesc('total_like')
        ->orderByDesc('total_request')
        ->orderByDesc('view_major');

    $mostPopularMajorsFilter = $query->get();
    $label = array_values($query->pluck('name_major')->toArray());
    $view_major = array_values($query->pluck('view_major')->toArray());
;
}



        // 3. Ngành học được quan tâm theo quý
        $mostPopularMajors = DB::table('majors')
            ->select(
                'name_major',
                'like_major',
                'view_major'
            )
            ->orderByDesc('like_major')
            ->orderByDesc('view_major')
            ->limit(5)
            ->get();
$dataMajorCategory = DB::table('category_major')
        ->select('*')
        ->where('status_category_major', 0)
        ->get();


        // Thống kê tổng quan
        $totalUsers = DB::table('users')->count();
        $totalMajors = DB::table('majors')->count();
        // Xử lý nếu chưa có bảng blog
        try {
            $totalBlogs = DB::table('blogs')->count();
        } catch (\Exception $e) {
            $totalBlogs = 0;
        }
        $totalMajorLikes = DB::table('majors')->sum('like_major');
        $totalMajorViews = DB::table('majors')->sum('view_major');

        // Thống kê top 5 bài viết được xem nhiều nhất
        $topBlogsQuery = DB::table('blogs')
            ->select('blogs.id', 'blogs.name_blog', 'blogs.view_blog', 'category_blog.name_category_blog')
            ->join('category_blog', 'blogs.category_blog_id', '=', 'category_blog.id');
        if (request('category_blog_id')) {
            $topBlogsQuery->where('blogs.category_blog_id', request('category_blog_id'));
        }
        $topBlogs = $topBlogsQuery->orderByDesc('blogs.view_blog')->limit(5)->get();

        // Chuẩn bị dữ liệu cityStats cho từng ngành BXH đã lọc
        $cityStats = [];
        // Lấy danh sách major_id cần thống kê (từ BXH đã lọc)
        $majorIds = collect($mostPopularMajorsFilter)->pluck('id')->all();
        if (!empty($majorIds)) {
            $cityData = DB::table('question_request')
                ->join('cities', 'question_request.city_id', '=', 'cities.id')
                ->select('question_request.major_id', 'cities.name_city', DB::raw('COUNT(*) as total'))
                ->whereIn('question_request.major_id', $majorIds)
                ->groupBy('question_request.major_id', 'cities.name_city')
                ->get();
            foreach ($cityData as $row) {
                $cityStats[$row->major_id][$row->name_city] = (int)$row->total;
            }
        }

        // Thống kê truy cập 14 ngày gần nhất
        $visitFilter = request('visit_filter', '14days');
        $visitFrom = request('visit_from');
        $visitTo = request('visit_to');
        $visitChart = VisitAdminController::getVisitChartDataByFilter($visitFilter, $visitFrom, $visitTo);

        return view('admin.pages.report.index', compact(
            'mostPopularMajors',
            'mostPopularMajorsFilter',
            'dataMajorCategory',
            'label',
            'view_major',
            'totalUsers',
            'totalMajors',
            'totalBlogs',
            'totalMajorLikes',
            'totalMajorViews',
            'topBlogs',
            'cityStats',
            'visitChart', 'visitFilter', 'visitFrom', 'visitTo',
        ));
    }
}
