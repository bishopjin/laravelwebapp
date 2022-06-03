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

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
    	'in_stock' => 0,
    ];

    public function brand()
    {
        return $this->belongsTo(InventoryItemBrand::class, 'inventory_item_brand_id', 'id');
    }

    public function size()
    {
        return $this->belongsTo(InventoryItemSize::class, 'inventory_item_size_id', 'id');
    }

    public function color()
    {
        return $this->belongsTo(InventoryItemColor::class, 'inventory_item_color_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(InventoryItemType::class, 'inventory_item_type_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(InventoryItemCategory::class, 'inventory_item_category_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(InventoryItemOrder::class);
    }

    public function receive()
    {
        return $this->hasMany(InventoryItemReceive::class);
    }
}
