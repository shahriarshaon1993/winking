<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShipTo extends Model
{
    protected $fillable =[

        "name","address","city","zip","country","state","phone","email","is_active"
    ];
}
