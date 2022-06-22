<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollAttendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    
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
    ];

    public function payrollcutoff()
    {
    	return $this->belongsTo(PayrollCutOff::class, 'payroll_cut_off_id', 'id');
    }

    public function holiday()
    {
        return $this->belongsTo(PayrollHoliday::class, 'payroll_holiday_id', 'id');
    }

    public function workschedule()
    {
        return $this->belongsTo(PayrollWorkSchedule::class, 'payroll_work_schedule_id', 'id');
    }
}
