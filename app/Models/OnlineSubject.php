<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineSubject extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function exam_question()
    {
    	return $this->belongsTo(Exam::class);
    }
}
