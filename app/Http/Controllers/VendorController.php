<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vendor;
use App\ShipTo;
use App\InvoiceTo;
use App\Applicant;
use App\NotifyParty;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lims_vendor = Vendor::where('is_active',true)->get();
        return view('vendor.index',compact('lims_vendor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.create');
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
        try{
            Vendor::create($data);
            $message1 = 'Data inserted successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('vendors')->with('message1', $message1);
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
        $lims_vendor = Vendor::find($id);
        return $lims_vendor;
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
        try{
            Vendor::find($data['vendor_id'])->update($data);
            $message1 = 'Data updated successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('vendors')->with('message1', $message1);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();
        return redirect('vendors')->with('message1', 'Data deleted successfully');

    }

    public function shipList(){
        $lims_ship_to = ShipTo::where('is_active',true)->get();
        return view('ship.index',compact('lims_ship_to'));
    }

    public function shipToStore(Request $request){
        $data = $request->all();
        try{
            ShipTo::create($data);
            $message1 = 'Data inserted successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('ship_to')->with('message1', $message1);
    }

    public function shipEdit($id){
        $ship_to = ShipTo::find($id);
        return $ship_to;
    }

    public function ship_toUpdate(Request $request, $id){
        $data = $request->all();
        try{
            ShipTo::find($data['ship_to_id'])->update($data);
            $message1 = 'Data updated successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('ship_to')->with('message1', $message1);
    }

    public function shipDelete($id){
        $ship = ShipTo::find($id);
        $ship->delete();
        return redirect('ship_to')->with('message1', 'Data deleted successfully');
    }

    public function invoiceList(){
        $lims_invoice = InvoiceTo::where('is_active',true)->get();
        return view('invoice.index',compact('lims_invoice'));
    }

    public function invoiceToStore(Request $request){
        $data = $request->all();
        try{
            InvoiceTo::create($data);
            $message1 = 'Data inserted successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('invoice_to')->with('message1', $message1);
    }

    public function invoiceEdit($id){
       $invoice_to = InvoiceTo::find($id);
       return $invoice_to;
    }

    public function invoice_toUpdate(Request $request, $id){
        $data = $request->all();
        try{
            InvoiceTo::find($data['invoice_to_id'])->update($data);
            $message1 = 'Data updated successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('invoice_to')->with('message1', $message1);
    }

    public function invoiceDelete($id){
        $invoice = InvoiceTo::find($id);
        $invoice->delete();
        return redirect('invoice_to')->with('message1', 'Data deleted successfully');
    }

    public function applicantList(){
        $applicants = Applicant::where('is_active',true)->get();
        return view('applicant.list',compact('applicants'));
    }

    public function applicantStore(Request $request){
        $data = $request->all();
        try{
            Applicant::create($data);
            $message1 = 'Data inserted successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('applicant')->with('message1', $message1);
    }

    public function applicantEdit($id){
        $applicant = Applicant::find($id);
        return $applicant;
    }

    public function applicantUpdate(Request $request, $id){
        $data = $request->all();
        try{
            Applicant::find($data['applicant_id'])->update($data);
            $message1 = 'Data updated successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('applicant')->with('message1', $message1);
    }

    public function applicantDelete($id){
        $aplicant = Applicant::find($id)->delete();
        return redirect('applicant')->with('message1', 'Data deleted successfully');
    }


    public function notifyList(){
        $notify_parties = NotifyParty::where('is_active',true)->get();
        return view('notify_party.index',compact('notify_parties'));
    }

    public function notifyStore(Request $request){
        $data = $request->all();
        try{
            NotifyParty::create($data);
            $message1 = 'Data inserted successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('notify_party')->with('message1', $message1);
    }

    public function notifyEdit($id){
        $notify = NotifyParty::find($id);
        return $notify;
    }

    public function notifyUpdate(Request $request, $id){
        $data = $request->all();
        try{
            NotifyParty::find($data['notify_id'])->update($data);
            $message1 = 'Data updated successfully';

        }catch(\Exception $e){
            $message1 = 'Something error found';
        }
        return redirect('notify_party')->with('message1', $message1);
    }

    public function notifyDelete($id){
        $aplicant = NotifyParty::find($id)->delete();
        return redirect('notify_party')->with('message1', 'Data deleted successfully');
    }

}
