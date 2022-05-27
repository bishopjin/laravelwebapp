<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected function Index(Request $request)
    {
        /* for standalone system */
        /*if($request->user()->access_level === 1) 
        {
            return redirect()->route('online.admin.index');
        }
        elseif($request->user()->access_level === 2)
        {
            return redirect()->route('online.faculty.index');
        }
        elseif($request->user()->access_level === 3)
        {
            return redirect()->route('online.student.index');
        }*/

        if(session('user_access') == '1') 
        {
            return redirect()->route('online.admin.index');
        }
        elseif(session('user_access') == '2')
        {
            return redirect()->route('online.faculty.index');
        }
        elseif(session('user_access') == '3')
        {
            return redirect()->route('online.student.index');
        }
    }
}
