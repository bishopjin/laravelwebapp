<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    protected function Index(Request $request)
    {
        if($request->user()->access_level === 1)
        {
            return redirect()->route('admin.index');
        }
        elseif($request->user()->access_level === 2)
        {
            return redirect()->route('faculty.index');
        }
        elseif($request->user()->access_level === 3)
        {
            return redirect()->route('student.index');
        }
    }
}
