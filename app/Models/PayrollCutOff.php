<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollCutOff extends Model
{
    use HasFactory;

    protected $fillable = ['cut_off', 'user_id', 'payroll_salary_grade_id'];

    protected $hidden = ['created_at', 'updated_at'];

    public function userprofile()
    {
    	return $this->belongsTo(UsersProfile::class, 'user_id', 'user_id');
    }

    public function salarygrade()
    {
    	return $this->belongsTo(PayrollSalaryGrade::class, 'payroll_salary_grade_id', 'id');
    }

    public function payrollattendance()
    {
        return $this->hasMany(PayrollAttendance::class);
    }

    public function payslip()
    {
        return $this->hasMany(PayrollPayslip::class);
    }
}