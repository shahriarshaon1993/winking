<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseContract extends Model
{
    protected $fillable =[

        "user_id","contract_no","master_contract_no","account_of","vendor_date","master_date","vendor_id","notify_id","customer_id","delivery_date","delivery_date_master","total_qty","total_amount","total_amount_master","master_doc","contract_doc","is_active"
    ];

    public function details(){
        return $this->hasMany('App\PurchaseContractDetails');
    }

    public function vendor()
    {
    	return $this->belongsTo('App\Vendor','vendor_id');
    }

    public function notifyInfo()
    {
    	return $this->belongsTo('App\NotifyParty','notify_id');
    }
    
    public function customer()
    {
    	return $this->belongsTo('App\Customer','customer_id');
    }

}
