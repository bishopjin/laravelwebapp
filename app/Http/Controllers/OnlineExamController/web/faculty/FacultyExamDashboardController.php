<?php

namespace App\Http\Controllers\OnlineExamController\web\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnlineExam;
use App\Models\OnlineExamination;

class FacultyExamDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examList = OnlineExam::with('onlinesubject')->where('user_id', auth()->user()->id)->latest()->paginate(10, ['*'], 'exams');

        $studentList = OnlineExamination::with(['student.onlinecourse', 'student.gender'])
                        ->where('faculty_id', auth()->user()->id)->groupBy('user_id')->latest()->paginate(10, ['*'], 'list'); 
        
        return view('onlineexam.faculty.index')->with(compact('examList', 'studentList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $examResult = OnlineExamination::with(['student', 'onlineexam'])->where('user_id', $id)->get();
        
        return view('onlineexam.faculty.examDetails')->with(compact('examResult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
