<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'firstname', 
        'middlename', 
        'lastname', 
        'email', 
        'gender_id', 
        'online_course_id', 
        'DOB'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'DOB' => 'date',
        'gender_id' => 'integer',
    ];

    protected $attributes = ['online_course_id' => 1,];

    /* accessor */
    protected function getFullNameAttribute()
    {
        return "{$this->lastname}, {$this->firstname} {$this->middlename}";
    }

    /* Local Scope */
    public function scopeNotadmin($query)
    {   
        return $query->where('id', '>', 1);
    }

    public function scopeNotself($query, $id)
    {
        return $query->where('id', '!=', $id);
    }

    public function onlinecourse()
    {
        return $this->belongsTo(OnlineCourse::class, 'online_course_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function onlinesubject()
    {
        return $this->hasMany(OnlineSubject::class);
    }

    public function onlineexam()
    {
        return $this->hasMany(OnlineExam::class);
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
        return $this->hasOne(PayrollEmployee::class);
    }

    public function approverattendancerequest()
    {
        return $this->hasMany(PayrollAttendanceRequest::class, 'approver_id');
    }

    public function requestorattendancerequest()
    {
        return $this->hasMany(PayrollAttendanceRequest::class, 'employee_id');
    }
}
