<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VisitController extends Controller
{
    public static function recordVisit(Request $request)
    {
        try {
            $now = now();
            \Log::debug("VisitController:recordVisit - Starting visit check");
            
            // Set a session flag to avoid counting refreshes as multiple visits
            if (!$request->session()->has('visit_recorded')) {
                \Log::debug("VisitController:recordVisit - New visit recorded (no existing session)");
                DB::table('visits')->insert([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'visited_at' => $now,
                ]);
                
                // Store timestamp instead of Carbon object to avoid serialization issues
                $request->session()->put('visit_recorded', true);
                $request->session()->put('visit_recorded_expiry', $now->addMinutes(1)->timestamp);
                
                \Log::debug("VisitController:recordVisit - Session set with expiry: " . $now->timestamp);
            } else {
                // Check if the expiry time has passed (using timestamps)
                $expiryTimestamp = $request->session()->get('visit_recorded_expiry');
                \Log::debug("VisitController:recordVisit - Existing session found with expiry: " . $expiryTimestamp . ", current: " . $now->timestamp);
                
                if ($expiryTimestamp && $now->timestamp > $expiryTimestamp) {
                    \Log::debug("VisitController:recordVisit - Session expired, recording new visit");
                    // If expired, record a new visit and reset the timer
                    DB::table('visits')->insert([
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->header('User-Agent'),
                        'visited_at' => $now,
                    ]);
                    $request->session()->put('visit_recorded_expiry', $now->addMinutes(1)->timestamp);
                } else {
                    \Log::debug("VisitController:recordVisit - Session still valid, no new visit recorded");
                }
            }
        } catch (\Exception $e) {
            // Log error but don't interrupt the user's experience
            \Log::error('Failed to record visit: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
        }
    }

    public static function getVisitStats()
    {
        try {
            $now = Carbon::now();
            $today = $now->copy()->startOfDay();
            $yesterday = $now->copy()->subDay()->startOfDay();
            $week = $now->copy()->startOfWeek();
            $month = $now->copy()->startOfMonth();
            $year = $now->copy()->startOfYear();

            return [
                'today' => DB::table('visits')->where('visited_at', '>=', $today)->count(),
                'yesterday' => DB::table('visits')->whereBetween('visited_at', [$yesterday, $today])->count(),
                'week' => DB::table('visits')->where('visited_at', '>=', $week)->count(),
                'month' => DB::table('visits')->where('visited_at', '>=', $month)->count(),
                'year' => DB::table('visits')->where('visited_at', '>=', $year)->count(),
                'all' => DB::table('visits')->count(),
            ];
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Failed to get visit stats: ' . $e->getMessage());
            
            // Return default values
            return [
                'today' => 0,
                'yesterday' => 0,
                'week' => 0,
                'month' => 0,
                'year' => 0,
                'all' => 0
            ];
        }
    }
}
