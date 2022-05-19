<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItemBrand extends Model
{
    use HasFactory;

    protected $fillable = ['brand',];
}
