<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollUserRegisterRequest extends FormRequest
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
            'user_id' => ['required', 'numeric'],
            'payroll_salary_grade_id' => ['required', 'numeric'],
            'payroll_work_schedule_id' => ['required', 'numeric'],
            'salary_rate' => ['required', 'numeric'],
        ];
    }
}
