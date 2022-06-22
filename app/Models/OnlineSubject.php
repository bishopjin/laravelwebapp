<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'user_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function onlineexam()
    {
    	return $this->hasMany(OnlineExam::class);
    }

    public function userprofile()
    {
    	/* refered to the user id, instead of userproflie id : reason = from old system */
    	return $this->belongsTo(UsersProfile::class, 'user_id', 'user_id');
    }
}
