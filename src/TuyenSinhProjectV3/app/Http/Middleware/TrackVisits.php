<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\user\VisitController;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track visits for GET requests to prevent double counting
        if ($request->isMethod('get') && !$request->ajax()) {
            // Ignore certain routes/bots if needed (optional)
            $userAgent = $request->header('User-Agent');
            $isBot = preg_match('/bot|crawl|slurp|spider|googlebot/i', $userAgent);
            
            if (!$isBot) {
                // Record the visit
                VisitController::recordVisit($request);
            }
        }
        
        // Pass the request to the next middleware/controller
        return $next($request);
    }
}
