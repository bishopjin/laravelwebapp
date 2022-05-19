<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOrder extends Model
{
    use HasFactory;

    protected $fillable = [
    	'order_number',
    	'user_id',
    	'order_burger_id',
    	'burgers_qty',
    	'order_beverage_id',
    	'beverages_qty',
    	'order_combo_meal_id',
    	'combo_meals_qty',
    	'order_coupon_id',
    ];
}
