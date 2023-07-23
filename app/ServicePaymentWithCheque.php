<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePaymentWithCheque extends Model
{
    protected $fillable = [
        'payment_id','cheque_no'
    ];
}
