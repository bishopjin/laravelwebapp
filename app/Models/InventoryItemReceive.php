<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemReceive extends Model
{
    use HasFactory;

    protected $fillable = ['inventory_item_shoe_id', 'qty', 'user_id',];
}
