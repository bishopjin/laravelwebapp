<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryGradeRequest extends FormRequest
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
            'salary_grade' => ['required', 'string', 'max:255', 'unique:payroll_salary_grades'],
            'night_diff_applied' => ['accepted'],
            'overtime_applied' => ['accepted'],
            'cola_applied' => ['accepted'],
            'ecola_applied' => ['accepted'],
            'meal_allowance_applied' => ['accepted'],
        ];
    }
}
