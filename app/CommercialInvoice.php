<?php

namespace App;

use App\Bank;
use App\Export;
use App\BankBranch;
use Illuminate\Database\Eloquent\Model;

class CommercialInvoice extends Model
{
    public function export(){
        return $this->belongsTo(Export::class, 'export_id');
    }
    public function bank(){
        return $this->belongsTo(Bank::class, 'bank_id');
    }
    public function branch(){
        return $this->belongsTo(BankBranch::class, 'branch_id');
    }
    public function notify(){
        return $this->belongsTo(NotifyParty::class, 'notify_party');
    }
}
