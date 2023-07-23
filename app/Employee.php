<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable =[
        "name", "image", "image_cv","joining_date","present_salary","joining_salary","department_id", "email", "phone_number",
        "user_id", "address", "address2","nid_number","is_active",'designation','leave_job','leave_date','status'
    ];

    public function payroll()
    {
    	return $this->hasMany('App\Payroll');
    }

    public function department(): BelongsTo{
        return $this->belongsTo(Department::class,'department_id');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

}
