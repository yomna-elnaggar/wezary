<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $guarded = [];

    // public function admins(){
    //     return $this->hasMany(Admin::class,'department_id');
    // }
   
    
    public function academicLevel(){
        return $this->belongsTo(AcademicLevel::class,'academic_level_id');
    }

     public function stageLevel(){
        return $this->belongsTo(StageLevel::class,'stage_level_id');
    }

}
