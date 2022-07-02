<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCoupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'discount'];

    protected $casts = [
    	'discount' => 'float',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function orderorder()
    {
    	return $this->hasMany(OrderOrder::class);
    }
}
