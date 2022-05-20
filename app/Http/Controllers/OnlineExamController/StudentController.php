<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\ExamScore;
use App\Models\Courses;
use App\Models\ExamQuestions;
use App\Models\ExamSelections; 

class StudentController extends Controller
{
    protected function Index(Request $request)
    {
    	$course = Courses::select('course')->find($request->user()->course_id);
    	session(['course' => $course['course']]);
        
    	$exam_result = DB::table('exams')
    		->join('exam_scores', 'exams.id', '=', 'exam_scores.exams_id')
    		->join('subjects', 'exams.subjects_id', '=', 'subjects.id')
    		->where('exam_scores.user_id', $request->user()->id)
    		->select('exams.exam_code', 'subjects.subject', 'exam_scores.total_question', 'exam_scores.exam_score')->get();
   
    	return view('student.index')->with(compact('course', 'exam_result'));
    }

    protected function ShowExamination(Request $request)
    {
    	$find_exam = [];

    	$exams = DB::table('exams')
    			->join('subjects', 'exams.subjects_id', '=', 'subjects.id')
    			->where('exams.exam_code', $request->input('exam_code'))
    			->select('exams.id', 'exams.exam_code', 'subjects.subject', 'exams.timer')->get();
        
    	if (ExamScore::exists() AND $exams->count() > 0)
    	{
    		$find_exam = ExamScore::where('exams_id', $exams[0]->id)->get();
    	}

    	$validator = Validator::make($request->all(), [
    		'exam_code' => 'required|string|max:50',
    	]);

    	if ($validator->fails()) {
            return redirect()->route('student.index')->withErrors($validator)->withInput();
        }
        else
        {
            if(count($find_exam) > 0)
            {
                $exam_taken = ['exam_taken' => 'Examination code is already answered.'];
                return redirect()->route('student.index')->withErrors($exam_taken)->withInput();
            }
            elseif(count($exams) === 0)
            {
                $exam_taken = ['exam_taken' => 'Invalid Examination code.'];
                return redirect()->route('student.index')->withErrors($exam_taken)->withInput();
            }
            else {
                /* randomize the order of question and selection every request */
                $questions = ExamQuestions::where('exams_id', $exams[0]->id)->select('id', 'question')->get()->shuffle();
                $selections = ExamSelections::where('exams_id', $exams[0]->id)->select('exam_questions_id', 'selection')->get()->shuffle();
                    
                return view('student.examination')->with(compact('questions', 'selections', 'exams'));
            }
        }
    }

    protected function SaveExamination(Request $request)
    {
    	$score = 0;
   
    	$all_question = ExamQuestions::where('exams_id', $request->input('exams_id'))->select('id', 'key_to_correct')->get();

    	foreach($all_question as $question)
    	{
    		if($request->input($question->id) === Crypt::decryptString($question->key_to_correct))
    		{
    			$score++;
    		}
    	}
    	
    	$exam_result = ExamScore::create([
    		'exams_id' => $request->input('exams_id'),
    		'user_id' => $request->user()->id,
    		'total_question' => $all_question->count(),
    		'exam_score' => $score,
    	]);
    	return redirect()->route('student.index');
    }
}
