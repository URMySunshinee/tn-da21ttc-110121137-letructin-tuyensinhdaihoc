<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class checkRoleAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request  $request,$next)
    {
        if (!Auth::check()) {
            return redirect('/'); 
        }else{
            if(Auth::user()->role!==1){
                if(Auth::user()->role==0){
                    return redirect('/'); 
                }else{
                    return redirect('/'); 
                }
            }
            return $next($request); 
        }
    }
}
