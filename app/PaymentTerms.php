<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTerms extends Model
{
    protected $fillable = [
         'payment_term','is_active'
    ];
}
