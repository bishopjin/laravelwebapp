<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollEmployeeSalaryGrade extends Model
{
    use HasFactory;

    protected $fillable = [
    	'payroll_employee_id',
    	'payroll_salary_grade_id',
    	'payroll_employee_salary_gradeable_id',
    	'payroll_employee_salary_gradeable_type',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function payroll_employee_salary_gradeable()
    {
    	return $this->morphTo();
    }
}
