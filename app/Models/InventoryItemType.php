<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemType extends Model
{
    use HasFactory;

    protected $fillable = ['type',];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function shoe()
    {
    	return $this->hasMany(InventoryItemShoe::class);
    }
}
