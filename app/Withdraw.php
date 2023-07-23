<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $fillable = [
        "user_id","account_id","transaction","title","date","withdraw_by","paying_method","amount","reference","note"
    ];

    public function account(){
        return $this->belongsTo('App\Account','account_id');
    }
}
