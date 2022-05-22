<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'firstname', 
        'middlename', 
        'email', 
        'lastname', 
        'gender_id', 
        'online_course_id', 
        'DOB'
    ];

    /**
     * The attributes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'DOB' => 'date',
        'gender_id' => 'integer',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
