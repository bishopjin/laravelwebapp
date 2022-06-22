<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryEmployeeLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    
    protected $fillable = [
    	'user_id', 
    	'time_in',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function userprofile()
    {
    	return $this->belongsTo(UsersProfile::class, 'user_id', 'user_id');
    }
}
