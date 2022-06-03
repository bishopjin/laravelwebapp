<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBeverage extends Model
{
    use HasFactory;

    protected $fillable = [
    	'order_beverage_name_id',
    	'order_beverage_size_id',
    	'price'
    ];

    protected $casts = [
    	'order_beverage_name_id' => 'integer',
    	'order_beverage_size_id' => 'integer',
    	'price' => 'float',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function beveragename()
    {
        return $this->belongsTo(OrderBeverageName::class, 'order_beverage_name_id', 'id');
    }

    public function beveragesize()
    {
        return $this->belongsTo(OrderBeverageSize::class, 'order_beverage_size_id', 'id');
    }
}
