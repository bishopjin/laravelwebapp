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
    	'item_id',
        'item_qty',
        'item_price',
    	'order_coupon_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function coupon()
    {
        return $this->belongsTo(OrderCoupon::class);
    }

    /* polymorphic t=relationship s*/
    public function orderable()
    {
        return $this->morphTo();
    }
}
