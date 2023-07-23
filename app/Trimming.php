<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trimming extends Model
{
    protected $fillable = [
        "trimming","code","description","is_active"
    ];
}
