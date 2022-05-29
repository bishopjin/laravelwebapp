<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected function Index(Request $request)
    {
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
