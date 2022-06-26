<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

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

    /* Laravel 8 accessors */
    protected function getKeyToCorrectAttribute($value)
    {
        return Crypt::decryptString($value);
    }
    /* Laravel 8 mutators */
    protected function setKeyToCorrectAttribute($value)
    {
        $this->attributes['key_to_correct'] = Crypt::encryptString($value);
    }

    public function exam()
    {
        return $this->belongsTo(OnlineExam::class, 'online_exam_id', 'id');
    }

    public function examselection()
    {
    	return $this->hasMany(OnlineExamSelection::class);
    }
}
