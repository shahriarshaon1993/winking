<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceTo extends Model
{
    protected $fillable =[

        "name","address","city","country","state","phone","email","is_active"
    ];
}
