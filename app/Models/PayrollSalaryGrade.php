<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSalaryGrade extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'area'];

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
