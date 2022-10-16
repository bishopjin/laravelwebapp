<?php

namespace App\Http\Controllers\OnlineExamController\web\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnlineExam; 
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamSelection;
use App\Models\OnlineSubject;
use App\Http\Requests\ExamQuestionRequest;
use Illuminate\Support\Str;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = OnlineSubject::get();
        return view('onlineexam.faculty.exam')->with(compact('subjects'));
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
     * @param  \App\Http\Requests\ExamQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamQuestionRequest $request)
    {
        //dd($request->validated());
        if ($request->validated()) {
            $subjects = null;
            $examCodeId = 0;
            $examCreated = false;

            $subjects = OnlineSubject::findOrFail($request->input('online_subject_id'));
            
            if ($subjects) {
                $randomChar = Str::random(15);

                $genExamCode = $subjects->subject.'-'.$randomChar;

                $validated = $request->safe()
                    ->merge(array('exam_code' => $genExamCode, 'user_id' => $request->user()->id))
                    ->except(['question', 'answer', 'selection']);

                $examCode = OnlineExam::create($validated);
            }
        
            if ($examCode->id > 0) {
                foreach ($request->input('question') as $keyQ => $valueQ) {
                    $examCreated = false; 

                    /* Save the exam and correct answer */
                    $question = OnlineExamQuestion::create([
                        'question' => $valueQ,
                        'key_to_correct' => $request->input('answer')[$keyQ],
                        'online_exam_id' => $examCode->id
                    ]);
                    
                    if ($question->id > 0) {
                        foreach ($request->input('selection')[$keyQ] as $keyS => $valueS) {
                            /* Save the exam selection */
                            $selection = $question->examselection()->create([
                                'selection' => $valueS,
                            ]);

                            $examCreated = $selection->id > 0 ? true : false;
                        }
                    }
                }
            }
        
            $examStatus = $examCreated ? 'Examination created successfully.' : 'Failed to create examination.';

            return redirect()->back()->with('examStatus', $examStatus);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $subjects = OnlineSubject::select('id', 'subject')->get();

        $exams = OnlineExam::where([
            ['exam_code', '=',  $code], 
            ['user_id', '=', auth()->user()->id]
        ])->get();
            
        if ($exams->count() > 0) {
            $examQuestions = OnlineExamQuestion::where('online_exam_id', $exams[0]->id)->get();

            return view('onlineexam.faculty.exam')->with(compact('exams', 'examQuestions', 'code', 'subjects'));
        
        } else {
            return view('onlineexam.faculty.exam')->with(compact('exams', 'code', 'subjects'));
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
        $new_key = $request->input('key_to_correct');

        $update_key = OnlineExamQuestion::findOrFail($id)->update(['key_to_correct' => $new_key]);

        return response()->json($new_key);
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
