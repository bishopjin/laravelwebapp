<?php

namespace App\Http\Controllers\OnlineExamController\api\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OnlineCourse;

class ApiCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OnlineCourse::where('id', '>', 1)->select('id', 'course')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'course' => ['required', 'string', 'unique:online_courses', 'max:255'],
        ]);

        if (!$validator->fails()) 
        {
             $addCourse = OnlineCourse::create(['course' => $request->input('course')]);
             $return = array('reqStatus' => 1, 'reqResponse' => $addCourse->id);
        }
        else
        {
            $return = array('reqStatus' => 0, 'reqResponse' => response()->json($validator->errors(), 500));
        }
        
        return response()->json($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return OnlineCourse::findOrFail($id);
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
        $validator = Validator::make($request->all(), [
                'course' => ['required', 'string', 'unique:online_courses', 'max:255'],
        ]);

        if (!$validator->fails()) 
        {
            $courseEdit = OnlineCourse::findOrFail($request->input('course_id'))
                ->update(['course' => $request->input('course')]);

            $return = array('reqStatus' => 1, 'reqResponse' => $courseEdit);
        }
        else
        {
            $return = array('reqStatus' => 0, 'reqResponse' => response()->json($validator->errors(), 500));
        }
        return response()->json($return);
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
