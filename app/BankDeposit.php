<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankDeposit extends Model
{
    protected $fillable = [
        "user_id","account_id","transaction","title","date","paid_by","paying_method","amount","reference","note"
    ];

    public function account(){
        return $this->belongsTo('App\Account','account_id');
    }
}
