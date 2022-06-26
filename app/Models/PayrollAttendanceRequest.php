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

    public function userprofile()
    {
    	return $this->belongsTo(UsersProfile::class, 'approver_id', 'user_id');
    }

    public function employee()
    {
    	return $this->belongsTo(UsersProfile::class, 'employee_id', 'user_id');
    }

    public function attendance()
    {
        return $this->belongsTo(PayrollAttendance::class, 'payroll_attendance_id', 'id');
    }
}
