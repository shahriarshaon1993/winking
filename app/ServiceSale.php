<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceSale extends Model
{
    protected $fillable = [
        'reference_no','customer_id','user_id','biller_id','item','total_qty','total_discount','total_tax','total_price','grand_total',	'order_tax_rate','order_tax',
        'order_discount','shipping_cost','sale_status',	'payment_status','paid_amount',	'sale_note','staff_note','document'

    ];

    public function biller()
    {
    	return $this->belongsTo('App\Biller');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Customer');
    }

    public function user()
    {
    	return $this->belongsTo('App\User');
    }


}
