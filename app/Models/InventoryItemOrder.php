<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemOrder extends Model
{
    use HasFactory;

    protected $fillable = [
    	'order_number', 
    	'inventory_item_shoe_id', 
    	'qty', 
    	'order_by_id',
    ];

    protected $hidden = [
        'prepared_by_id',
        'released_by_id',
        'prepared_at',
        'released_at',
        'created_at',
        'updated_at',
    ];

    public function shoe()
    {
    	return $this->belongsTo(InventoryItemShoe::class, 'inventory_item_shoe_id', 'id');
    }

    public function userprofile()
    {
    	return $this->belongsTo(UsersProfile::class, 'order_by_id', 'user_id');
    }
}
