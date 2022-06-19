<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected function Index(Request $request)
    {
        if($request->user()->hasRole('Admin')) 
        {
            return redirect()->route('online.admin.index');
        }
        elseif($request->user()->hasRole('Faculty'))
        {
            return redirect()->route('online.faculty.index');
        }
        elseif($request->user()->hasRole('Student'))
        {
            return redirect()->route('online.student.index');
        }
    }
}
