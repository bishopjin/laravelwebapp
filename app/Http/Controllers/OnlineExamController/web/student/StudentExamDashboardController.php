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
use App\Http\Requests\ExaminationRequest;

class StudentExamDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('onlinecourse')->findOrFail(auth()->user()->id);

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
     * @param  \App\Http\Requests\ExaminationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExaminationRequest $request)
    {
        //dd($request->validated());
        if ($request->validated()) {
            $score = 0;

            $allQuestion = OnlineExamQuestion::where('online_exam_id', $request->input('online_exam_id'))
                ->select('id', 'key_to_correct')->get();

            foreach($allQuestion as $question) {
                if($question->key_to_correct == $request->input('answer')[$question->id]) {
                    $score++;
                }
            }

            $validated = $request->safe()->merge([
                'total_question' => $allQuestion->count(), 
                'exam_score' => $score,
                'user_id' => $request->user()->id,
            ])->except(['answer']); 

            $examResult = OnlineExamination::create($validated);

            return redirect()->route('studentexam.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $findExam = [];

        $user = User::with('onlinecourse')->findOrFail(auth()->user()->id);

        $course = $user->onlinecourse->course;

        $exams = OnlineExam::with('onlinesubject')->where('online_exams.exam_code', $code)->get();
        
        if (OnlineExamination::exists() AND $exams->count() > 0) {
            $findExam = OnlineExamination::where([
                ['online_exam_id', '=', $exams[0]->id],
                ['user_id', '=', auth()->user()->id]
            ])->get();
        }

        if($findExam->count() > 0) {
            $examTaken = ['examTaken' => 'Examination code is already answered.'];
            return redirect()->route('studentexam.index')->withErrors($examTaken)->withInput();

        } elseif($exams->count() == 0) {
            $examTaken = ['examTaken' => 'Invalid Examination code.'];
            return redirect()->route('studentexam.index')->withErrors($examTaken)->withInput();

        } else {
            /* randomize the order of question and selection every request */
            $questions = OnlineExamQuestion::with('examselection')->where('online_exam_id', $exams[0]->id)
                    ->select('id', 'question')->get()->shuffle();
            
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
