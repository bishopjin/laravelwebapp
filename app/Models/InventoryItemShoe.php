<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemShoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'itemID',
    	'inventory_item_brand_id', 
    	'inventory_item_size_id', 
    	'inventory_item_color_id', 
    	'inventory_item_type_id', 
    	'inventory_item_category_id', 
    	'price'
    ];

    protected $attributes = [
    	'in_stock' => 0,
    ];
}
