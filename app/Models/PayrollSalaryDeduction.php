<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalaryDeduction extends Model
{
    use HasFactory;

    protected $fillable = [
    	'payroll_attendance_id',
    	'payroll_deduction_id',
    	'no_minutes',
    	'amount',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function payrollcutoff()
    {
    	return $this->belongsTo(PayrollCutOff::class, 'payroll_cut_off_id', 'id');
    }

    public function payrolldeduction()
    {
    	return $this->belongsTo(PayrollDeduction::class, 'payroll_deduction_id', 'id');
    }
}
