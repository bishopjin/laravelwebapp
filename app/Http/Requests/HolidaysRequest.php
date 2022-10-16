<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidaysRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:payroll_holidays'],
            'date' => ['required', 'string'],
            'is_legal' => ['accepted'],
            'is_local' => ['accepted'],
            'rate' => ['required', 'numeric'],
        ];
    }
}