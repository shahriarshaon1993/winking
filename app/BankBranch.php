<?php

namespace App;

use App\Bank;
use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    protected $fillable =[
        "name", "address","bank_id","is_active",
    ];

    public function bank() {
    	return $this->belongsTo(Bank::class, 'bank_id');
    }
}
