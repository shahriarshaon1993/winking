<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Account;
use App\Payment;
use App\Returns;
use App\ReturnPurchase;
use App\ServicePayment;
use App\Expense;
use App\Payroll;
use App\MoneyTransfer;
use DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Carbon\Carbon;


class AccountsController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('account-index')){
            $lims_account_all = Account::where('is_active', true)->get();
            return view('account.index', compact('lims_account_all'));
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
        $this->validate($request, [
            'account_no' => [
                'max:255',
                    Rule::unique('accounts')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $lims_account_data = Account::where('is_active', true)->first();
        $data = $request->all();
        if($data['initial_balance'])
            $data['total_balance'] = $data['initial_balance'];
        else
            $data['total_balance'] = 0;
        if(!$lims_account_data)
            $data['is_default'] = 1;
        $data['is_active'] = true;
        $account = Account::create($data);

//        if($account){
//            $tran = [];
//            $tran['user_id'] = Auth::id();
//            $tran['account_id'] = $account->id;
//            $tran['date'] = Carbon::now()->format('Y-m-d');
//            $tran['reference'] = '';
//            $tran['description'] = 'Initial Balance';
//            $tran['credit'] = $request->initial_balance;
//            $tran['debit'] = 0;
//            $tran['transaction'] = 'initial-' . date("Ymd") . '-'. date("his");
//            Transaction::create($tran);
//        }

        return redirect('accounts')->with('message', 'Account created successfully');
    }

    public function makeDefault($id)
    {
        $lims_account_data = Account::where('is_default', true)->first();
        $lims_account_data->is_default = false;
        $lims_account_data->save();

        $lims_account_data = Account::find($id);
        $lims_account_data->is_default = true;
        $lims_account_data->save();

        return 'Account set as default successfully';
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'account_no' => [
                'max:255',
                    Rule::unique('accounts')->ignore($request->account_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $data = $request->all();
        $lims_account_data = Account::find($data['account_id']);
        if($data['initial_balance'])
            $data['total_balance'] = $data['initial_balance'];
        else
            $data['total_balance'] = 0;

        $transaction = Transaction::where('account_id','=',$data['account_id'])->where('description','=','Initial Balance')->first();
        //dd($transaction);
        $account_update = $lims_account_data->update($data);
//        if($account_update){
//            $tran = [];
//            $tran['account_id'] = $lims_account_data->id;
//            $tran['credit'] = $lims_account_data->initial_balance;
//
//            $transaction->update($tran);
//        }

        return redirect('accounts')->with('message', 'Account updated successfully');
    }

    public function balanceSheet()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('balance-sheet')){
            $lims_account_list = Account::where('is_active', true)->get();
            $collect_balences = [];
            foreach($lims_account_list as $key=>$account){
                $balances['account_name'] = $account->name;
                $balances['account_no'] = $account->account_no;
                $balances['initial_balance'] = $account->initial_balance;
                $balances['credit'] = Transaction::where('account_id',$account->id)->sum('credit');
                $balances['debit'] = Transaction::where('account_id',$account->id)->sum('debit');

                array_push($collect_balences,$balances);
            }
            return view('account.balance_sheet', compact('lims_account_list','collect_balences'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function accountStatement(Request $request)
    {

        $start_date = $request->start_date;
        //dd($start_date);
        $end_date = $request->end_date;
        //dd($end_date);

        $type = $request->type;

        $data = $request->all();
        //dd($data);
        $lims_account_data = Account::find($data['account_id']);
        //dd($lims_account_data);
        $previous_credit = Transaction::where('date','<',$start_date)->where('account_id',$data['account_id'])->sum('credit');

        $total_previous_credit = (float)$previous_credit + (float)$lims_account_data->initial_balance;
        $previous_debit = Transaction::where('date','<',$start_date)->where('account_id',$data['account_id'])->sum('debit');
        //dd($previous_debit);
        $previous_balance = ( (float)$total_previous_credit - (float)$previous_debit);
        //dd($previous_balance);
        $transactions = Transaction::where('account_id',$data['account_id'])
                      ->where(function($query) use($type){
                           if($type == 1){
                                return $query->where('debit','>',0);
                           }else if($type == 2){
                                return $query->where('credit','>',0);
                           }
                      })->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date','ASC')
            ->get();
        //dd($transactions);
        return view('account.account_statement', compact('start_date','end_date','lims_account_data','previous_balance','transactions','type'));
    }

    public function print_statement(Request $request){
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $type = $request->get('type');
        $accoutn_id = $request->get('account_id');

        $lims_account_data = Account::find($request['account_id']);
        //dd($lims_account_data);
        $previous_credit = Transaction::where('date','<',$start_date)->where('account_id',$request['account_id'])->sum('credit');

        $total_previous_credit = (float)$previous_credit + (float)$lims_account_data->initial_balance;
        $previous_debit = Transaction::where('date','<',$start_date)->where('account_id',$request['account_id'])->sum('debit');
        //dd($previous_debit);
        $previous_balance = ( (float)$total_previous_credit - (float)$previous_debit);


        $transactions = Transaction::where('account_id',$accoutn_id)
                      ->where(function($query) use($type){
                           if($type == 1){
                                return $query->where('debit','>',0);
                           }else if($type == 2){
                                return $query->where('credit','>',0);
                           }
                      })->whereBetween('date', [$start_date, $end_date])
                    ->orderBy('date', 'ASC')
                    ->get();

        return view('account.statement_print',compact('start_date','end_date','lims_account_data','previous_balance','transactions'));

    }

    public function destroy($id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $lims_account_data = Account::find($id);
        if(!$lims_account_data->is_default){
            $lims_account_data->is_active = false;
            $lims_account_data->save();
            return redirect('accounts')->with('not_permitted', 'Account deleted successfully!');
        }
        else
            return redirect('accounts')->with('not_permitted', 'Please make another account default first!');
    }
}
