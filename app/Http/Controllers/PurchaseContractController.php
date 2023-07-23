<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Vendor;
use App\ShipTo;
use App\InvoiceTo;
use App\PurchaseContract;
USE App\PurchaseContractDetails;
use App\GeneralSetting;
use App\PaymentTerms;
use App\NotifyParty;
use App\Customer;
use Auth;

class PurchaseContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchase-contract-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_contract_all = PurchaseContract::where('is_active', true)->get();
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $notify_all = NotifyParty::where('is_active',true)->get();

            return view('purchase_contract.index',compact('lims_contract_all','lims_vendor_all','lims_invoice_to_all','notify_all','all_permission'));
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
        $lims_customer_all = Customer::where('is_active',true)->get();
        $lims_ship_to_all = ShipTo::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $notify_all = NotifyParty::where('is_active',true)->get();
        $lims_payment_terms = PaymentTerms::where('is_active',true)->get();
        return view('purchase_contract.create',compact('lims_vendor_all','lims_ship_to_all','lims_payment_terms','lims_invoice_to_all','notify_all','lims_customer_all'));
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
        $data =  $request->all();
        $data['vendor_date'] = date("Y-m-d", strtotime($request->vendor_date));
        $data['master_date'] = date("Y-m-d", strtotime($request->master_date));
        $data['delivery_date'] = date("Y-m-d", strtotime($request->delivery_date));
        $data['delivery_date_master'] = date("Y-m-d", strtotime($request->delivery_date_master));

        $data['is_active'] = true;
        $data['user_id'] = Auth::id();

        //upload document for master contract
        $document = $request->file('master_doc');
        if ($document) {
            //$img_name = $document->getClientOriginalName();
            $ext = strtolower($document->getClientOriginalExtension());
            $document_full_name = uniqid().".".$ext;
            $document_path = 'public/documents/master_contract/';
            $document_url = $document_path.$document_full_name;
            $success = $document->move($document_path,$document_full_name);
            if ($success) {
                $data['master_doc'] = $document_full_name;
            }
        }else{

            return redirect()->back()->with('not_permitted','Please upload master contarct document');
        }

        //upload document for master contract
        $document_two = $request->file('contract_doc');
        if ($document_two) {
            //$img_name = $document->getClientOriginalName();
            $ext2 = strtolower($document_two->getClientOriginalExtension());
            $document_full_name2 = uniqid().".".$ext2;
            $document_path2 = 'public/documents/purchase_contract/';
            $document_url2 = $document_path2.$document_full_name2;
            $success = $document_two->move($document_path2,$document_full_name2);
            if ($success) {
                $data['contract_doc'] = $document_full_name2;
            }
        }else{

            return redirect()->back()->with('not_permitted','Please upload master contarct document');
        }

        try {
            $contract = PurchaseContract::create($data);
            $message = "Data insert successfully";
         }
         catch(\Exception $e){
             $message = 'Something error found';
         }
        return redirect('purchase_contract')->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lims_contract_data = PurchaseContract::find($id);
        $general_setting = GeneralSetting::first();
        $details = PurchaseContractDetails::where('contract_id',$id)->get();
        return view('purchase_contract.view',compact('lims_contract_data','general_setting','details'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lims_contract_data = PurchaseContract::find($id);
        $details = PurchaseContractDetails::where('contract_id',$id)->get();
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_ship_to_all = ShipTo::where('is_active',true)->get();
        $notify_all = NotifyParty::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_payment_terms = PaymentTerms::where('is_active',true)->get();
        return view('purchase_contract.edit',compact('lims_vendor_all','lims_ship_to_all','lims_contract_data','details','lims_payment_terms','lims_invoice_to_all','notify_all','lims_customer_all'));
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
        $data =  $request->all();
        $data['vendor_date'] = date("Y-m-d", strtotime($request->vendor_date));
        $data['master_date'] = date("Y-m-d", strtotime($request->master_date));
        $data['delivery_date'] = date("Y-m-d", strtotime($request->delivery_date));
        $data['delivery_date_master'] = date("Y-m-d", strtotime($request->delivery_date_master));

        $data['is_active'] = true;
        $data['user_id'] = Auth::id();

        $purchase_contract = PurchaseContract::findOrFail($id);
        //Updating Master Contract Document
        if (($request->file('master_doc')) !== null) {
            $document = $request->file('master_doc');
            if ($document) {
                //$img_name = $document->getClientOriginalName();
                $ext = strtolower($document->getClientOriginalExtension());
                $document_full_name = uniqid().".".$ext;
                $document_path = 'public/documents/master_contract/';
                $document_url = $document_path.$document_full_name;
                $success = $document->move($document_path,$document_full_name);
                if ($success) {
                    $data['master_doc'] = $document_full_name;
                    $old_document = $document_path.$purchase_contract->master_doc;
                    if (file_exists($old_document)) {
                        @unlink($old_document);
                    }
                }
            }else{

                return redirect()->back()->with('not_permitted','Please upload master contarct document');
            }
        }else{
            $data['master_doc'] = $purchase_contract->master_doc;
        }


        //Updating Purchase Contract Document
        if (($request->file('contract_doc')) !== null) {
            $document_two = $request->file('contract_doc');
            if ($document_two) {
                //$img_name = $document->getClientOriginalName();
                $ext2 = strtolower($document_two->getClientOriginalExtension());
                $document_full_name2 = uniqid().".".$ext2;
                $document_path2 = 'public/documents/purchase_contract/';
                $document_url2 = $document_path2.$document_full_name2;
                $success = $document_two->move($document_path2,$document_full_name2);
                if ($success) {
                    $data['contract_doc'] = $document_full_name2;
                    $old_document = $document_path2.$purchase_contract->contract_doc;
                    if (file_exists($old_document)) {
                        @unlink($old_document);
                    }
                }
            }else{

                return redirect()->back()->with('not_permitted','Please upload master contarct document');
            }
        }else{
            $data['contract_doc'] = $purchase_contract->contract_doc;
        }

        try {
            $purchase_contract->update($data);
            $message = "Data updated successfully";

        }
        catch(\Exception $e){
            $message = 'Something error found';
        }
        return redirect('purchase_contract')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PurchaseContract::find($id)->delete();
        PurchaseContractDetails::where('contract_id', $id)->delete();
        return redirect('purchase_contract')->with('message','Data deleted successfully');
    }

    public function print($id){
        $lims_contract_data = PurchaseContract::find($id);
        $general_setting = GeneralSetting::first();
        $details = PurchaseContractDetails::where('contract_id',$id)->get();
        return view('purchase_contract.print',compact('lims_contract_data','general_setting','details'));
    }

    public function proforma_invoice($id){
        $lims_contract_data = PurchaseContract::find($id);
        $general_setting = GeneralSetting::first();
        $details = PurchaseContractDetails::where('contract_id',$id)->get();
        return view('purchase_contract.proforma_invoice',compact('lims_contract_data','general_setting','details'));
    }

    public function getFiltering(){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchase-contract-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_contract_all = PurchaseContract::where('is_active', true)->get();
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $notify_all = NotifyParty::where('is_active',true)->get();

            return view('purchase_contract.index',compact('lims_contract_all','lims_vendor_all','lims_invoice_to_all','notify_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function filtering(Request $request){
        if(($request->vendor_id == null) && ($request->notify_id == null)){
            return redirect()->back()->with('not_permitted','Please select filtering criteria');
        }

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchase-contract-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $vendorId = $request->vendor_id;
        $notifyId = $request->notify_id;

        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $notify_all = NotifyParty::where('is_active',true)->get();

        $lims_contract_all = PurchaseContract::where(function ($query) use ($notifyId,$vendorId){
               if($vendorId != null && $notifyId != null ){
                    return $query->where('vendor_id',$vendorId)
                                 ->where('notify_id',$notifyId);
               }elseif($vendorId != null){
                     return $query->where('vendor_id',$vendorId);
               }elseif($notifyId != null){
                return $query->where('notify_id',$notifyId);
               }
        })->where('is_active', true)->get();

            return view('purchase_contract.index',compact('lims_contract_all','lims_vendor_all','notifyId','vendorId','notify_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }
}
