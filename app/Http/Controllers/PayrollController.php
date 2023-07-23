<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Employee;
use App\Payroll;
use App\Transaction;
use Auth;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;


class PayrollController extends Controller
{

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('payroll')){
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_employee_list = Employee::where('is_active', true)->get();
            $general_setting = DB::table('general_settings')->latest()->first();
            if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own')
                $lims_payroll_all = Payroll::orderBy('id', 'desc')->where('user_id', Auth::id())->get();
            else
                $lims_payroll_all = Payroll::orderBy('id', 'desc')->get();

            return view('payroll.index', compact('lims_account_list', 'lims_employee_list', 'lims_payroll_all'));
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
    //check pay or not
        $paid = Payroll::where('employee_id',$request->employee_id)->where('month',$request->month)->first();
        if($paid){
           return redirect()->back()->with('not_permitted','Salary already paid');
        }

    //account total balance update
        // $account = Account::find($request->account_id);
        // $acc['total_balance'] = $account->total_balance - $request->amount;
        // $account->update($acc);

    //data insert in payroll
        $data = $request->all();
        $data['reference_no'] = 'payroll-' . date("Ymd") . '-'. date("his");
        if($request->paying_method == 1){
            $data['reference'] = '';
        }else{
            $data['reference'] = $request->reference;
        }
        $data['user_id'] = Auth::id();
        $payroll = Payroll::create($data);

    //insert deposit data
        if($payroll){
            $tran = [];
            $tran['user_id'] = Auth::id();
            $tran['account_id'] = $payroll->account_id;
            $tran['date'] = $request->paying_date;
            $tran['reference'] = $payroll->reference;
            $tran['description'] = 'Payroll';
            $tran['credit'] = 0;
            $tran['debit'] = $payroll->amount;
            $tran['transaction'] = $payroll->reference_no;
            Transaction::create($tran);
        }
        $message = 'Payroll creared succesfully';

        //collecting mail data
        $lims_employee_data = Employee::find($data['employee_id']);
        $mail_data['reference_no'] = $data['reference_no'];
        $mail_data['month'] = $data['month'];
        $mail_data['amount'] = $data['amount'];
        $mail_data['name'] = $lims_employee_data->name;
        $mail_data['email'] = $lims_employee_data->email;
        try{
            Mail::send( 'mail.payroll_details', $mail_data, function( $message ) use ($mail_data)
            {
                $message->to( $mail_data['email'] )->subject( 'Payroll Details' );
            });
        }
        catch(\Exception $e){
            $message = ' Payroll created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
        }

        return redirect('payroll')->with('message', $message);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        if($request->paying_method == 1){
            $data['reference'] = '';
        }else{
            $data['reference'] = $request->reference;
        }

        try{
            $lims_payroll_data = Payroll::find($data['payroll_id']);
            // $previous_paid = $lims_payroll_data->amount;
            // $payable = $request->amount;
            // $update_payable = ($previous_paid - $payable);

            // $account = Account::find($request->account_id);
            // $acc['total_balance'] = $account->total_balance + $update_payable;
            // $account->update($acc);
            // $lims_payroll_data->update($data);

            $transaction = Transaction::where('transaction','=',$lims_payroll_data->reference_no)->first();
            if($transaction){
                $tran = [];
                $tran['account_id'] = $request->account_id;
                $tran['date'] = $request->paying_date;
                $tran['reference'] = $data['reference'];
                $tran['debit'] = $request->amount;
            }

            $transaction->update($tran);

        }catch(\Exception $e){
            $message = '';
        }
        return redirect('payroll')->with('message', 'Payroll updated succesfully');
    }

    public function deleteBySelection(Request $request)
    {
        $payroll_id = $request['payrollIdArray'];
        foreach ($payroll_id as $id) {
            $lims_payroll_data = Payroll::find($id);
            $lims_payroll_data->delete();
        }
        return 'Payroll deleted successfully!';
    }

    public function destroy($id)
    {
        try{
            $lims_payroll_data = Payroll::find($id);
            // $payroll_amount = $lims_payroll_data->amount;
        //account total balance update
            // $account = Account::find($lims_payroll_data->account_id);
            // $acc['total_balance'] = ($account->total_balance + $payroll_amount);
            // $account->update($acc);
        //delete transaction deposit
            $transaction = Transaction::where('transaction','=',$lims_payroll_data->reference_no)->first();
            $transaction->delete();
        //delete  payroll
            $lims_payroll_data->delete();
            $message = 'Payroll deleted successfully';
        }catch(\Exception $e){
                $message = 'Something error fount';
            }
        return redirect('deposits')->with('message', $message);
    }

    public function payrollFilterGet(){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('payroll')){
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_employee_list = Employee::where('is_active', true)->get();
            $general_setting = DB::table('general_settings')->latest()->first();
            if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own')
                $lims_payroll_all = Payroll::orderBy('id', 'desc')->where('user_id', Auth::id())->get();
            else
                $lims_payroll_all = Payroll::orderBy('id', 'desc')->get();

            return view('payroll.index', compact('lims_account_list', 'lims_employee_list', 'lims_payroll_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function payrollFilter(Request $request){

         $month = $request->search_month;
         $employee_id = $request->employee_id;
         if($employee_id == null && $month == null){
            return redirect()->back()->with('not_permitted','Please select employee or month for filtering');
       }

       $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('payroll')){
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_employee_list = Employee::where('is_active', true)->get();
            $general_setting = DB::table('general_settings')->latest()->first();
            if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own')
                $lims_payroll_all = Payroll::orderBy('id', 'desc')->where('user_id', Auth::id())
                                    ->where(function ($query) use($month,$employee_id){
                                        if($employee_id != null && $month != null){
                                            return $query->where('month',$month)
                                                        ->where('employee_id',$employee_id);
                                        }elseif($employee_id != null){
                                            return $query->where('employee_id',$employee_id);
                                        }elseif($month != null){
                                            return $query->where('month',$month);
                                        }
                                    })
                                  ->get();
            else
                $lims_payroll_all = Payroll::orderBy('id', 'desc')
                                  ->where(function ($query) use($month,$employee_id){
                                      if($employee_id != null && $month != null){
                                           return $query->where('month',$month)
                                                        ->where('employee_id',$employee_id);
                                       }elseif($employee_id != null){
                                            return $query->where('employee_id',$employee_id);
                                        }elseif($month != null){
                                            return $query->where('month',$month);
                                        }
                                  })
                                  ->get();

            return view('payroll.index', compact('lims_account_list', 'lims_employee_list', 'lims_payroll_all','employee_id','month'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
}
