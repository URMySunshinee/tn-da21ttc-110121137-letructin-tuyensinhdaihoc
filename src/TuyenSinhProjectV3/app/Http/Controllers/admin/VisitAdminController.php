<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VisitAdminController extends Controller
{
    public static function getVisitChartData($days = 14)
    {
        $data = [];
        $labels = [];
        $now = Carbon::now();
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i)->format('Y-m-d');
            $labels[] = $now->copy()->subDays($i)->format('d/m');
            $data[] = DB::table('visits')
                ->whereDate('visited_at', $date)
                ->count();
        }
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public static function getVisitChartDataByFilter($filter = '14days', $from = null, $to = null)
    {
        $labels = [];
        $data = [];
        $now = Carbon::now();
        if ($filter === 'year') {
            // Thống kê theo từng tháng trong năm hiện tại
            for ($i = 1; $i <= 12; $i++) {
                $labels[] = sprintf('%02d/%d', $i, $now->year);
                $data[] = DB::table('visits')
                    ->whereYear('visited_at', $now->year)
                    ->whereMonth('visited_at', $i)
                    ->count();
            }
        } elseif ($filter === 'month') {
            // Thống kê theo từng ngày trong tháng hiện tại
            $daysInMonth = $now->daysInMonth;
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $labels[] = sprintf('%02d/%02d', $i, $now->month);
                $data[] = DB::table('visits')
                    ->whereYear('visited_at', $now->year)
                    ->whereMonth('visited_at', $now->month)
                    ->whereDay('visited_at', $i)
                    ->count();
            }
        } elseif ($filter === 'custom' && $from && $to) {
            // Thống kê theo từng ngày trong khoảng custom
            $fromDate = Carbon::parse($from);
            $toDate = Carbon::parse($to);
            $diff = $fromDate->diffInDays($toDate);
            for ($i = 0; $i <= $diff; $i++) {
                $date = $fromDate->copy()->addDays($i);
                $labels[] = $date->format('d/m');
                $data[] = DB::table('visits')
                    ->whereDate('visited_at', $date->format('Y-m-d'))
                    ->count();
            }
        } else {
            // Mặc định: 14 ngày gần nhất
            for ($i = 13; $i >= 0; $i--) {
                $date = $now->copy()->subDays($i);
                $labels[] = $date->format('d/m');
                $data[] = DB::table('visits')
                    ->whereDate('visited_at', $date->format('Y-m-d'))
                    ->count();
            }
        }
        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
