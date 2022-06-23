<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected function Index(Request $request)
    {
        if($request->user()->can('exam_admin_access')) 
        {
            return redirect()->route('online.admin.index');
        }
        elseif($request->user()->can('exam_faculty_access'))
        {
            return redirect()->route('online.faculty.index');
        }
        else
        {
            return redirect()->route('online.student.index');
        }
    }
}
