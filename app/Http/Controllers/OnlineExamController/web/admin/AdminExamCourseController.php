<?php

namespace App\Http\Controllers\OnlineExamController\web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OnlineCourse;
use App\Http\Requests\ExamCourseRequest;

class AdminExamCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (OnlineCourse::exists()) {
            $courseList = OnlineCourse::where('id', '>', 1)
                ->select('id', 'course')
                ->latest()
                ->paginate(10)
                ->onEachSide(1);

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
     * @param  App\Http\Requests\ExamCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExamCourseRequest $request)
    {
        if ($request->validated()) {
            $addCourse = OnlineCourse::create($request->validated());

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
        $course = OnlineCourse::findOrFail($id)->only(['id', 'course']);

        $type = 'course';

        return view('onlineexam.edit')->with(compact('course', 'type'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ExamCourseRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExamCourseRequest $request, $id)
    {
        if ($request->validated()) {
            $courseEdit = OnlineCourse::findOrFail($id)->update($request->validated());

            return redirect()->route('courseexam.index');
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
