<?php

namespace App\Http\Controllers;

use App\Helper\AccountHelper;
use App\MoneyTransfer;
use App\Account;
use App\Transaction;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class MoneyTransferController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('money-transfer')){
            $lims_money_transfer_all = MoneyTransfer::OrderBy('id','DESC')->get();
            $lims_account_list = Account::where('is_active', true)->get();
            return view('money_transfer.index', compact('lims_money_transfer_all', 'lims_account_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if($request->from_account_id == $request->to_account_id){
            return redirect()->back()->with('not_permitted', 'Both account can not be same');
        }

        $data = $request->all();
        $data['date'] = date("Y-m-d", strtotime($request->date));
        $data['reference_no'] = 'mtr-' . date("Ymd") . '-'. date("his");

        $account_form = Account::find($data['from_account_id']);
        $account_to = Account::find($data['to_account_id']);

        $balance = AccountHelper::AccountPostBalance($data['from_account_id']);

        if($balance < $request->amount){
            return redirect()->back()->with('not_permitted', "You don't have sufficient balance.");
        }
        try{
            $money_transfer = MoneyTransfer::create($data);
            if($money_transfer){
                $tran = [];
                $tran['user_id'] = Auth::id();
                $tran['account_id'] = $request->to_account_id;
                $tran['date'] = date("Y-m-d", strtotime($request->date));
                $tran['description'] = 'Fund Transfer From '.$account_form->name;
                $tran['credit'] = $request->amount;
                $tran['debit'] = 0;
                $tran['transaction'] = $data['reference_no'];
                Transaction::create($tran);
            }
            if($money_transfer){
                $tran = [];
                $tran['user_id'] = Auth::id();
                $tran['account_id'] = $request->from_account_id;
                $tran['date'] = date("Y-m-d", strtotime($request->date));
                $tran['description'] = 'Fund Transfer To '.$account_to->name;
                $tran['credit'] = 0;
                $tran['debit'] = $request->amount;
                $tran['transaction'] = $data['reference_no'];
                Transaction::create($tran);
            }
        }catch(\Exception $e){
            $message = $e->getMessage();
        }

        return redirect()->back()->with('message', 'Money transferred successfully');
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['date'] = date("Y-m-d", strtotime($request->date));

        $money_transfer = MoneyTransfer::find($data['id']);

        $initial_balance = Account::findOrFail($data['from_account_id'])->initial_balance;
        $credit = Transaction::where('account_id',$data['from_account_id'])->sum('credit');
        $total_credit = ((float)$initial_balance + (float)$credit);

        $debit = Transaction::where('account_id',$data['from_account_id'])->sum('debit');
        $total_debit = (float) $debit - (float)$money_transfer->amount;
        $balance = (float)$total_credit - (float)$total_debit;

        if($request->amount > $balance){
            return back()->with('not_permitted', 'Fund transfer !! you dont have sufficient balance');
        }

        $money_transfer->update($data);

        //dd($money_transfer->reference_no);
        $credit_transaction = Transaction::where('transaction','=',$money_transfer->reference_no)->where('credit','>',0)->first();
        $debit_transaction = Transaction::where('transaction','=',$money_transfer->reference_no)->where('debit','>',0)->first();

        if($money_transfer){
            $tran = [];
            $tran['account_id'] = $request->to_account_id;
            $tran['date'] = date("Y-m-d", strtotime($request->date));
            $tran['credit'] = $request->amount;
            $tran['debit'] = 0;
            $tran['transaction'] = $money_transfer->reference_no;
            $credit_transaction->update($tran);
            //Transaction::create($tran);
        }

        if($money_transfer){
            $tran = [];
            $tran['account_id'] = $request->from_account_id;
            $tran['date'] = date("Y-m-d", strtotime($request->date));
            $tran['debit'] = $request->amount;
            $tran['transaction'] = $money_transfer->reference_no;
            $debit_transaction->update($tran);
            //Transaction::create($tran);
        }
        return redirect()->back()->with('message', 'Money transfer updated successfully');
    }

    public function destroy($id)
    {
        $modey_transfer = MoneyTransfer::where('id',$id)->first();
        Transaction::where('transaction','=',$modey_transfer->reference_no)->delete();
        $modey_transfer->delete();
        return redirect()->back()->with('not_permitted', 'Data deleted successfully');
    }
}
