<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Export;
use App\BankBranch;
use App\NotifyParty;
use App\ForwaringLetter;
use App\CommercialInvoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommercialInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CommercialInvoice::with('export')->get();
        return view('commercial_invoice.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exports = Export::all();
        $banks = Bank::all();
        $party = NotifyParty::all();
        return view('commercial_invoice.create', compact('exports','banks','party'));
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
            'export_id'=>'required',
            'exp_no'=>'required',
            'shipment_terms'=>'required',
            'payment_terms'=>'required',
            'port_destination'=>'required',
            'notify_party'=>'required',
            'bank_id'=>'required',
            'branch_id'=>'required',
            'description_good'=>'required',
            'ctn_qty'=>'required',
            'quantity_pcs'=>'required',
            'unit_price'=>'required',
            'total_price'=>'required',
        ]);

        $data = new CommercialInvoice();
        $data->date = $request->date;
        $data->export_id = $request->export_id;
        $data->exp_no = $request->exp_no;
        $data->shipment_terms = $request->shipment_terms;
        $data->payment_terms = $request->payment_terms;
        $data->port_loading = $request->port_loading;
        $data->port_destination = $request->port_destination;
        $data->notify_party = $request->notify_party;
        $data->bank_id = $request->bank_id;
        $data->branch_id = $request->branch_id;
        $data->description_good = json_encode($request->description_good);
        $data->ctn_qty = json_encode($request->ctn_qty);
        $data->quantity_pcs = json_encode($request->quantity_pcs);
        $data->unit_price = json_encode($request->unit_price);
        $data->total_price = json_encode($request->total_price);
        $data->save();

        return redirect('commercial-invoice')->with('message', 'Commercial Invoice Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = CommercialInvoice::with('export')->find($id);
        return view('commercial_invoice.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = CommercialInvoice::with('export')->find($id);
        $exports = Export::all();
        $banks = Bank::all();
        $party = NotifyParty::all();
        $branches = BankBranch::where('bank_id', $data->bank_id)->get();
        return view('commercial_invoice.edit', compact('data','exports','banks','party','branches'));
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
            'export_id'=>'required',
            'exp_no'=>'required',
            'shipment_terms'=>'required',
            'payment_terms'=>'required',
            'port_destination'=>'required',
            'notify_party'=>'required',
            'bank_id'=>'required',
            'branch_id'=>'required',
            'description_good'=>'required',
            'ctn_qty'=>'required',
            'quantity_pcs'=>'required',
            'unit_price'=>'required',
            'total_price'=>'required',
        ]);

        $data = CommercialInvoice::find($id);
        $data->date = $request->date;
        $data->export_id = $request->export_id;
        $data->exp_no = $request->exp_no;
        $data->shipment_terms = $request->shipment_terms;
        $data->payment_terms = $request->payment_terms;
        $data->port_loading = $request->port_loading;
        $data->port_destination = $request->port_destination;
        $data->notify_party = $request->notify_party;
        $data->bank_id = $request->bank_id;
        $data->branch_id = $request->branch_id;
        $data->description_good = json_encode($request->description_good);
        $data->ctn_qty = json_encode($request->ctn_qty);
        $data->quantity_pcs = json_encode($request->quantity_pcs);
        $data->unit_price = json_encode($request->unit_price);
        $data->total_price = json_encode($request->total_price);
        $data->update();

        return redirect('commercial-invoice')->with('message', 'Commercial Invoice Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = CommercialInvoice::find($id);
        $delete->delete();
        return redirect('commercial-invoice')->with('message', 'Data Deleted Successfully');
    }
}
