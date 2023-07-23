<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable =[
        "customer_group_id", "user_id", "interest_id","name", "contract_person",
        "email", "phone_number", "fax", "address", "city",
        "state", "postal_code", "country", "deposit", "expense", "is_active"
    ];

    public function deposits(){
       return $this->hasMany('App\Deposit');
    }
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    public function sales(){
        return $this->hasMany('App\Sale');
    }
    public function user(){
    	return $this->belongsTo('App\User');
    }
    public function group(){
        return $this->belongsTo('App\CustomerGroup','customer_group_id');
    }
    public function interest(){
        return $this->belongsTo('App\Interest');
    }
    public function reminders(){
        return $this->hasMany('App\Reminder');
    }
    public function serviceSale(){
        return $this->hasMany('App\ServiceSale');
    }

}
