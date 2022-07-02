<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemReceive extends Model
{
    use HasFactory;

    protected $fillable = [
    	'inventory_item_shoe_id', 
    	'qty', 
    	'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function shoe()
    {
    	return $this->belongsTo(InventoryItemShoe::class, 'inventory_item_shoe_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }
}
