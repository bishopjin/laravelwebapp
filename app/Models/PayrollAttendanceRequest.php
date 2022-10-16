<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollAttendanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
    	'payroll_attendance_id',
    	'employee_id', 
    	'approver_id',
    	'time_in',
        'time_out_break',
        'time_in_break',
    	'time_out',
    	'remarks',
        'status',
    ];

    protected $attributes = [
        'status' => 0;
    ];

    public function user()
    {
    	return $this->belongsTo(User::class, 'approver_id')->withTrashed();
    }

    public function employee()
    {
    	return $this->belongsTo(User::class, 'employee_id')->withTrashed();
    }

    public function attendance()
    {
        return $this->belongsTo(PayrollAttendance::class, 'payroll_attendance_id');
    }
}
