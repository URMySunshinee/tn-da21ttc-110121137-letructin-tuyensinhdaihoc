<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Major;
use App\Models\Blog;
use App\Models\Visit;
use App\Models\ChatAI;
use App\Models\CategoryMajor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeAdminController extends Controller
{
    public function index(){
        // Thống kê tổng quan - chỉ tính ngành học đang hoạt động
        $totalUsers = User::count();
        $totalMajors = Major::active()->count(); // Sử dụng scope active
        $totalBlogs = DB::table('blogs')->count(); // Sử dụng DB query thay vì model
        $totalViews = DB::table('visits')->count(); // Sử dụng DB query cho visits
        
        // Top 5 ngành học được quan tâm nhất (chỉ lấy ngành đang hoạt động)
        $topMajors = Major::active() // Sử dụng scope active
            ->with(['category'])
            ->withCount('likes') // Sử dụng withCount để đếm likes chính xác
            ->orderByDesc('likes_count')
            ->orderByDesc('view_major')
            ->limit(5)
            ->get()
            ->map(function ($major) {
                $major->like_major = $major->likes_count ?? 0; // Gán likes_count vào like_major để hiển thị
                return $major;
            });
        
        // Hoạt động gần đây
        $recentActivities = collect();
        
        // Chat AI gần đây (lấy 3 records)
        $recentChats = ChatAI::select('message_content as question', 'date_message')
            ->orderBy('date_message', 'desc')
            ->limit(3)
            ->get()
            ->map(function($item) {
                $item->type = 'chat';
                $item->created_at = Carbon::parse($item->date_message);
                $item->created_at_formatted = $item->created_at->format('d/m/Y H:i');
                return $item;
            });
        
        // Blog mới (lấy 3 records)
        $recentBlogs = Blog::select('name_blog as question', 'date_blog')
            ->orderBy('date_blog', 'desc')
            ->limit(3)
            ->get()
            ->map(function($item) {
                $item->type = 'blog';
                $item->created_at = Carbon::parse($item->date_blog);
                $item->created_at_formatted = $item->created_at->format('d/m/Y H:i');
                return $item;
            });
        
        // User mới (lấy 3 records)
        $recentUsers = User::select(DB::raw("CONCAT('Người dùng mới: ', name) as question"), 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function($item) {
                $item->type = 'user';
                $item->created_at = Carbon::parse($item->created_at);
                $item->created_at_formatted = $item->created_at->format('d/m/Y H:i');
                return $item;
            });
        
        // Merge tất cả activities và sort theo thời gian
        $allActivities = collect();
        $allActivities = $allActivities->merge($recentChats);
        $allActivities = $allActivities->merge($recentBlogs);
        $allActivities = $allActivities->merge($recentUsers);
        
        $recentActivities = $allActivities
            ->sortByDesc(function($item) {
                return $item->created_at->timestamp;
            })
            ->take(6) // Lấy 6 activities gần nhất
            ->values(); // Reset keys
        
        // Thống kê biểu đồ
        $visitsLast7Days = DB::table('visits')
            ->select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('visited_at', '>=', Carbon::now()->subDays(7))
            ->groupBy(DB::raw('DATE(visited_at)'))
            ->orderBy('date')
            ->get();

        // Nếu không có dữ liệu visits, tạo dữ liệu mẫu cho 7 ngày gần nhất
        if ($visitsLast7Days->isEmpty()) {
            $visitsLast7Days = collect();
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $visitsLast7Days->push((object)[
                    'date' => $date->format('Y-m-d'),
                    'count' => rand(50, 200) // Dữ liệu mẫu
                ]);
            }
        }

        $chartData = [
            'visits_last_7_days' => $visitsLast7Days,
            
            'majors_by_category' => CategoryMajor::with('majors')
                ->select('name_category_major as category')
                ->selectRaw('(SELECT COUNT(*) FROM majors WHERE majors.category_major_id = category_major.id AND majors.status_major = 0) as count')
                ->get(),
            
            'chat_activity_last_30_days' => ChatAI::select(DB::raw('DATE(date_message) as date'), DB::raw('COUNT(*) as count'))
                ->where('date_message', '>=', Carbon::now()->subDays(30))
                ->groupBy(DB::raw('DATE(date_message)'))
                ->orderBy('date')
                ->get()
        ];

        // Thống kê bổ sung - sử dụng Carbon để đảm bảo timezone đúng
        $today = Carbon::today(); // Hôm nay theo timezone Asia/Ho_Chi_Minh
        $startOfWeek = Carbon::now()->startOfWeek(); // Đầu tuần
        $endOfWeek = Carbon::now()->endOfWeek(); // Cuối tuần
        
        $todayStats = [
            'newUsersToday' => User::whereDate('created_at', $today)->count(),
            'blogsThisWeek' => DB::table('blogs')->whereBetween('date_blog', [$startOfWeek, $endOfWeek])->count(),
            'chatToday' => DB::table('chat_ai')->whereDate('date_message', $today)->count(),
            'visitsToday' => DB::table('visits')->whereDate('visited_at', $today)->count(),
            'totalChatAI' => DB::table('chat_ai')->count(),
        ];

        // Tính phần trăm tăng trưởng so với tháng trước
        $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $thisMonthStart = Carbon::now()->startOfMonth();
        $thisMonthEnd = Carbon::now()->endOfMonth();
        
        $lastMonthUsers = User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $thisMonthUsers = User::whereBetween('created_at', [$thisMonthStart, $thisMonthEnd])->count();
        $userGrowthPercent = $lastMonthUsers > 0 ? round((($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : 0;

        // Tính phần trăm tăng trưởng visits so với hôm qua
        $yesterday = Carbon::yesterday();
        $yesterdayVisits = DB::table('visits')->whereDate('visited_at', $yesterday)->count();
        $todayVisits = $todayStats['visitsToday'];
        $visitGrowthPercent = $yesterdayVisits > 0 ? round((($todayVisits - $yesterdayVisits) / $yesterdayVisits) * 100, 1) : 0;
        
        return view('admin.pages.home', compact(
            'totalUsers', 
            'totalMajors', 
            'totalBlogs', 
            'totalViews', 
            'topMajors', 
            'recentActivities',
            'chartData',
            'todayStats',
            'userGrowthPercent',
            'visitGrowthPercent'
        ));
    }
}
