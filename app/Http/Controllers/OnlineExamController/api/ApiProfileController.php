<?php

namespace App\Http\Controllers\OnlineExamController\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ApiProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courses = OnlineCourse::get();

        $userDetails = User::find($id);
        
        return response()->json(array('userDetails' => $userDetails, 'courses' => $courses));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ProfileRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        $return = 0;

        if ($request->validated()) {

            $updated = User::find($id)->update($request->validated());

            $return = $updated;
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
