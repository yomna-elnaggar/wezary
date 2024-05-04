<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function academicLevel(){
        return $this->belongsTo(AcademicLevel::class,'academic_level_id');
    }

     public function stageLevel(){
        return $this->belongsTo(StageLevel::class,'stage_level_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'user_subject', 'user_id', 'subject_id')->withPivot('status', 'attending_min')->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'user_course', 'user_id', 'course_id')->withPivot('code')->withTimestamps();
    }
  
  	public function favorites()
    {
        return $this->belongsToMany(Course::class, 'favorites', 'user_id', 'course_id')->withTimestamps();
    }
  
  	public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
  
  	public function exam()
    {
        return $this->hasMany(Exam::class,'user_id');
    }



    
}
