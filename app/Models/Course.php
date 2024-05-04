<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function academicLevel(){
        return $this->belongsTo(AcademicLevel::class,'academic_level_id');
    }

     public function stageLevel(){
        return $this->belongsTo(StageLevel::class,'stage_level_id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'department_id');
    }

    public function teacher(){
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function scopeActive($query){
        return $query->where('status' ,'active');
    }

    public function subjects(){
        return $this->hasMany(Subject::class,'course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_course', 'course_id', 'user_id')->withPivot('code')->withTimestamps();
    }
  
  	public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'course_id', 'user_id')->withTimestamps();
    }
	public function CourseCodes(){
        return $this->hasMany(CourseCode::class,'course_id');
    }
}
            
            