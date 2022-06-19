<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollWorkSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'schedule'];

    protected $hidden = ['created_at', 'updated_at'];

    public function employee()
    {
    	return $this->hasMany(PayrollEmployee::class);
    }

    public function attendance()
    {
    	return $this->hasMany(PayrollAttendance::class);
    }
}
