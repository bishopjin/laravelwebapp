<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExamQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
    	'online_subject_id' => 'integer',
    ];

    public function exam()
    {
        return $this->belongsTo(OnlineExam::class, 'online_exam_id', 'id');
    }

    public function examselection()
    {
    	return $this->hasMany(OnlineExamSelection::class);
    }
}
