<?php

namespace App\Http\Controllers;

use App\Export;
use App\Bank;
use App\BankBranch;
use App\ForwaringLetter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForwardingLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $forwardLetters = ForwaringLetter::with('bank','account','export')->get();
       return view('forwarding_letter.index', compact('forwardLetters'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks= Bank::all();
        $exports= Export::all();
        return view('forwarding_letter.create', compact('banks', 'exports'));
    }

    public function getExport(Request $request){
        $export = Export::find($request->exportId);

        return response()->json([
                    'invoiceAmount'    => $export->invoice_value,
                    'invoiceNumber'    => $export->invoice_no,
                    'invoiceDate'      => $export->date,
                    'shipperToId'      => $export->shipper->name,
                    'lcNumber'         => $export->lc_number,
                    'address'         => $export->customer->address,
                    'customerName'         => $export->customer->name,

        ]);
        return response()->json($export);
    }

    public function AllBranches(Request $request)
    {
        try{
            $bank_id = $request->bank_id;
            $branches = BankBranch::where('bank_id', $bank_id)->get();
            return response()->json($branches);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'date'=>'required',
            'reference'=>'required',
            'reference_bank_id'=>'required',
            'ref_branch_id'=>'required',
            'export_id'=>'required',
            'shipper_bank'=>'required',
            'shipper_ref'=>'required',
        ]);

        $forwardingLetter= new ForwaringLetter();
        $forwardingLetter->date = $request->date;
        $forwardingLetter->reference = $request->reference;
        $forwardingLetter->reference_bank_id = $request->reference_bank_id;
        $forwardingLetter->ref_branch_id = $request->ref_branch_id;
        $forwardingLetter->export_id = $request->export_id;
        $forwardingLetter->shipper_bank = $request->shipper_bank;
        $forwardingLetter->shipper_ref = $request->shipper_ref;
        $forwardingLetter->save();

        return redirect('forwarding-letter')->with('message', 'Forwarding Letter Submitted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $forwardLetter = ForwaringLetter::with('bank','branch','account','export')->find($id);
        return view('forwarding_letter.show', compact('forwardLetter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banks= Bank::all();
        $exports= Export::all();
        $forwardLetter = ForwaringLetter::with('account','export')->find($id);
        $branches = BankBranch::where('bank_id',$forwardLetter->reference_bank_id)->get();
        return view('forwarding_letter.edit', compact('forwardLetter','banks','exports','branches'));
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
        $request->validate([
            'date'=>'required',
            'reference'=>'required',
            'reference_bank_id'=>'required',
            'ref_branch_id'=>'required',
            'export_id'=>'required',
            'shipper_bank'=>'required',
            'shipper_ref'=>'required',
        ]);

        $forwardingLetter = ForwaringLetter::find($id);
        $forwardingLetter->date = $request->date;
        $forwardingLetter->reference = $request->reference;
        $forwardingLetter->reference_bank_id = $request->reference_bank_id;
        $forwardingLetter->ref_branch_id = $request->ref_branch_id;
        $forwardingLetter->export_id = $request->export_id;
        $forwardingLetter->shipper_bank = $request->shipper_bank;
        $forwardingLetter->shipper_ref = $request->shipper_ref;
        $forwardingLetter->update();
        return redirect('forwarding-letter')->with('message', 'Forwarding Letter Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = ForwaringLetter::find($id);
        $delete->delete();
        return redirect('forwarding-letter');
    }
}
