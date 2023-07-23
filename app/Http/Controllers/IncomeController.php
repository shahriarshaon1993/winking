<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Auth;
use App\Income;
use App\Account;
use App\IncomeSource;
use App\Transaction;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lims_account_list = Account::where('is_active', true)->get();
        $lims_income_list = Income::where('is_active', true)->get();
        return view('income.index',compact('lims_income_list','lims_account_list'));
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
        $data['income_date'] = date("Y-m-d", strtotime($request->income_date));
        $data['reference_no'] = 'er-' . date("Ymd") . '-'. date("his");
        $data['user_id'] = Auth::id();
        $data['warehouse_id'] = 1;
        $data['is_active'] = true;

        $income = Income::create($data);
        $income_source = IncomeSource::where('id',$request->income_source_id)->pluck('name');

        if($income){
            $tran = [];
            $tran['user_id'] = Auth::id();
            $tran['account_id'] = $income->account_id;
            $tran['reference'] = $income->reference;
            $tran['date'] = date("Y-m-d", strtotime($request->income_date));
            $tran['description'] = 'Income from '.$income_source;
            $tran['credit'] = $income->amount;
            $tran['debit'] = 0;
            $tran['transaction'] = $income->reference_no;
            Transaction::create($tran);
        }
        return redirect('incomes')->with('message', 'Data inserted successfully');
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
        $lims_income_data = Income::find($id);
        return $lims_income_data;
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
        $data['income_date'] = date("Y-m-d", strtotime($request->income_date));
        $lims_income_data = Income::find($data['income_id']);
        $lims_income_data->update($data);

        $transaction = Transaction::where('transaction','=',$lims_income_data->reference_no)->first();
        if($transaction){
            $tran = [];
            $tran['account_id'] = $request->account_id;
            $tran['date'] = date("Y-m-d", strtotime($request->income_date));
            $tran['credit'] = $request->amount;
        }
        $transaction->update($tran);

        return redirect('incomes')->with('message', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $income = Income::find($id)->first();
        $transaction = Transaction::where('transaction',$income->reference_no)->first();

        // Update Account Total Balance
//        $account = Account::find($transaction->account_id)->first();
//        if($account->total_balance > $income->amount){
//            $updateBlance = $account->total_balance - $income->amount;
//        }else{
//            $updateBlance =  $income->amount - $account->total_balance;
//        }
//        // Update Account Total Balance
//        $account->total_balance = $updateBlance;
//        $account->save();

        // Delete Selected Income And Transaction
        $transaction->delete();
        $income->delete();

        return redirect('incomes')->with('message', 'Data deleted successfully');
    }
}
