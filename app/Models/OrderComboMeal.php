<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderComboMeal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];

    protected $casts = [
    	'price' => 'float',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
