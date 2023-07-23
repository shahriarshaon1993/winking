<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillExchange extends Model
{
    protected $fillable = [
        'drawn_under','export_id','refer_bank','bank_address'
    ];
    public function bank(){
        return $this->belongsTo(Bank::class, 'drawn_under');
    }
    public function export(){
        return $this->belongsTo(Export::class, 'export_id');
    }
}
