<?php

namespace App\Http\Controllers;

use App\CostBreakdown;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Customer;
use App\Vendor;
use Auth;

class CostBreakdownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('cost-breakdown-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $breakdown_all = CostBreakdown::where('is_active', true)->orderBy('id','DESC')->get();
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();

            return view('cost_breakdown.index',compact('breakdown_all','lims_vendor_all','lims_customer_all','all_permission'));
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
        $lims_customer_all = Customer::where('is_active', true)->get();
        return view('cost_breakdown.create',compact('lims_customer_all','lims_vendor_all'));
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
        $data['delivery_date'] = date("Y-m-d", strtotime($request->delivery_date));

        $data['is_active'] = true;
        $data['user_id'] = Auth::id();

        //upload document for master contract
        $document = $request->file('document');
        if ($document) {
            //$img_name = $document->getClientOriginalName();
            $ext = strtolower($document->getClientOriginalExtension());
            $document_full_name = uniqid().".".$ext;
            $document_path = 'public/documents/master_contract/';
            $document_url = $document_path.$document_full_name;
            $success = $document->move($document_path,$document_full_name);
            if ($success) {
                $data['document'] = $document_full_name;
            }
        }else{

            return redirect()->back()->with('not_permitted','Please upload cost breakdown document');
        }

        try {
            $contract = CostBreakdown::create($data);
            $message = "Data insert successfully";
         }
         catch(\Exception $e){
             $message = 'Something error found';
         }
        return redirect('cost_breakdowns')->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CostBreakdown  $costBreakdown
     * @return \Illuminate\Http\Response
     */
    public function show(CostBreakdown $costBreakdown)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CostBreakdown  $costBreakdown
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $breakdown = CostBreakdown::findOrFail($id);
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();
        return view('cost_breakdown.edit',compact('lims_customer_all','lims_vendor_all','breakdown'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CostBreakdown  $costBreakdown
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data =  $request->all();
        $data['delivery_date'] = date("Y-m-d", strtotime($request->delivery_date));

        $data['is_active'] = true;
        $data['user_id'] = Auth::id();

        $cost_breakdown = CostBreakdown::findOrFail($id);
        //Updating Master Contract Document
        if (($request->file('document')) !== null) {
            $document = $request->file('document');
            if ($document) {
                //$img_name = $document->getClientOriginalName();
                $ext = strtolower($document->getClientOriginalExtension());
                $document_full_name = uniqid().".".$ext;
                $document_path = 'public/documents/master_contract/';
                $document_url = $document_path.$document_full_name;
                $success = $document->move($document_path,$document_full_name);
                if ($success) {
                    $data['document'] = $document_full_name;
                    $old_document = $document_path.$cost_breakdown->document;
                    if (file_exists($old_document)) {
                        @unlink($old_document);
                    }
                }
            }else{

                return redirect()->back()->with('not_permitted','Please upload master contarct document');
            }
        }else{
            $data['document'] = $cost_breakdown->document;
        }

        try {
            $cost_breakdown->update($data);
            $message = "Data updated successfully";

        }
        catch(\Exception $e){
            $message = 'Something error found';
        }
        return redirect('cost_breakdowns')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CostBreakdown  $costBreakdown
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $cost_breakdown = CostBreakdown::findOrFail($id);
            $document_path = 'public/documents/master_contract/';
            $old_document = $document_path.$cost_breakdown->document;
                if (file_exists($old_document)) {
                    @unlink($old_document);
                }
            $cost_breakdown->delete();
            $message = "Data deleted successfully";

        }
        catch(\Exception $e){
            $message = 'Something error found';
        }
        return redirect('cost_breakdowns')->with('message',$message);
    }

    public function getFiltering(Request $request){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('cost-breakdown-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $breakdown_all = CostBreakdown::where('is_active', true)->get();
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();

            return view('cost_breakdown.index',compact('breakdown_all','lims_vendor_all','lims_customer_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function filtering(Request $request){
        if(($request->customer_id == null) && ($request->vendor_id == null) && ($request->account_of == null) && ($request->status == null)){
            return redirect()->back()->with('not_permitted','Please select filtering criteria');
        }

        $customerId = $request->customer_id;
        $vendorId = $request->vendor_id;
        $accountId = $request->account_of;
        $status = $request->status;

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('cost-breakdown-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';


        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();

        $breakdown_all = CostBreakdown::where('is_active', true);
            if($customerId != null){
                $breakdown_all = $breakdown_all->where('customer_id',$customerId);
            }
            if($vendorId != null){
                $breakdown_all = $breakdown_all->where('vendor_id',$vendorId);
            }
            if($accountId != null){
                $breakdown_all = $breakdown_all->where('account_of',$accountId);
            }
            if($status != null){
                $breakdown_all = $breakdown_all->where('status',$status);
            }
            $breakdown_all = $breakdown_all->get();


            return view('cost_breakdown.index',compact('breakdown_all','lims_vendor_all','lims_customer_all','accountId','customerId','vendorId','all_permission','status'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
}
