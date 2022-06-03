<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'key_to_correct',
        'online_exam_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
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
