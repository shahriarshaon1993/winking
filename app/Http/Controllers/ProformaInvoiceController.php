<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Vendor;
use App\Customer;
use App\InvoiceTo;
use App\ProformaInvoice;
use Auth;

class ProformaInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('proforma-invoice-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_invoice_all = ProformaInvoice::where('is_active',true)->get();

        //dd($quantity_sum);
       // dd($lims_invoice_all);
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();

            return view('proforma_invoice.index',compact('lims_invoice_all','lims_invoice_to_all','lims_customer_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();
        return view('proforma_invoice.create',compact('lims_vendor_all','lims_invoice_to_all','lims_customer_all'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();
        $data = $request->all();
        $data['date'] = date("Y-m-d", strtotime($request->date));
        if( !empty($data['revised_date']) ){
            $data['revised_date'] = date("Y-m-d", strtotime($request->revised_date));
        }
        $data['delivery_date'] = date("Y-m-d", strtotime($request->delivery_date));

        $data['is_active'] = true;
        $data['user_id'] = Auth::id();

        $document = $request->file('document');
        if ($document) {
            //$img_name = $document->getClientOriginalName();
            $ext = strtolower($document->getClientOriginalExtension());
            $document_full_name = uniqid().".".$ext;
            $document_path = 'public/documents/invoice/';
            $document_url = $document_path.$document_full_name;
            $success = $document->move($document_path,$document_full_name);
            if ($success) {
                $data['document'] = $document_full_name;
            }
        }else{

            return redirect()->back()->with('not_permitted','Please upload performa invoice document');
        }
        try {
            ProformaInvoice::create($data);
            $message = "Data insert successfully";
        }
        catch(\Exception $e){
            $message = 'Something error found';
        }
        return redirect('proforma_invoice')->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lim_invoice_data = ProformaInvoice::find($id);
        return view('proforma_invoice.view',compact('lim_invoice_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();
        $lim_invoice_data = ProformaInvoice::find($id);

        return view('proforma_invoice.edit',compact('lims_vendor_all','lims_invoice_to_all','lim_invoice_data','lims_customer_all'));
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
        if(!empty($data['revised_date'])){
            $data['revised_date'] = date("Y-m-d", strtotime($request->revised_date));
        }
        $data['delivery_date'] = date("Y-m-d", strtotime($request->delivery_date));

        $data['is_active'] = true;
        $data['user_id'] = Auth::id();

        $invoice = ProformaInvoice::find($id);

        if (($request->file('document')) !== null) {
            $document = $request->file('document');
            if ($document) {
                //$img_name = $document->getClientOriginalName();
                $ext = strtolower($document->getClientOriginalExtension());
                $document_full_name = uniqid().".".$ext;
                $document_path = 'public/documents/invoice/';
                $document_url = $document_path.$document_full_name;
                $success = $document->move($document_path,$document_full_name);
                if ($success) {
                    $data['document'] = $document_full_name;
                    $old_document = $document_path.$invoice->document;
                    if (file_exists($old_document)) {
                        @unlink($old_document);
                    }
                }
            }else{

                return redirect()->back()->with('not_permitted','Please upload performa invoice document');
            }

        }else{
            $data['document'] = $invoice->document;
        }

        try {
            $invoice->update($data);
            $message = "Data updated successfully";
        }
        catch(\Exception $e){
            $message = 'Something error found';
        }
        return redirect('proforma_invoice')->with('message',$message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $invoice = ProformaInvoice::find($id)->delete();
            $message = "Data deleted successfully";
        }
        catch(\Exception $e){
            $message = 'Something error found';
        }
        return redirect()->back()->with('message',$message);
    }

    public function print($id){
        $lim_invoice_data = ProformaInvoice::find($id);
        return view('proforma_invoice.print',compact('lim_invoice_data'));
    }

    public function getFiltering(){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('proforma-invoice-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_invoice_all = ProformaInvoice::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();

            return view('proforma_invoice.index',compact('lims_invoice_all','lims_invoice_to_all','lims_customer_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function filtering(Request $request){
        //return $request->all();
        if($request->customer_id == null && $request->invoice_to_id == null && $request->status == null){
            return redirect()->back()->with('not_permitted','Please select filtering criteria');
        }

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('proforma-invoice-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();

        $customerId = $request->customer_id;
        $invoiceId = $request->invoice_to_id;
        $status = $request->status;

        $lims_invoice_all = ProformaInvoice::where(function($query) use($customerId,$invoiceId,$status){
                        if($customerId != null && $invoiceId != null && $status != null){
                            return $query->where('customer_id',$customerId)
                                          ->where('invoice_to_id',$invoiceId)
                                          ->where('status',$status);
                        }elseif($invoiceId != null && $customerId != null){
                            return $query->where('customer_id',$customerId)
                                    ->where('invoice_to_id',$invoiceId);
                        }elseif($invoiceId != null && $status != null){
                            return $query->where('invoice_to_id',$invoiceId)->where('status',$status);
                        }
                        elseif($customerId != null && $status != null){
                            return $query->where('customer_id',$customerId)
                                         ->where('status',$status);
                        }else if($customerId != null){
                            return $query->where('customer_id',$customerId);
                        }else if($invoiceId != null){
                            return $query->where('invoice_to_id',$invoiceId);
                        }else if($status != null){
                            return $query->where('status',$status);
                        }

        })->where('is_active', true)->get();
            return view('proforma_invoice.index',compact('lims_invoice_all','lims_invoice_to_all','lims_customer_all','invoiceId','customerId','all_permission','status'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');






    }
}
