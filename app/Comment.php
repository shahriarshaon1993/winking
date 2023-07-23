<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable =[
         "user_id","customer_id", "topic", "details","status"
    ];

    public function customer(){
        return $this->belongsTo('App\Customer');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
