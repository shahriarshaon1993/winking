<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseContractDetails extends Model
{
    protected $fillable =[

        "user_id","contract_id","vpo","style","item_description","color","quantity","unit_price","unit_price_client","total_value_client","total_value","total_value_master","unit_price_master","is_active"
    ];

    public function contract()
    {
    	return $this->belongsTo('App\PurchaseContract','contract_id');
    }

}
