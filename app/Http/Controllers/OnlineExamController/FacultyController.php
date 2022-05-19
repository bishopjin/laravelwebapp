<?php

namespace App\Http\Controllers\OnlineExamController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Courses;
use App\Models\Exam;
use App\Models\ExamQuestions;
use App\Models\ExamSelections;
use App\Models\Subjects;

class FacultyController extends Controller
{
    protected function Index(Request $request)
    {
    	$exam_list = DB::table('exams')
    		->join('subjects', 'exams.subjects_id', '=', 'subjects.id')
			->where('exams.user_id', $request->user()->id)
			->select('exams.exam_code', 'exams.timer', 'subjects.subject')->paginate(10);

    	$student_list = DB::table('exams')
    		->join('exam_scores', 'exams.id', '=', 'exam_scores.exams_id')
    		->join('user', 'exam_scores.user_id', '=', 'user.id')
    		->join('course', 'user.course_id', '=', 'course.id')
    		->join('gender', 'user.gender_id', '=', 'gender.id')
            ->where('exams.user_id', $request->user()->id)
    		->select('user.id', 'user.lastname', 'user.middlename', 'user.firstname', 
                'course.course', 'gender.gender')->paginate(10);
        
    	return view('faculty.index')->with(compact('student_list', 'exam_list'));
    }

    protected function ShowScore(Request $request, $id)
    {
        $student_detail = User::select('lastname', 'middlename', 'firstname')->find($id);
        
        $exam_result = DB::table('exam_scores')
            ->join('exams', 'exam_scores.exams_id', '=', 'exams.id')
            ->where('exam_scores.user_id', '=', $id, 'AND', 'exams.user_id', '=', $request->user()->id)
            ->select('exams.exam_code', 'exam_scores.exam_score', 'exam_scores.total_question')->get();
        
        return view('faculty.examDetails')->with(compact('student_detail', 'exam_result'));
    }

    protected function ExaminationShow()
    {
    	if (Subjects::exists()) 
    	{
    		$subjects = Subjects::select('id', 'subject')->get();
    		return view('faculty.exam')->with(compact('subjects'));
    	}
    	else { return view('faculty.exam'); }
    	
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

        if (Subjects::exists()) 
        {
            $subjects = Subjects::where('id', $request->input('subject'))->select('subject')->get();
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

            $exam_code = Exam::create([
                'exam_code' => $gen_exam_code,
                'timer' => $request->input('examTimer'),
                'user_id' => $request->user()->id,
                'subjects_id' => $request->input('subject'),
            ]);

            $exam_code_id = $exam_code->id;
        }
    	
    	if ($exam_code_id > 0)
    	{
    		foreach ($data as $key => $value) {
	    		if (str_contains($key, 'question')) {
	    			$question = ExamQuestions::create([
	    				'exams_id' => $exam_code_id,
	    				'question' => $value,
	    			]);

	    			if ($question->id > 0) {
	    				$q_id = $question->id;
	    				$exam_created = true;
	    			}
	    			else { $exam_created = false; break; }
	    		}
	    		elseif (str_contains($key, 'answer')) {
	    			$answer = ExamQuestions::where('id', $q_id)
	    				->update(['key_to_correct' => Crypt::encryptString($value)]);

	    			if ($answer > 0) { $exam_created = true; }
	    			else { $exam_created = false; break; }
	    		}
	    		elseif (str_contains($key, 'selection')) {
	    			$selection = ExamSelections::create([
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

    	return view('faculty.exam')->with(compact('exam_status'));
    }

    protected function ExaminationView(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'exam_code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('faculty.exam')->withErrors($validator)->withInput();
        }
        else {
        	$exam_code = $request->input('exam_code');

        	$exams = Exam::where('exam_code', $exam_code)->get()->shuffle();

        	if ($exams->count() > 0) {
        		$examQuestions = ExamQuestions::where('exams_id', $exams[0]['id'])
	        		->select('id', 'question', 'key_to_correct')
                    ->get()->shuffle()
                    ->map(function($key_answer) {
                        $key_answer->key_to_correct = Crypt::decryptString($key_answer->key_to_correct);
                        return $key_answer;
                    });

	        	$examSelection = ExamSelections::where('exams_id', $exams[0]['id'])
	        		->select('id', 'exam_questions_id', 'selection')->get()->shuffle();

	        	return view('faculty.exam')->with(compact('exams', 'examQuestions', 'examSelection', 'exam_code'));
        	}
        	else {
        		return view('faculty.exam')->with(compact('exams', 'exam_code'));
        	}
        }
    }

    protected function ExaminationUpdate(Request $request)
    {
    	$new_key = $request->input('key_to_correct');

    	$update_key = ExamQuestions::where('id', intval($request->input('id')))
    		->update(['key_to_correct' => Crypt::encryptString($request->input('key_to_correct'))]);

    	return response()->json($new_key);
    }

    protected function ShowSubject(Request $request)
    {
    	if(Subjects::exists())
    	{
    		$subject_list = Subjects::select('subject')->paginate(10);

    		return view('faculty.subject')->with(compact('subject_list'));
    	}
    	else { return view('faculty.subject'); }
    }

    protected function SaveSubject(Request $request)
    {
    	$validator = Validator::make($request->all(), [
                'subject' => 'required|string|unique:subjects|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('subject.show')->withErrors($validator)->withInput();
        }
        else {
        	$subject_add = Subjects::create([
        			'subject' => $request->input('subject'),
        			'user_id' => $request->user()->id,
        		]);
        	return redirect()->back();
        }
    }
}
