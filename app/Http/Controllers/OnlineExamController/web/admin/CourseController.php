<?php

namespace App\Http\Controllers\OnlineExamController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\OnlineCourse;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (OnlineCourse::exists()) {
            $courseList = OnlineCourse::where('id', '>', 1)->select('id', 'course')->paginate(10);

            return view('onlineexam.admin.course')->with(compact('courseList'));
        }
        else 
        {
            return view('onlineexam.admin.course');
        }
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
        $validator = Validator::make($request->all(), [
                'course' => ['required', 'string', 'unique:online_courses', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('online.course.show')->withErrors($validator)->withInput();
        }
        else
        {
            $addCourse = OnlineCourse::create(['course' => $request->input('course')]);

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

        if ($validator->fails()) {
            return redirect()->route('online.course.show')->withErrors($validator)->withInput();
        }
        else
        {
            $courseEdit = OnlineCourse::findOrFail($request->input('course_id'))
                ->update(['course' => $request->input('course')]);

            return redirect()->back();
        }
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
