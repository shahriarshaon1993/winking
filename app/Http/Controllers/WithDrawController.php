<?php

namespace App\Http\Controllers;

use App\Helper\AccountHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Withdraw;
use App\Account;
use App\Transaction;
use Auth;

class WithDrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lims_account_list = Account::where('is_active', true)->get();
        $lims_withdraw_list = Withdraw::orderBy('id','DESC')->get();
        return view('withdraw.index',compact('lims_account_list','lims_withdraw_list'));
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
        //dd( $request->all());
        $data['date'] = date("Y-m-d", strtotime($request->date));
        $data['user_id'] = Auth::id();
        $data['transaction'] = 'withdraw-' . date("Ymd") . '-'. date("his");
        if($request->paying_method == 1){
            $data['reference'] = '';
        }else{
            $data['reference'] = $request->reference;
        }

        $balance = AccountHelper::AccountPostBalance($request->account_id);

        if($request->amount > $balance){
            return back()->with('not_permitted', 'withdraw canceled !! you dont have sufficient balance');
        }

        //dd($request->input());
        try{
        //insert withdraw data
            $withdraw = Withdraw::create($data);
            //dd($withdraw);
            //dd($withdraw);
        //insert withdraw data
            if($withdraw){
                $tran = [];
                $tran['user_id'] = Auth::id();
                $tran['account_id'] = $withdraw->account_id;
                $tran['date'] = date("Y-m-d", strtotime($request->date));
                $tran['reference'] = $withdraw->reference;
                $tran['description'] = 'Withdraw Fund';
                $tran['debit'] = $withdraw->amount;
                $tran['credit'] = 0;
                $tran['transaction'] = $withdraw->transaction;
                Transaction::create($tran);
            }
        }
        catch(\Exception $e){
            $message = $e->getMessage();
        }
        return redirect('withdraws')->with('message', 'Bank withdraw created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['date'] = date("Y-m-d", strtotime($request->date));
        if($request->paying_method == 1){
            $data['reference'] = '';
        }else{
            $data['reference'] = $request->reference;
        }
        try{
            //account total balance update
                $withdraw = Withdraw::find($request->withdraw_id);
                $transaction = Transaction::where('transaction' ,$withdraw->transaction)->first();
                //dd($transaction);
            //update deposit data

            $initial_balance = Account::findOrFail($request->account_id)->initial_balance;
            $credit = Transaction::where('account_id',$request->account_id)->sum('credit');
            $total_credit = ((float)$initial_balance + (float)$credit);

            $debit = Transaction::where('account_id',$request->account_id)->sum('debit');
            $total_debit = (float) $debit - (float)$withdraw->amount;
            $balance = (float)$total_credit - (float)$total_debit;

            if($request->amount > $balance){
                return back()->with('not_permitted', 'Withdraw !! you dont have sufficient balance');
            }

            $withdraw->update($data);

                $update_withdraw=$withdraw->update($data);
            //insert deposit data
                if($update_withdraw){
                    $tran = [];
                    $tran['account_id'] = $withdraw->account_id;
                    $tran['date'] = date("Y-m-d", strtotime($request->date));
                    $tran['reference'] = $withdraw->reference;
                    $tran['debit'] = $withdraw->amount;
                    $transaction->update($tran);
                }
            }
            catch(\Exception $e){
                $message = 'Something error fount';
            }

        return redirect('withdraws')->with('message', 'Bank withdraw updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $withdraw = Withdraw::find($id);
            $transaction = Transaction::where('transaction','=',$withdraw->transaction)->first();
            $transaction->delete();
        //delete  deposit
           $withdraw->delete();
           $message = 'Bank withdraw deleted successfully';
        }catch(\Exception $e){
                $message = 'Something error fount';
            }
        return redirect('withdraws')->with('message', $message);
    }
}
