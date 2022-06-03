<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExamSelection extends Model
{
    use HasFactory;

    protected $fillable = [
        'online_exam_question_id',
        'selection',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function examquestion()
    {
    	return $this->belongsTo(OnlineExamQuestion::class, 'online_exam_question_id', 'id');
    }
}
