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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjectList = OnlineSubject::select(['id', 'subject'])->get();

        return view('onlineexam.faculty.exam')->with(compact('subjectList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ExamQuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamQuestionRequest $request)
    {
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
        
            return redirect()->route('facultyexam.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exams = auth()->user()->onlineexam()->findOrFail($id);
            
        $examQuestions = OnlineExamQuestion::where('online_exam_id', $exams->id)->get();

        return view('onlineexam.faculty.examPreview')->with(compact('exams', 'examQuestions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exams = auth()->user()->onlineexam()->findOrFail($id);

        $subjectList = OnlineSubject::select(['id', 'subject'])->get();

        return view('onlineexam.faculty.examEdit')->with(compact('exams', 'subjectList'));
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
        $validated = $request->validate([
            'online_subject_id' => ['required', 'numeric'],
            'timer' => ['required', 'numeric'],
        ]);

        if ($validated) {
            $subjects = OnlineSubject::findOrFail($request->input('online_subject_id'));
             
            if ($subjects) {
                $randomChar = Str::random(15);

                $genExamCode = $subjects->subject.'-'.$randomChar;

                OnlineExam::find($id)->update([
                    'online_subject_id' => $request->input('online_subject_id'),
                    'timer' => $request->input('timer'),
                    'exam_code' => $genExamCode
                ]);
            }
        }

        return redirect()->route('facultyexam.index');
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
