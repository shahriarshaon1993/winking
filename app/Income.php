<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable =[
        "reference_no", "income_source_id","income_date", "warehouse_id", "account_id", "user_id", "amount", "note","is_active"
    ];

    public function expenseCategory() {

    	return $this->belongsTo('App\IncomeSource');
    }

    public function warehouse()
    {
    	return $this->belongsTo('App\Warehouse');
    }
}
