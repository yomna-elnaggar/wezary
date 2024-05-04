<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_subject', 'subject_id', 'user_id')->withPivot('status', 'attending_min')->withTimestamps();
    }
  
}
