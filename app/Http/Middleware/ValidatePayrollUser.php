<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\PayrollEmployee; 

class ValidatePayrollUser
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
        $dtr = PayrollEmployee::with('workschedule')->where('user_id', $request->user()->id)->get();
        if($dtr->count() > 0) {
            return $next($request);
        } else {
            return redirect()->route('notregister.index');
        }
    }
}
