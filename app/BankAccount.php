<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable =[
        "account_no", "bank_id","branch_id","is_active",
    ];
}
