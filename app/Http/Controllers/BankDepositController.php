<?php

namespace App\Http\Controllers;

use App\BankDeposit;
use App\Helper\AccountHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Account;
use App\Transaction;
use Auth;

class BankDepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lims_account_list = Account::where('is_active', true)->get();
        $lims_deposit_list = BankDeposit::orderBy('id','DESC')->get();
        return view('deposit.index',compact('lims_account_list','lims_deposit_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['date'] = date("Y-m-d", strtotime($request->date));
        $data['user_id'] = Auth::id();
        $data['transaction'] = 'deposit-' . date("Ymd") . '-'. date("his");
        if($request->paying_method == 1){
            $data['reference'] = '';
        }else{
            $data['reference'] = $request->reference;
        }

        try{
        //account total balance update
            $deposit = BankDeposit::create($data);
        //insert deposit data
            if($deposit){
                $tran = [];
                $tran['user_id'] = Auth::id();
                $tran['account_id'] = $deposit->account_id;
                $tran['date'] = date("Y-m-d", strtotime($request->date));
                $tran['reference'] = $deposit->reference;
                $tran['description'] = 'Deposit Fund';
                $tran['credit'] = $deposit->amount;
                $tran['debit'] = 0;
                $tran['transaction'] = $deposit->transaction;
                Transaction::create($tran);
            }
        }
        catch(\Exception $e){
            $message = 'Something error fount';
        }
        return redirect('deposits')->with('message', 'Bank deposit created successfully');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankDeposit  $bankDeposit
     * @return \Illuminate\Http\Response
     */
    public function show(BankDeposit $bankDeposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankDeposit  $bankDeposit
     * @return \Illuminate\Http\Response
     */
    public function edit(BankDeposit $bankDeposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankDeposit  $bankDeposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //return $request->all();
        $data = $request->all();
        $data['date'] = date("Y-m-d", strtotime($request->date));
        if($request->paying_method == 1){
            $data['reference'] = '';
        }else{
            $data['reference'] = $request->reference;
        }
        try{
            //account total balance update
                $deposit = BankDeposit::find($request->deposit_id);
                $transaction = Transaction::where('transaction','=',$deposit->transaction)->first();

            $initial_balance = Account::findOrFail($request->account_id)->initial_balance;
            $credit = Transaction::where('account_id',$request->account_id)->sum('credit');
            $total_credit = ((float)$initial_balance + (float)$credit);

            $update_deposit=$deposit->update($data);
            //insert deposit data
                if($update_deposit){
                    $tran = [];
                    $tran['account_id'] = $deposit->account_id;
                    $tran['date'] = date("Y-m-d", strtotime($request->date));
                    $tran['reference'] = $deposit->reference;
                    $tran['credit'] = $deposit->amount;
                    $transaction->update($tran);
                }
            }
            catch(\Exception $e){
                $message = 'Something error fount';
            }

        return redirect('deposits')->with('message', 'Bank deposit updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankDeposit  $bankDeposit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $deposit = BankDeposit::find($id);
            $deposit_amount = $deposit->amount;
        //account total balance update
            // $account = Account::find($deposit->account_id);
            // $acc['total_balance'] = ($account->total_balance - $deposit_amount);
            // $account->update($acc);
        //delete transaction deposit
            $transaction = Transaction::where('transaction','=',$deposit->transaction)->first();
            $transaction->delete();
        //delete  deposit
           $deposit->delete();
           $message = 'Bank deposit deleted successfully';
        }catch(\Exception $e){
                $message = 'Something error fount';
            }
        return redirect('deposits')->with('message', $message);
    }
}
