<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBeverage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
    	'order_beverage_name_id' => 'integer',
    	'order_beverage_size_id' => 'integer',
    	'price' => 'float',
    ];
}
