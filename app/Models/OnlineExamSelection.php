<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExamSelection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
    	'online_exam_question_id' => 'integer',
    ];

    public function examquestion()
    {
    	return $this->belongsTo(OnlineExamQuestion::class, 'online_exam_question_id', 'id');
    }
}
