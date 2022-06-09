<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAccessLevelPayroll
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
        if (!str_contains($request->url(), 'admin') AND session('user_access') == '1')
        {
            return redirect()->route('payroll.admin.index');
        }
        elseif (!str_contains($request->url(), 'employee') AND session('user_access') == '2')
        {
            return redirect()->route('payroll.employee.index');
        }
        else
        {
            return $next($request);
        }
    }
}
