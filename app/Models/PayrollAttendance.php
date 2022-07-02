<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollAttendance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
    	'payroll_cut_off_id',
        'payroll_holiday_id',
        'payroll_work_schedule_id',
    	'time_in',
    	'time_out_break',
    	'time_in_break',
    	'time_out',
    	'manhour',
    	'overtime',
    	'night_diff',
    	'tardiness',
        'changeRequest',
        'payroll_payslip_id',
    ];

    public function payrollcutoff()
    {
    	return $this->belongsTo(PayrollCutOff::class, 'payroll_cut_off_id');
    }

    public function holiday()
    {
        return $this->belongsTo(PayrollHoliday::class, 'payroll_holiday_id');
    }

    public function workschedule()
    {
        return $this->belongsTo(PayrollWorkSchedule::class, 'payroll_work_schedule_id');
    }

    public function attendancerequest()
    {
        return $this->hasOne(PayrollAttendanceRequest::class);
    }

    public function payslip()
    {
        return $this->belongsTo(PayrollPayslip::class, 'payroll_payslip_id');
    }

    public function payrollsalarydeduction()
    {
        return $this->belongsToMany(PayrollSalaryDeduction::class, 'payroll_salary_deductions');
    }

    public function payrollsalaryaddition()
    {
        return $this->belongsToMany(PayrollSalaryAddition::class, 'payroll_salary_additions');
    }
}
