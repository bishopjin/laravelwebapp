<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\OnlineCourse;
use App\Models\OnlineExam; 
use App\Models\OnlineExamScore;
use App\Models\OnlineExamQuestion;
use App\Models\OnlineExamSelection;
use App\Models\OnlineSubject;

class FacultyController extends Controller
{
    protected function Index(Request $request)
    {
    	$exam_list = OnlineExam::join('online_subjects', 'online_exams.online_subject_id', '=', 'online_subjects.id')
			->where('online_exams.user_id', $request->user()->id)
			->select('online_exams.exam_code', 'online_exams.timer', 'online_subjects.subject')->paginate(10);

    	$student_list = OnlineExam::join('online_exam_scores', 'online_exams.id', '=', 'online_exam_scores.online_exam_id')
    		->join('users', 'online_exam_scores.user_id', '=', 'users.id')
            ->join('users_profiles', 'users.id', '=', 'users_profiles.user_id')
    		->join('online_courses', 'users.online_course_id', '=', 'online_courses.id')
    		->join('genders', 'users.gender_id', '=', 'genders.id')
            ->where('online_exams.user_id', $request->user()->id)
    		->select('users.id', 'users_profiles.lastname', 'users_profiles.middlename', 
                    'users_profiles.firstname', 'course.course', 'gender.gender')->paginate(10);
        
    	return view('onlineexam.faculty.index')->with(compact('student_list', 'exam_list'));
    }

    protected function ShowScore(Request $request, $id)
    {
        $student_detail = User::select('lastname', 'middlename', 'firstname')->find($id);
        
        $exam_result = OnlineExamScore::join('online_exams', 'online_exam_scores.online_exam_id', '=', 'online_exams.id')
            ->where('online_exam_scores.user_id', '=', $id, 'AND', 'online_exams.user_id', '=', $request->user()->id)
            ->select('online_exams.exam_code', 'online_exam_scores.exam_score', 'online_exam_scores.total_question')->get();
        
        return view('onlineexam.faculty.examDetails')->with(compact('student_detail', 'exam_result'));
    }

    protected function ExaminationShow()
    {
    	if (OnlineSubject::exists()) 
    	{
    		$subjects = OnlineSubject::select('id', 'subject')->get();
    		return view('onlineexam.faculty.exam')->with(compact('subjects'));
    	}
    	else { return view('onlineexam.faculty.exam'); }
    	
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

        if (OnlineSubject::exists()) 
        {
            $subjects = OnlineSubject::where('id', $request->input('subject'))->select('subject')->get();
        }

        if ($subjects)
        {
            $randomChar = '';

            /* generate code */
            for ($i = 0; $i < 15; $i++) 
            {
                $randomChar .= $characters[rand(0, $charactersLength - 1)];
            }

            $gen_exam_code = $subjects[0]['subject'].'-'.$randomChar;

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
	    			$answer = OnlineExamQuestion::where('id', $q_id)
	    				->update(['key_to_correct' => Crypt::encryptString($value)]);

	    			if ($answer > 0) { $exam_created = true; }
	    			else { $exam_created = false; break; }
	    		}
	    		elseif (str_contains($key, 'selection')) {
	    			$selection = OnlineExamSelection::create([
	    				'exam_questions_id' => $q_id,
                        'exams_id' => $exam_code_id,
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

    	return view('onlineexam.faculty.exam')->with(compact('exam_status'));
    }

    protected function ExaminationView(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'exam_code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.faculty.exam')->withErrors($validator)->withInput();
        }
        else {
        	$exam_code = $request->input('exam_code');

        	$exams = OnlineExam::where('exam_code', $exam_code)->get()->shuffle();

        	if ($exams->count() > 0) {
        		$examQuestions = OnlineExamQuestion::where('online_exam_id', $exams[0]['id'])
	        		->select('id', 'question', 'key_to_correct')
                    ->get()->shuffle()
                    ->map(function($key_answer) {
                        $key_answer->key_to_correct = Crypt::decryptString($key_answer->key_to_correct);
                        return $key_answer;
                    });

	        	$examSelection = OnlineExamSelection::where('online_exam_id', $exams[0]->id)
	        		->select('id', 'online_exam_question_id', 'selection')->get()->shuffle();

	        	return view('onlineexam.faculty.exam')->with(compact('exams', 'examQuestions', 'examSelection', 'exam_code'));
        	}
        	else {
        		return view('onlineexam.faculty.exam')->with(compact('exams', 'exam_code'));
        	}
        }
    }

    protected function ExaminationUpdate(Request $request)
    {
    	$new_key = $request->input('key_to_correct');

    	$update_key = OnlineExamQuestion::where('id', intval($request->input('id')))
    		->update(['key_to_correct' => Crypt::encryptString($request->input('key_to_correct'))]);

    	return response()->json($new_key);
    }

    protected function ShowSubject(Request $request)
    {
    	if(OnlineSubject::exists())
    	{
    		$subject_list = OnlineSubject::select('subject')->paginate(10);

    		return view('onlineexam.faculty.subject')->with(compact('subject_list'));
    	}
    	else { return view('onlineexam.faculty.subject'); }
    }

    protected function SaveSubject(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'subject' => 'required|string|unique:online_subjects|max:255',
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
