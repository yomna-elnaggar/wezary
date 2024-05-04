<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory ,HasRoles ;

    protected $guarded = [];
    protected $guard_name = 'admin';

    public function courses(){
        return $this->hasMany(Course::class,'admin_id');
    }
}
