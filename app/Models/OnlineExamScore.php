<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExamScore extends Model
{
    use HasFactory;

    protected $fillable = [
    	'online_exam_id',
    	'user_id',
    	'total_question',
        'exam_score',
    ];

    protected $casts = [
        'online_exam_id' => 'integer',
    	'user_id' => 'integer',
    	'total_question' => 'integer',
    	'exam_score' => 'integer',
    ];
}
