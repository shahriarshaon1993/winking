<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $fillable =[

        "name", "parent_id", "is_active"
    ];
}
