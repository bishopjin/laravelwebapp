<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineExam extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['timer' => 'integer', 'online_subject_id' => 'integer'];
}
