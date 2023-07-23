<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotifyParty extends Model
{
    protected $fillable = [
        "name",	"address",	"city",	"country",	"state",	"zip_code",	"phone",	"mobile",	"email",	"is_active"
    ];
}
