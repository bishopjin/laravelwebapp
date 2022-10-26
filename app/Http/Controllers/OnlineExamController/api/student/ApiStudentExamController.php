<?php

namespace App\Http\Controllers\OnlineExamController\api\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OnlineExamination;
use App\Models\OnlineExam;
use App\Models\OnlineExamQuestion;
use App\Http\Requests\ExaminationRequest;

class ApiStudentExamController extends Controller
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
        
        return response()->json(array('course' => $course, 'examResult' => $examResult, 'subjects' => $subjects));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExaminationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExaminationRequest $request)
    {
        if ($request->validated()) {
            $score = 0;

            $allQuestion = OnlineExamQuestion::where('online_exam_id', $request->online_exam_id)
                ->select('id', 'key_to_correct')->get();

            foreach($allQuestion as $question) {
                if ($request->answer) {
                    if($question->key_to_correct == $request->answer[$question->id]) {
                        $score++;
                    }

                } else {
                    break;
                }
            }

            $validated = $request->safe()->merge([
                'total_question' => $allQuestion->count(), 
                'exam_score' => $score,
                'user_id' => $request->user()->id,
            ])->except(['answer']); 

            $examResult = OnlineExamination::create($validated);

            return response()->json($examResult->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $examcode
     * @return \Illuminate\Http\Response
     */
    public function show($examcode)
    {
        $findExam = [];

        $user = User::with('onlinecourse')->findOrFail(auth()->user()->id);

        $usersname = $user->FullName;

        $course = $user->onlinecourse->course;

        $exams = OnlineExam::with('onlinesubject')
                ->where('online_exams.exam_code', $examcode)->get();
        
        if (OnlineExamination::exists() AND $exams->count() > 0) {
            $findExam = OnlineExamination::where([
                ['online_exam_id', '=', $exams[0]->id],
                ['user_id', '=', auth()->user()->id]
            ])->get();
        }

        if(count($findExam) > 0) {
            $return = array('result' => 0, 'examTaken' => 'Examination code is already answered.');
        
        } elseif($exams->count() == 0) {
            $return = array('result' => 0, 'examTaken' => 'Invalid Examination code.');

        } else {
            /* randomize the order of question and selection every request */
            $questions = OnlineExamQuestion::with('examselection')->where('online_exam_id', $exams[0]->id)
                        ->select('id', 'question')->get()->shuffle();
            
            $return = array('result' => 1, 'questions' => $questions, 'exams' => $exams, 'course' => $course, 'name' => $usersname);
        }

        return response()->json($return);
    }
}
