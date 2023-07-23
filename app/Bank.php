<?php

namespace App;

use App\BankBranch;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable =[
        "name", "is_active",
    ];

    public function branches()
    {
    	return $this->hasMany(BankBranch::class, 'bank_id', 'id');
    }
}
