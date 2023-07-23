<?php

namespace App\Http\Controllers;

use App\Helper\AccountHelper;
use Illuminate\Http\Request;
use App\Expense;
use App\Account;
use App\Transaction;
use App\CashRegister;
use App\ExpenseCategory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use DB;

class ExpenseController extends Controller
{
    public function index()
    {

        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('expenses-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            //dd($permissions);
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_expense_category_all = ExpenseCategory::where('is_active', true)->get();

            if (Auth::user()->role_id > 2 && config('staff_access') == 'own')
                $lims_expense_all = Expense::orderBy('id', 'desc')->where('user_id', Auth::id())->get();
            else
                $lims_expense_all = Expense::orderBy('id', 'desc')->get();
            //dd($all_permission);
            return view('expense.index', compact('lims_account_list', 'lims_expense_all', 'all_permission', 'lims_expense_category_all'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $data = $request->all();

        $data['billing_date'] = date("Y-m-d", strtotime($request->billing_date));
        $data['payment_date'] = date("Y-m-d", strtotime($request->payment_date));

        $data['reference_no'] = 'er-' . date("Ymd") . '-' . date("his");
        $data['user_id'] = Auth::id();
        $data['warehouse_id'] = 1;
        $cash_register_data = CashRegister::where([
            ['user_id', $data['user_id']],
            ['warehouse_id', $data['warehouse_id']],
            ['status', true]
        ])->first();
        if ($cash_register_data)
            $data['cash_register_id'] = $cash_register_data->id;

        // //account total balance update
        // $account = Account::find($request->account_id);
        // $acc['total_balance'] = $account->total_balance - $request->amount;
        // $account->update($acc);


        $expense_name = ExpenseCategory::where('id', $request->expense_category_id)->first('name');
        //dd($expense_name);
        //create transaction
        $balance = AccountHelper::AccountPostBalance($request->account_id);

        if ($request->amount > $balance) {

            //dd(85);
            return back()->with('not_permitted', 'Expense canceled !! you dont have sufficient balance');
        } else {

            //create expense
            $expense = Expense::create($data);

            if ($expense) {
                $tran = [];
                $tran['user_id'] = Auth::id();
                $tran['account_id'] = $expense->account_id;
                $tran['date'] = date("Y-m-d", strtotime($request->billing_date));
                $tran['reference'] = $expense->reference;
                $tran['description'] = 'Expense for - ' . $expense_name->name;
                $tran['credit'] = 0;
                $tran['debit'] = $expense->amount;
                $tran['transaction'] = $expense->reference_no;
                Transaction::create($tran);
            }
        }
        return redirect('expenses')->with('message', 'Data inserted successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('expenses-edit')) {
            $lims_expense_data = Expense::find($id);
            return $lims_expense_data;
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['billing_date'] = date("Y-m-d", strtotime($request->billing_date));
        $data['payment_date'] = date("Y-m-d", strtotime($request->payment_date));

        try {
            $lims_expense_data = Expense::find($data['expense_id']);
            $previous_paid = $lims_expense_data->amount;
            $payable = $request->amount;
            $update_payable = ($previous_paid - $payable);

            // $account = Account::find($request->account_id);
            // $acc['total_balance'] = $account->total_balance + $update_payable;
            // $account->update($acc);

            $transaction = Transaction::where('transaction', '=', $lims_expense_data->reference_no)->first();

            $initial_balance = Account::findOrFail($request->account_id)->initial_balance;
            $credit = Transaction::where('account_id', $request->account_id)->sum('credit');
            $total_credit = ((float)$initial_balance + (float)$credit);

            $debit = Transaction::where('account_id', $request->account_id)->sum('debit');

            $total_debit = (float)$debit - (float)$lims_expense_data->amount;

            $update_debit = $total_debit + $request->amount;


            $balance = (float)$total_credit - (float)$update_debit;

            if (0 > $balance) {
                return back()->with('not_permitted', 'Fund transfer !! you dont have sufficient balance');
            }

            $lims_expense_data->update($data);

            if ($transaction) {
                $tran = [];
                $tran['account_id'] = $request->account_id;
                $tran['date'] = date("Y-m-d", strtotime($request->billing_date));
                $tran['reference'] = $transaction->reference;
                $tran['debit'] = $request->amount;
            }
            $transaction->update($tran);

        } catch (\Exception $e) {
            $message = '';
        }

        return redirect('expenses')->with('message', 'Data updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $expense_id = $request['expenseIdArray'];
        foreach ($expense_id as $id) {
            $lims_expense_data = Expense::find($id);
            $lims_expense_data->delete();
        }
        return 'Expense deleted successfully!';
    }

    public function destroy($id)
    {
//        dd($id);

        try {

            $lims_expense_data = Expense::findOrFail($id);
            // $payroll_amount = $lims_expense_data->amount;
            //account total balance update
            // $account = Account::find($lims_expense_data->account_id);
            // $acc['total_balance'] = ($account->total_balance + $payroll_amount);
            // $account->update($acc);
            //delete transaction deposit
            $transaction = Transaction::where('transaction', $lims_expense_data->reference_no)->first();


            // Update Account Total Balance
//            $account = Account::find($transaction->account_id)->first();
//            $updateBlance = $account->total_balance - $lims_expense_data->amount;
//            $account->total_balance = $updateBlance;
//            $account->save();


            $transaction->delete();
            //delete  expense
            $lims_expense_data->delete();
            $message = 'Expense deleted successfully';
        } catch (\Exception $e) {
            $message = 'Something error fount';
        }

        return redirect('expenses')->with('not_permitted', 'Data deleted successfully');
    }

    public function expenseFilterGet(Request $request)
    {

        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('expenses-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_expense_category_all = ExpenseCategory::where('is_active', true)->get();

            if (Auth::user()->role_id > 2 && config('staff_access') == 'own')
                $lims_expense_all = Expense::orderBy('id', 'desc')->where('user_id', Auth::id())->get();
            else
                $lims_expense_all = Expense::orderBy('id', 'desc')->get();
            return view('expense.index', compact('lims_account_list', 'lims_expense_all', 'all_permission', 'lims_expense_category_all'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function expenseFilter(Request $request)
    {
        //dd($request->input());
        $start = ' 00:00:00';
        $end = ' 23:59:59';
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $payment_start_date = $request->payment_start_date;
        $payment_end_date = $request->payment_end_date;
        $payment_date_range = $request->payment_date_range;
        $date_range = $request->date_range;
        $expense_category_id = $request->expense_category_id;

//        if ($expense_category_id == 0 && ($start_date == null && $start_date == null)) {
//            return redirect()->back()->with('not_permitted', 'Please select date range or category type for filtering');
//        }

        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('expenses-index')) {
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_expense_category_all = ExpenseCategory::where('is_active', true)->get();

            $user_id = Auth::user()->role_id;
            $lims_expense = Expense::orderBy('id', 'desc')
                ->where(function ($query) use ($user_id) {
                    if ($user_id > 2 && config('staff_access') == 'own') {
                        $query->where('user_id', Auth::id());
                    }
                });

            if (isset($expense_category_id)) {
                $lims_expense->where('expense_category_id', $expense_category_id);
            }
            if (isset($request->start_date) && isset($request->end_date)) {
                $lims_expense->whereBetween('created_at', [$request->start_date.$start, $request->end_date.$end]);
            }
            if (isset($request->payment_start_date) && isset($request->payment_end_date)) {
                //dd(52);
                $lims_expense->whereBetween('payment_date', [$request->payment_start_date, $request->payment_end_date]);
            }

            $lims_expense_all = $lims_expense->get();


//                              ->where(function($q) use($expense_category_id,$start_date,$end_date,$start,$end){
//                                if($expense_category_id != 0 && $start_date != null && $end_date != null){
//                                    return $q->where('expense_category_id',$expense_category_id)
//                                               ->whereBetween('created_at',[$start_date.$start,$end_date.$end]);
//                                }elseif($start_date != null && $end_date != null){
//                                    return $q->
//                                }elseif($expense_category_id != 0){
//                                   return $q->where('expense_category_id',$expense_category_id);
//                                }
//                              })

            return view('expense.index', compact('lims_account_list', 'lims_expense_all', 'all_permission', 'lims_expense_category_all',
                'expense_category_id', 'start_date', 'end_date', 'date_range', 'payment_start_date' , 'payment_end_date', 'payment_date_range'));
        } else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
}
