<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!str_contains($request->url(), 'admin') AND session('user_access') == '1')
        {
            return redirect()->route('online.admin.index');
        }
        elseif(!str_contains($request->url(), 'faculty') AND session('user_access') == '2')
        {
            return redirect()->route('online.faculty.index');
        }
        elseif(!str_contains($request->url(), 'student') AND session('user_access') == '3')
        {
            return redirect()->route('online.student.index');
        }
        else
        {
            return $next($request);
        }
    }
}
