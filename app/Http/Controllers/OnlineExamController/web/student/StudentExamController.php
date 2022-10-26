<?php

namespace App\Http\Controllers\OnlineExamController\web\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnlineExamination;
use App\Models\OnlineExam;

class StudentExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $course = User::with('onlinecourse')
            ->findOrFail(auth()->user()->id)
            ->onlinecourse
            ->course;
        
        $examResult = OnlineExamination::with(['onlineexam'])
            ->where('user_id', auth()->user()->id)
            ->latest()
            ->get();

        $subjects = OnlineExam::with('onlinesubject')->get();
        
        return view('onlineexam.student.index')->with(compact('course', 'examResult', 'subjects'));
    }
}
