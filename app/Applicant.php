<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        "name","address","city","country","zip_code","phone","mobile","email","is_active"
    ];
}
