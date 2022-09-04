<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollEmployee extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = ['user_id', 'payroll_salary_grade_id', 'payroll_work_schedule_id', 'salary_rate', 'isActive'];

    protected $hidden = ['created_at', 'updated_at'];

    public function user()
    {
    	return $this->belongsTo(User::class)->withTrashed();
    }

    public function salarygrade()
    {
    	return $this->belongsTo(PayrollSalaryGrade::class, 'payroll_salary_grade_id');
    }

    public function workschedule()
    {
        return $this->belongsTo(PayrollWorkSchedule::class, 'payroll_work_schedule_id');
    }
}
