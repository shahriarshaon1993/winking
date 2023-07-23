<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncomeSource extends Model
{
    protected $fillable =[
        "code", "name", "is_active"
    ];

    public function expense() {
    	return $this->hasMany('App\Income');
    }
}
