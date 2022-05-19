<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemOrder extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'inventory_item_shoe_id', 'qty', 'order_by_id',];
}
