<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DTRChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'remarks' => ['required', 'string'],
            'time_in' => ['required'],
            'time_out_break' => ['required'],
            'time_in_break' => ['required'],
            'time_out' => ['required'],
            'approver_id' => ['required'],
            'payroll_attendance_id' => ['required'],
        ];
    }
}
