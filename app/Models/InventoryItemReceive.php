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
    	return $this->belongsTo(InventoryItemShoe::class, 'inventory_item_shoe_id', 'id');
    }

    public function userprofile()
    {
    	return $this->belongsTo(UsersProfile::class, 'user_id', 'user_id');
    }
}
