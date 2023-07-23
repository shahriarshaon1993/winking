<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceDelivery extends Model
{
    protected $fillable = [
        'reference','sale_id','user_id','address','delivered_by','recieved_by','file','note','status'
    ];

    public function sale(){
        return $this->belongsTo('App\ServiceSale','sale_id');
    }
}
