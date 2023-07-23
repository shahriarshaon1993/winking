<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable =[
        "reference_no", "employee_id", "paying_date","account_id", "month","user_id",
        "amount", "reference","paying_method", "note"
    ];

    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
}
