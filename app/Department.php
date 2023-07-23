<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable =[
        "name", "is_active"
    ];
    
    public function employees(){
        return $this->hasMany('App\Employee');
    }
}
