<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemCategory extends Model
{
    use HasFactory;
    
    protected $fillable = ['category',];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function shoe()
    {
    	return $this->hasMany(InventoryItemShoe::class);
    }
}
