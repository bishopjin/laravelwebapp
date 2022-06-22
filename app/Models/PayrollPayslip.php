<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPayslip extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'user_id',
    	'payroll_cut_off_id',
    	'total_manhour',
    	'payroll_salary_addition_id',
    	'total_addition',
    	'payroll_salary_deduction_id',
    	'total_deduction',
    ];

    protected $hidden = ['updated_at'];

    public function payrollcutoff()
    {
    	return $this->belongsTo(PayrollCutOff::class, 'payroll_cut_off_id', 'id');
    }

    public function salaryaddition()
    {
    	return $this->belongsTo(PayrollSalaryAddition::class, 'payroll_salary_addition_id', 'id');
    }

    public function salarydeduction()
    {
    	return $this->belongsTo(PayrollSalaryDeduction::class, 'payroll_salary_deduction_id', 'id');
    }
}
