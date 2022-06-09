<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollEmployee extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'payroll_salary_grade_id', 'isActive'];

    protected $hidden = ['created_at', 'updated_at'];
}
