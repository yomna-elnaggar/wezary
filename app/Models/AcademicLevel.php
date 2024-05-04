<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicLevel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function stageLevels(){
        return $this->hasMany(StageLevel::class,'academic_level_id');
    }
}
