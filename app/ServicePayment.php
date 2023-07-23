<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePayment extends Model
{
    protected $fillable = [
        'sale_id','user_id','account_id','payment_reference'	,'amount','due','paying_method','payment_note'
    ];
}
