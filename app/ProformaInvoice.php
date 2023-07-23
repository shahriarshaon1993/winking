<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaInvoice extends Model
{
    protected $fillable = [
        "user_id","invoice_no","date","revised_date","account_of","invoice_to_id","customer_id","season","document","delivery_date","total_qty","total_amount","status","is_active"
    ];

    public function invoiceTo()
    {
    	return $this->belongsTo('App\InvoiceTo','invoice_to_id');
    }

    public function customer(){
        return $this->belongsTo('App\Customer','customer_id');
    }
}
