<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTax extends Model
{
    use HasFactory;

    protected $fillable = [
    	'tax', 
    	'percentage'
    ];

    protected $casts = [
    	'percentage' => 'float',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
