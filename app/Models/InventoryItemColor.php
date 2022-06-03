<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemColor extends Model
{
    use HasFactory;
    
    protected $fillable = ['color',];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function shoe()
    {
    	return $this->hasMany(InventoryItemShoe::class);
    }
}
