<?php

namespace App\Http\Controllers\OnlineExamController\api\faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OnlineExam; 
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamSelection;
use App\Models\OnlineSubject;

class ApiExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OnlineSubject::get();
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
        $data = $request->all();
        $qId = 0;
        $subjects = null;
        $examCodeId = 0;
        $examCreated = false;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        $subjects = OnlineSubject::find($request->input('subject'));
        
        if ($subjects)
        {
            $randomChar = '';

            /* generate code */
            for ($i = 0; $i < 15; $i++) 
            {
                $randomChar .= $characters[rand(0, $charactersLength - 1)];
            }

            $genExamCode = $subjects->subject.'-'.$randomChar;

            $examCode = OnlineExam::create([
                'exam_code' => $genExamCode,
                'timer' => $request->input('examTimer'),
                'user_id' => $request->user()->id,
                'online_subject_id' => $request->input('subject'),
            ]);

            $examCodeId = $examCode->id;
        }
        
        if ($examCodeId > 0)
        {
            foreach ($data as $key => $value) 
            {
                if (str_contains($key, 'question')) 
                {
                    $question = OnlineExamQuestion::create([
                        'online_exam_id' => $examCodeId,
                        'question' => $value,
                    ]);

                    if ($question->id > 0) 
                    {
                        $qId = $question->id;
                        $examCreated = true;
                    }
                    else 
                    { 
                        $examCreated = false; 
                        break; 
                    }
                }
                elseif (str_contains($key, 'answer')) 
                {
                    $answer = OnlineExamQuestion::find($qId)
                        ->update(['key_to_correct' => $value]);

                    if ($answer > 0) 
                    { 
                        $examCreated = true; 
                    }
                    else 
                    { 
                        $examCreated = false; 
                        break; 
                    }
                }
                elseif (str_contains($key, 'selection')) 
                {
                    $selection = OnlineExamSelection::create([
                        'online_exam_question_id' => $qId,
                        'selection' => $value,
                    ]);

                    if ($selection->id > 0)
                    { 
                        $examCreated = true; 
                    }
                    else
                    { 
                        $examCreated = false; 
                        break; 
                    }
                }
            }
        }
    
        if ($examCreated) 
        {
            $examStatus = array('reqStatus' => 1, 'reqMsg' => 'Examination created successfully.');
        }
        else
        { 
            $examStatus = rray('reqStatus' => 0, 'reqMsg' =>'Failed to create examination.'); 
        }

        return response()->json($examStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subjects = OnlineSubject::select('id', 'subject')->get();

        $exams = OnlineExam::where([['exam_code', '=',  $id], ['user_id', '=',auth()->user()->id]])->get();
            
        if ($exams->count() > 0) {
            $examQuestions = OnlineExamQuestion::where('online_exam_id', $exams[0]->id)->get();

            $return = array('exams' => $exams, 'examQuestions' => $examQuestions, 'examCode' => $id, 'subjects' => $subjects);
        }
        else {
            $return = array('exams' => $exams, 'examCode' => $id, 'subjects' => $subjects);
        }
        return response()->json($return);
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

        $update_key = OnlineExamQuestion::find($id)->update(['key_to_correct' => $new_key]);

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
