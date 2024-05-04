<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
     protected $guarded = [];
  
  	public function teacher(){
        return $this->belongsTo(Admin::class,'admin_id');
    }
  
  	public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
  	public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
