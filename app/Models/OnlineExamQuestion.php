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

    protected function selection()
    {
    	return $this->hasMany(OnlineExamSelection::class);
    }
}
