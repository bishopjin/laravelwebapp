<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\OnlineExamination;
use App\Models\OnlineExam;
use App\Models\OnlineCourse;
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamSelection; 

class StudentController extends Controller
{
    protected function Index(Request $request)
    {
        $user = User::find($request->user()->id)->userprofile;

    	$course = OnlineCourse::find($user->online_course_id);
        
    	$exam_result = OnlineExamination::with(['onlineexam'])->where('user_id', $request->user()->id)->get();

        $subjects = OnlineExam::with('onlinesubject')->get();
    	
    	return view('onlineexam.student.index')->with(compact('course', 'exam_result', 'subjects'));
    }

    protected function ShowExamination(Request $request)
    {
    	$find_exam = [];

        $user = User::find($request->user()->id)->userprofile;

        $course = OnlineCourse::find($user->online_course_id);

    	$exams = OnlineExam::with('onlinesubject')
    			->where('online_exams.exam_code', $request->input('exam_code'))->get();
        
    	if (OnlineExamination::exists() AND $exams->count() > 0)
    	{
    		$find_exam = OnlineExamination::where('online_exam_id', $exams[0]->id)->get();
    	}

    	$validator = Validator::make($request->all(), [
    		'exam_code' => 'required|string|max:50',
    	]);

    	if ($validator->fails()) {
            return redirect()->route('online.student.index')->withErrors($validator)->withInput();
        }
        else
        {
            if(count($find_exam) > 0)
            {
                $exam_taken = ['exam_taken' => 'Examination code is already answered.'];
                return redirect()->route('online.student.index')->withErrors($exam_taken)->withInput();
            }
            elseif($exams->count() == 0)
            {
                $exam_taken = ['exam_taken' => 'Invalid Examination code.'];
                return redirect()->route('online.student.index')->withErrors($exam_taken)->withInput();
            }
            else {
                /* randomize the order of question and selection every request */
                $questions = OnlineExamQuestion::with('examselection')
                        ->where('online_exam_id', $exams[0]->id)->select('id', 'question')
                        ->get()->shuffle();
                
                return view('onlineexam.student.examination')->with(compact('questions', 'exams', 'course'));
            }
        }
    }

    protected function SaveExamination(Request $request)
    {
    	$score = 0;
    
    	$all_question = OnlineExamQuestion::where('online_exam_id', $request->input('exams_id'))
                        ->select('id', 'key_to_correct')->get();

    	foreach($all_question as $question)
    	{
    		if($request->input($question->id) === $question->key_to_correct)
    		{
    			$score++;
    		}
    	}
    	
    	$exam_result = OnlineExamination::create([
    		'online_exam_id' => $request->input('exams_id'),
    		'user_id' => $request->user()->id,
            'faculty_id' => $request->input('facultyID'),
    		'total_question' => $all_question->count(),
    		'exam_score' => $score
    	]);
    	return redirect()->route('online.student.index');
    }
}
