<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemOrder extends Model
{
    use HasFactory;

    protected $fillable = [
    	'inventory_item_shoe_id', 
    	'qty', 
    	'user_id',
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
    	return $this->belongsTo(InventoryItemShoe::class, 'inventory_item_shoe_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}