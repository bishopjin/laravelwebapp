<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderBeverageSize extends Model
{
    use HasFactory;

    protected $fillable = ['size'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function beverage()
    {
    	return $this->hasMany(OrderBeverage::class);
    }
}
