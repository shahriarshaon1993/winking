<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable =[

        "po_number","user_id","customer_id","rivision_no","order_date","vendor","invoice_to","ship_to","ship_via","season","ship_exp_date","ship_terms","payment_terms","febric_ref","brand","style_no","ca","total_quantity","total_amount","fabrication","description","packing_instruction","instruction_notes","is_active"
    ];

    public function breakdowns(){
        return $this->hasMany('App\QuotationBreakdown');
    }
    public function vendorInfo()
    {
    	return $this->belongsTo('App\Vendor','vendor');
    }
    public function shipTo()
    {
    	return $this->belongsTo('App\ShipTo','ship_to');
    }
    public function invoiceTo()
    {
    	return $this->belongsTo('App\InvoiceTo','invoice_to');
    }
     public function customer()
    {
    	return $this->belongsTo('App\Customer','customer_id');
    }

}
