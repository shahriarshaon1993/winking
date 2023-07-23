<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable =[

        "name","address","city","country","state","phone","mobile","email","is_active"
    ];

}
