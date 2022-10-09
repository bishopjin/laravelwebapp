<?php

namespace App\Http\Controllers\OnlineExamController\api\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnlineExam;
use App\Models\OnlineExamination;

class ApiDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examList = OnlineExam::with('onlinesubject')
                        ->where('user_id', auth()->user()->id)->paginate(10, ['*'], 'exams');

        $studentList = OnlineExamination::with(['student.onlinecourse', 'student.gender'])
                        ->where('faculty_id', auth()->user()->id)->groupBy('user_id')->paginate(10, ['*'], 'list'); 
        
        return response()->json(array('examList' => $examList, 'studentList' => $studentList));
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
        return OnlineExamination::with(['student', 'onlineexam'])->where('user_id', $id)->get();
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
