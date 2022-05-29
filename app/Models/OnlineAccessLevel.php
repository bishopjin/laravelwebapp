<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineAccessLevel extends Model
{
    use HasFactory;

    public function userprofile()
    {
    	return $this->hasMany(UsersProfile::class);
    }
}
