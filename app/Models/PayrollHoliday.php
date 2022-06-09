<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollHoliday extends Model
{
    use HasFactory;

    protected $fillable = [
    	'name',
    	'date',
    	'is_legal',
    	'is_local',
    	'rate',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function payrollattendance()
    {
    	return $this->hasMany(PayrollAttendance::class);
    }
}
