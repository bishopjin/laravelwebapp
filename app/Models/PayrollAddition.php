<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollAddition extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rate', 'amount'];

    protected $hidden = ['created_at', 'updated_at'];

    public function salaryaddition()
    {
    	return $this->hasMany(PayrollSalaryAddition::class);
    }
}
