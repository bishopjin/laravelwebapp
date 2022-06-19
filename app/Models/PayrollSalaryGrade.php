<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalaryGrade extends Model
{
    use HasFactory;

    protected $fillable = [
    	'salary_grade',
    	'night_diff_applied',
    	'overtime_applied',
    	'cola_applied',
    	'ecola_applied',
    	'meal_allowance_applied',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function payrollcutoff()
    {
    	return $this->hasMany(PayrollCutOff::class);
    }

    public function employee()
    {
        return $this->hasOne(PayrollEmployee::class);
    }
}
