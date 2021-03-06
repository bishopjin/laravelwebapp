<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OnlineExamination;
use App\Models\User;
use App\Models\OnlineExam; 
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamSelection;
use App\Models\OnlineSubject;

class FacultyController extends Controller
{
    protected function Index(Request $request)
    {
        $exam_list = OnlineExam::with('onlinesubject')
                        ->where('user_id', $request->user()->id)->paginate(10, ['*'], 'exams');

        $student_list = OnlineExamination::with(['student.onlinecourse', 'student.gender'])
                        ->where('faculty_id', $request->user()->id)->groupBy('user_id')->paginate(10, ['*'], 'list'); 
        
        return view('onlineexam.faculty.index')->with(compact('exam_list', 'student_list'));
    }

    protected function ShowScore(Request $request, $id)
    {
        $exam_result = OnlineExamination::with(['student', 'onlineexam'])->where('user_id', $id)->get();
        return view('onlineexam.faculty.examDetails')->with(compact('exam_result'));
    }

    protected function ExaminationShow(Request $request)
    {
    	$subjects = OnlineSubject::all();
        return view('onlineexam.faculty.exam')->with(compact('subjects'));
    }

    protected function ExaminationSave(Request $request)
    {
    	$data = $request->all();
    	$q_id = 0;
        $subjects = null;
        $exam_code_id = 0;
    	$exam_created = false;
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

            $gen_exam_code = $subjects->subject.'-'.$randomChar;

            $exam_code = OnlineExam::create([
                'exam_code' => $gen_exam_code,
                'timer' => $request->input('examTimer'),
                'user_id' => $request->user()->id,
                'online_subject_id' => $request->input('subject'),
            ]);

            $exam_code_id = $exam_code->id;
        }
    	
    	if ($exam_code_id > 0)
    	{
    		foreach ($data as $key => $value) {
	    		if (str_contains($key, 'question')) {
	    			$question = OnlineExamQuestion::create([
	    				'online_exam_id' => $exam_code_id,
	    				'question' => $value,
	    			]);

	    			if ($question->id > 0) {
	    				$q_id = $question->id;
	    				$exam_created = true;
	    			}
	    			else { $exam_created = false; break; }
	    		}
	    		elseif (str_contains($key, 'answer')) {
	    			$answer = OnlineExamQuestion::find($q_id)
	    				->update(['key_to_correct' => $value]);

	    			if ($answer > 0) { $exam_created = true; }
	    			else { $exam_created = false; break; }
	    		}
	    		elseif (str_contains($key, 'selection')) {
	    			$selection = OnlineExamSelection::create([
	    				'online_exam_question_id' => $q_id,
	    				'selection' => $value,
	    			]);

	    			if ($selection->id > 0) { $exam_created = true; }
	    			else { $exam_created = false; break; }
	    		}
	    	}
    	}
    
    	if ($exam_created) 
    	{
    		$exam_status = 'Examination created successfully.';
    	}
    	else { $exam_status = 'Failed to create examination.'; }

        return redirect()->back()->with('exam_status', $exam_status);
    }

    protected function ExaminationView(Request $request)
    {
        $subjects = OnlineSubject::select('id', 'subject')->get();

    	$validator = Validator::make($request->all(), [
                'exam_code' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.exam.show')->withErrors($validator)->withInput();
        }
        else {
        	$exam_code = $request->input('exam_code');

        	$exams = OnlineExam::where([['exam_code', '=',  $exam_code], ['user_id', '=', $request->user()->id]])->get();
            
        	if ($exams->count() > 0) {
        		$examQuestions = OnlineExamQuestion::where('online_exam_id', $exams[0]->id)->get();

	        	return view('onlineexam.faculty.exam')->with(compact('exams', 'examQuestions', 'exam_code', 'subjects'));
        	}
        	else {
        		return view('onlineexam.faculty.exam')->with(compact('exams', 'exam_code', 'subjects'));
        	}
        }
    }

    protected function ExaminationUpdate(Request $request)
    {
    	$new_key = $request->input('key_to_correct');

    	$update_key = OnlineExamQuestion::find($request->input('id'))
    		->update(['key_to_correct' => $request->input('key_to_correct')]);

    	return response()->json($new_key);
    }

    protected function ShowSubject(Request $request)
    {
    	$subject_list = OnlineSubject::select('subject')->paginate(10);
        return view('onlineexam.faculty.subject')->with(compact('subject_list'));
    }

    protected function SaveSubject(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'subject' => ['required', 'string', 'unique:online_subjects', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.subject.show')->withErrors($validator)->withInput();
        }
        else {
        	$subject_add = OnlineSubject::create([
        			'subject' => $request->input('subject'),
        			'user_id' => $request->user()->id,
        		]);
        	return redirect()->back();
        }
    }
}
