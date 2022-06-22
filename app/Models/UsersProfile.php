<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    
    protected $fillable = [
        'user_id', 
        'firstname', 
        'middlename', 
        'email', 
        'lastname', 
        'gender_id', 
        'online_course_id', 
        'DOB'
    ];

    protected $hidden = ['created_at', 'updated_at'];
    /**
     * The attributes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'DOB' => 'date',
        'gender_id' => 'integer',
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function onlinecourse()
    {
        return $this->belongsTo(OnlineCourse::class, 'online_course_id', 'id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function onlineaccesslevel()
    {
        return $this->belongsTo(OnlineAccessLevel::class, 'online_access_level_id', 'id');
    }

    public function onlinesubject()
    {
        return $this->hasMany(OnlineSubject::class);
    }

    public function onlineexam()
    {
        return $this->hasMany(OnlineExam::class, 'user_id', 'user_id');
    }

    public function onlineexamination()
    {
        return $this->hasMany(OnlineExamination::class);
    }

    public function inventoryreceive()
    {
        return $this->hasMany(InventoryItemReceive::class);
    }

    public function inventoryorder()
    {
        return $this->hasMany(InventoryItemOrder::class);
    }

    public function employeelog()
    {
        return $this->hasMany(InventoryEmployeeLog::class);
    }

    public function payrollcutoff()
    {
        return $this->hasMany(PayrollCutOff::class);
    }

    public function payrollemployee()
    {
        return $this->hasOne(PayrollEmployee::class, 'user_id', 'id');
    }
}
