<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CostBreakdown extends Model
{
    protected $fillable = [
        'user_id','account_of','season','customer_id','vendor_id','lc_number','order_qty','order_value_customer','order_value_vendor','document','delivery_date','status','is_active'
    ];

    public function vendor()
    {
    	return $this->belongsTo('App\Vendor','vendor_id');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Customer','customer_id');
    }

}
