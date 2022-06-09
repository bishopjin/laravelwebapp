<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
    	'payroll_cut_off_id',
        'payroll_holiday_id',
    	'attendance_date',
    	'time_in',
    	'time_out_break',
    	'time_in_break',
    	'time_out',
    	'manhour',
    	'overtime',
    	'night_diff',
    	'tardiness',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function payrollcutoff()
    {
    	return $this->belongsTo(PayrollCutOff::class, 'payroll_cut_off_id', 'id');
    }

    public function holiday()
    {
        return $this->belongsTo(PayrollHoliday::class, 'payroll_holiday_id', 'id');
    }
}
