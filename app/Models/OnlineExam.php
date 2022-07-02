<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExam extends Model
{
    use HasFactory; 

    protected $fillable = ['user_id', 'exam_code', 'online_subject_id', 'timer'];

    protected $casts = ['timer' => 'integer', 'online_subject_id' => 'integer'];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function examquestion()
    {
    	$this->hasMany(OnlineExamQuestion::class);
    }

    public function onlinesubject()
    {
    	return $this->belongsTo(OnlineSubject::class, 'online_subject_id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function onlineexamination()
    {
    	return $this->hasMany(OnlineExamination::class);
    }
}
