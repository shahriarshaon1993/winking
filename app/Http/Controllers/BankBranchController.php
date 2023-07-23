<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bank;
use App\BankBranch;

class BankBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lims_banks = Bank::where('is_active', true)->get();
        $lims_bank_branch_data = BankBranch::where('is_active', true)->get();
        return view('bank.branch_list',compact('lims_banks','lims_bank_branch_data'));


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
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'bank_id' => 'integer|required',
            'address' => 'required|string|max:200'
        ]);

        $data = $request->all();
        $data['is_active'] = true;
        BankBranch::create($data);

        return redirect('bank_branches')->with('message', 'Data inserted successfully');
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
        $lims_bank_branch_data = BankBranch::find($id);
        return $lims_bank_branch_data;
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
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'bank_id' => 'integer|required',
            'address' => 'required|string|max:200'
        ]);

        $lims_bank_branch_data = BankBranch::find($id);
        $data = $request->all();
        $lims_bank_branch_data->update($data);

        return redirect('bank_branches')->with('message', 'Data inserted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lims_bank_branch_data = BankBranch::find($id);
        $lims_bank_branch_data->delete();
        return redirect()->back()->with('message', 'Data deleted successfully');
    }
}
