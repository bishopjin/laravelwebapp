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

    public function user()
    {
    	return $this->belongsTo(User::class)->withTrashed();
    }
}
