<?php
namespace App\Helper;

use App\Account;
use App\Transaction;

class AccountHelper{
    public static function AccountPostBalance ($accountId) {
        $initial_balance = Account::findOrFail($accountId)->initial_balance;
        $credit = Transaction::where('account_id',$accountId)->sum('credit');
        $total_credit = (float)$initial_balance + (float)$credit;
        $debit = Transaction::where('account_id',$accountId)->sum('debit');
        $balance = (float)$total_credit - (float)$debit;

        return $balance;
    }
}
