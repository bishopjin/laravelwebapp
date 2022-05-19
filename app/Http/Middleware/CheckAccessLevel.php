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
        if(!str_contains($request->url(), 'admin') AND $request->user()->access_level === 1)
        {
            return redirect()->route('admin.index');
        }
        elseif(!str_contains($request->url(), 'faculty') AND $request->user()->access_level === 2)
        {
            return redirect()->route('faculty.index');
        }
        elseif(!str_contains($request->url(), 'student') AND $request->user()->access_level === 3)
        {
            return redirect()->route('student.index');
        }
        else
        {
            return $next($request);
        }
    }
}