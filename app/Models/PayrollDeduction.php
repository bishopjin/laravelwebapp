<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDeduction extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rate', 'amount'];

    protected $hidden = ['created_at', 'updated_at'];

    public function salarydeduction()
    {
    	return $this->hasMany(PayrollSalaryDeduction::class);
    }

    public function payslip()
    {
    	return $this->hasOneThrough(PayrollPayslip::class, PayrollSalaryDeduction::class);
    }


    public function payroll_employee_salary_grade()
    {
        return $this->morphOne(PayrollEmployeeSalaryGrade::class, 'payroll_employee_salary_gradeable');
    }
}
