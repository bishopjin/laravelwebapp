<?php

namespace App\Http\Controllers\OnlineExamController\web\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnlineExamination;
use App\Models\OnlineExam;
use App\Models\OnlineCourse;
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamSelection; 

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('onlinecourse')->find(auth()->user()->id);
        $course = $user->onlinecourse->course;
        $examResult = OnlineExamination::with(['onlineexam'])->where('user_id', auth()->user()->id)->get();

        $subjects = OnlineExam::with('onlinesubject')->get();
        
        return view('onlineexam.student.index')->with(compact('course', 'examResult', 'subjects'));
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
        $score = 0;
        $allQuestion = OnlineExamQuestion::where('online_exam_id', $request->input('exams_id'))->select('id', 'key_to_correct')->get();

        foreach($allQuestion as $question)
        {
            if($request->input($question->id) === $question->key_to_correct)
            {
                $score++;
            }
        }
        
        $examResult = OnlineExamination::create([
            'online_exam_id' => $request->input('exams_id'),
            'user_id' => $request->user()->id,
            'faculty_id' => $request->input('facultyID'),
            'total_question' => $allQuestion->count(),
            'exam_score' => $score
        ]);
        return redirect()->route('online.student.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $findExam = [];

        $user = User::with('onlinecourse')->find(auth()->user()->id);
        $course = $user->onlinecourse->course;

        $exams = OnlineExam::with('onlinesubject')
                ->where('online_exams.exam_code', $id)->get();
        
        if (OnlineExamination::exists() AND $exams->count() > 0)
        {
            $findExam = OnlineExamination::where('online_exam_id', $exams[0]->id)->get();
        }

        if(count($findExam) > 0)
        {
            $examTaken = ['examTaken' => 'Examination code is already answered.'];
            return redirect()->route('online.student.index')->withErrors($examTaken)->withInput();
        }
        elseif($exams->count() == 0)
        {
            $examTaken = ['examTaken' => 'Invalid Examination code.'];
            return redirect()->route('online.student.index')->withErrors($exam_taken)->withInput();
        }
        else {
            /* randomize the order of question and selection every request */
            $questions = OnlineExamQuestion::with('examselection')
                    ->where('online_exam_id', $exams[0]->id)->select('id', 'question')->get()->shuffle();
            
            return view('onlineexam.student.examination')->with(compact('questions', 'exams', 'course'));
        }
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
