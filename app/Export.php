<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    protected $fillable = [
        "user_id","invoice_no","lc_number","contact_number","date","etd","eta","ship_to_id","account_of","shipper_id","customer_id","quantity_pcs","quantity_crt","invoice_value","shipper_invoice_value",	"due_date",	"export_status", "payment_date", "status"
    ];

    public function customer(){
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function shipper(){
        return $this->belongsTo('App\ShipTo','ship_to_id');
    }

    public function vendor(){
        return $this->belongsTo('App\Vendor','shipper_id');
    }
}
