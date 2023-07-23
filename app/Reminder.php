<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminders';

    protected $fillable =[
        "user_id", "customer_id", "topic", "note", "time", "date", "status","is_active"
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function customer(){
        return $this->belongsTo('App\Customer');
    }
}
