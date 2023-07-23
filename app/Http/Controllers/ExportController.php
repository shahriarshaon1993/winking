<?php

namespace App\Http\Controllers;

use App\Export;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Customer;
use App\ShipTo;
use App\Vendor;
use Complex\Exception;
use Auth;


class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('export-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_shipper_all = ShipTo::where('is_active', true)->get();
        $lims_export_all = Export::where('status',true)->orderBy('id','DESC')->get();

            return view('export.index',compact('lims_export_all','lims_shipper_all','lims_customer_all','all_permission'));
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
        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_ship_to_all = ShipTo::where('is_active', true)->get();
        $lims_shipper_all = Vendor::where('is_active', true)->get();
        return view('export.create',compact('lims_customer_all','lims_ship_to_all','lims_shipper_all'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->payment_date);
        $validateDate= [];

        $validateDate['invoice_no']= 'required|string|max:50';
        $validateDate['date']= 'required|date';
        $validateDate['ship_to_id']= 'required|integer';
        $validateDate['lc_number']= 'required|string|max:20';
        $validateDate['contact_number']= 'required|string|max:30';
        $validateDate['customer_id']= 'required|integer';
        $validateDate['quantity_pcs']= 'required|integer';
        $validateDate['quantity_crt']= 'required|numeric';
        $validateDate['invoice_value']= 'required|numeric';
        $validateDate['shipper_invoice_value']= 'required|numeric';
        $validateDate['due_date']= 'required';
        $validateDate['export_status']= 'required|string';

        if($request->export_status == "Received"){
            $validateDate['payment_date']= 'required';
        }
            // [
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => ,
                // '' => 'required',
            // ]
        // ];
        $this->validate($request, $validateDate,[
            'customer_id.required' => 'Please select customer',
            'ship_to_id.required' => 'Please select Shipper',
        ]);

        $data = $request->all();
        $data['date'] = date("Y-m-d", strtotime($request->date));
        $data['etd'] = date("Y-m-d", strtotime($request->etd));
        $data['eta'] = date("Y-m-d", strtotime($request->eta));
        $data['due_date'] = date("Y-m-d", strtotime($request->due_date));

        $data['user_id'] = Auth::id();
        $data['status'] = true;

        try{
            Export::create($data);
            $message ="Data inserted successfuly";
        }catch(\Exception $e){
            $message ="Something error  found.";
        }
        return redirect('export')->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function show(Export $export)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_ship_to_all = ShipTo::where('is_active', true)->get();
        $lims_shipper_all = Vendor::where('is_active', true)->get();
        $export = Export::find($id);
        return view('export.edit',compact('lims_customer_all','lims_shipper_all','export','lims_ship_to_all'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['date'] = date("Y-m-d", strtotime($request->date));
        $data['etd'] = date("Y-m-d", strtotime($request->etd));
        $data['eta'] = date("Y-m-d", strtotime($request->eta));
        $data['due_date'] = date("Y-m-d", strtotime($request->due_date));

        try{
            $export = Export::find($id);
            $export->update($data);
            $message ="Data updated successfuly";
        }catch(\Exception $e){
            dd($e);
            $message ="Something error  found.";
        }
        return redirect('export')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $export = Export::find($id)->delete();
            $message ="Data Deleted successfuly";
        }catch(\Exception $e){
            $message ="Something error  found.";
        }
        return redirect('export')->with('message',$message);
    }

    public function getFiltering(){

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('export-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_shipper_all = ShipTo::where('is_active', true)->get();
        $lims_export_all = Export::where('status',true)->orderBy('id','DESC')->get();

            return view('export.index',compact('lims_export_all','lims_shipper_all','lims_customer_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    public function filtering(Request $request){
        //return $request->all();
        if($request->customer_id == null && $request->ship_to_id == null && $request->account_of == null && $request->payment_status == null){
            return redirect()->back()->with('not_permitted','Please select filtering criteria');
        }

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('export-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_shipper_all = ShipTo::where('is_active', true)->get();

        $customerId = $request->customer_id;
        $shipId = $request->ship_to_id;
        $accountOf = $request->account_of;
        $status = $request->payment_status;

        $lims_export_all = Export::where(function($query) use($customerId,$shipId,$accountOf,$status){
                        if($customerId != null && $accountOf != null && $shipId != null && $status != null){
                            return $query->where('customer_id',$customerId)
                                         ->where('ship_to_id',$shipId)
                                         ->where('account_of',$accountOf)
                                         ->where('export_status',$status);
                        }if($customerId != null && $accountOf != null && $status != null){
                            return $query->where('customer_id',$customerId)
                                         ->where('account_of',$accountOf)
                                         ->where('export_status',$status);
                        }
                        elseif($customerId != null && $accountOf != null && $shipId != null){
                            return $query->where('customer_id',$customerId)
                                         ->where('ship_to_id',$shipId)
                                         ->where('account_of',$accountOf);
                        }elseif($customerId != null &&  $shipId != null && $status != null){
                            return $query->where('customer_id',$customerId)
                                         ->where('ship_to_id',$shipId)
                                         ->where('export_status',$status);
                        }elseif($accountOf != null && $shipId != null && $status != null){
                            return $query->where('ship_to_id',$shipId)
                                         ->where('account_of',$accountOf)
                                         ->where('export_status',$status);
                        }elseif($customerId != null && $accountOf != null ){
                             return $query->where('customer_id',$customerId)
                                         ->where('account_of',$accountOf);
                        }elseif($customerId != null  && $shipId != null){
                            return $query->where('customer_id',$customerId)
                                         ->where('ship_to_id',$shipId);
                        }elseif($customerId != null && $status != null){
                            return $query->where('customer_id',$customerId)
                                         ->where('export_status',$status);
                        }elseif($accountOf != null && $shipId != null){
                           return $query->where('ship_to_id',$shipId)
                                         ->where('account_of',$accountOf);
                        }elseif($accountOf != null && $status != null){
                            return $query->where('account_of',$accountOf)
                                         ->where('export_status',$status);
                        }elseif($shipId != null && $status != null){
                            return $query->where('ship_to_id',$shipId)
                                         ->where('export_status',$status);
                        }elseif($customerId != null){
                            return $query->where('customer_id',$customerId);
                        }elseif( $accountOf != null){
                            return $query->where('account_of',$accountOf);
                        }elseif( $shipId != null){
                            return $query->where('ship_to_id',$shipId);
                        }elseif($status != null){
                            return $query->where('export_status',$status);
                        }

        })->where('status', true)->orderBy('id','DESC')->get();

            return view('export.index',compact('lims_export_all','lims_shipper_all','lims_customer_all','all_permission','status','accountOf','customerId','shipId'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    public function deleteBySelection(Request $request){

        $export_id = $request['exportIdArray'];
        foreach ($export_id as $id) {
            $lims_expense_data = Export::find($id);
            $lims_expense_data->delete();
        }
        return 'Export deleted successfully!';
    }
}
