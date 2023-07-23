<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceSaleDetails extends Model
{
    protected $fillable = [
        'sale_id','product_id','qty','unit_price','discount','tax_rate','tax','total'
    ];

    public function product(){
        return $this->belongsTo('App\Service');
    }
}
