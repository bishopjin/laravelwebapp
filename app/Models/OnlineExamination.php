<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExamination extends Model
{
    use HasFactory;

    protected $fillable = [
    	'online_exam_id',
    	'user_id',
    	'faculty_id',
    	'total_question',
    	'exam_score',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function faculty()
    {
    	return $this->belongsTo(User::class, 'faculty_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function onlineexam()
    {
    	return $this->belongsTo(OnlineExam::class, 'online_exam_id');
    }
}
