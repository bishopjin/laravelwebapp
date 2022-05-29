<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineCourse extends Model
{
    use HasFactory;

    protected $fillable = ['course'];

    public function userprofile()
    {
    	return $this->hasMany(UsersProfile::class);
    }
}
