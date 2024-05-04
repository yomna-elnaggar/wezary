<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StageLevel extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    public function academicLevel(){
        return $this->belongsTo(AcademicLevel::class,'academic_level_id');
    }
}
