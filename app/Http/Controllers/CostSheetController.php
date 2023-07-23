<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Customer;
use App\CostSheet;
use App\CostSheetDetails;
use App\Fabric;
use App\PaymentTerms;
use App\Trimming;
use Auth;
use DB;

class CostSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('cost-sheet-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
                
        $lims_cost_all = CostSheet::where('is_active',true)->orderBy('id','DESC')->get();
        $lims_customer_all = Customer::where('is_active', true)->get();   
            
            return view('cost_sheet.list',compact('lims_cost_all','lims_customer_all','all_permission'));
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
        $lim_payment_terms = PaymentTerms::where('is_active', true)->get();
        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_trean_data = Trimming::where('is_active',true)->get();
        return view('cost_sheet.create',compact('lims_customer_all','lim_payment_terms','lims_trean_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'customer_id' => 'required|integer',
            'style_no' => 'string|required|max:100',
            'season' => 'string|nullable|max:100',
            'brand' => 'string|required|max:100',
            'size_scale' => 'string|required|max:100',
            'item_description' => 'required|string|max:200',
            'order_quantity' => 'required|integer|min:0',
            'target_price' => 'required|numeric|min:0',
            'fabric_total_cost' => 'required|numeric|min:0',
            'trim_total_cost' => 'required|numeric|min:0',

            'making_price' => 'required|numeric|min:0',
            'washing_description' => 'nullable|string|max:255',
            'washing_price' => 'required|numeric|min:0',
            'dry_process_price' => 'required|numeric|min:0',
            'other_price' => 'required|numeric|min:0',
            'dry_process_description' => 'nullable|string|max:255',


            'fabric.*' => 'required|string|max:200',
            'fabric_item_code.*' => 'string|nullable|max:100',
            'fabric_item_description.*' => 'nullable|string|max:255',
            'fabric_price.*' => 'required|numeric|min:0',
            'fabric_consumption.*' => 'required|numeric|min:0',
            'fabric_wastage.*' => 'required|numeric|min:0',
            'fabric_total_price.*' => 'required|numeric|min:0',

            'trimming.*' => 'required|string|max:200',
            'trim_item_code.*' => 'string|nullable|max:100',
            'trim_item_description.*' => 'string|nullable|max:255',
            'trim_price.*' => 'required|numeric|min:0',
            'trim_consumption.*' => 'required|numeric|min:0',
            'trim_wastage.*' => 'required|numeric|min:0',
            'trim_total_price.*' => 'required|numeric|min:0',

            'cmptw_total_price' => 'required|numeric|min:0',
            'fob_total_price' => 'required|numeric|min:0',
            'tf_wastage' => 'required|numeric|min:0',
            'tf_cost' => 'required|numeric|min:0',
            'cil_price' => 'numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'cost_per_pc' => 'required|numeric|min:0',

        ],[
            'customer_id.required' => 'Please select customer'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['is_active'] = true;
        
        DB::beginTransaction();
        try{
            $cost_sheet = CostSheet::create($data);

            $fabric = [];
            foreach($request->fabric_total_price as $key=>$price){
                $fabric['cost_sheet_id'] = $cost_sheet->id;
                $fabric['fabric'] = $data['fabric'][$key];
                $fabric['fabric_item_code'] = $data['fabric_item_code'][$key];
                $fabric['fabric_item_description'] = $data['fabric_item_description'][$key];
                $fabric['fabric_price'] = $data['fabric_price'][$key];
                $fabric['fabric_consumption'] = $data['fabric_consumption'][$key];
                $fabric['fabric_consump_unit'] = $data['fabric_consump_unit'][$key];
                $fabric['fabric_wastage'] = $data['fabric_wastage'][$key];
                $fabric['fabric_total_price'] = $price;
                $fabric['is_active'] = true;

                Fabric::create($fabric);
            }

            $details = [];
            foreach($request->trim_total_price as $key=>$price){
                $details['cost_sheet_id'] = $cost_sheet->id;
                $details['trimming'] = $data['trimming'][$key];
                $details['trim_item_code'] = $data['trim_item_code'][$key];
                $details['trim_item_description'] = $data['trim_item_description'][$key];
                $details['trim_price'] = $data['trim_price'][$key];
                $details['trim_consumption'] = $data['trim_consumption'][$key];
                $details['trim_consump_unit'] = $data['trim_consump_unit'][$key];
                $details['trim_wastage'] = $data['trim_wastage'][$key];
                $details['trim_total_price'] = $price;
                $details['is_active'] = true;

                CostSheetDetails::create($details);
            }
            DB::commit();
            $message = 'Cost sheet added successfully';
        }catch(\Exception $e){
            DB::rollback();
//            $message = 'something wrong !';
            dd($e->getMessage());
        }
        return redirect('cost_sheet')->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lims_cost_data = CostSheet::find($id);
        $lims_fabrics_all = Fabric::where('cost_sheet_id',$id)->get();
        $lims_details_all = CostSheetDetails::where('cost_sheet_id',$id)->get();
        return view('cost_sheet.view',compact('lims_cost_data','lims_fabrics_all','lims_details_all'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_cost_data = CostSheet::find($id);
        $lims_fabrics_all = Fabric::where('cost_sheet_id',$id)->get();
        $lims_details_all = CostSheetDetails::where('cost_sheet_id',$id)->get();
        return view('cost_sheet.edit',compact('lims_customer_all','lims_cost_data','lims_fabrics_all','lims_details_all'));
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
        $this->validate($request,[
            'customer_id' => 'required|integer',
            'style_no' => 'string|required|max:100',
            'season' => 'string|nullable|max:100',
            'brand' => 'string|required|max:100',
            'size_scale' => 'string|required|max:100',
            'item_description' => 'required|string|max:200',
            'order_quantity' => 'required|integer|min:0',
            'target_price' => 'required|numeric|min:0',
            'fabric_total_cost' => 'required|numeric|min:0',
            'trim_total_cost' => 'required|numeric|min:0',

            'making_price' => 'required|numeric|min:0',
            'washing_description' => 'nullable|string|max:255',
            'washing_price' => 'required|numeric|min:0',
            'dry_process_price' => 'required|numeric|min:0',
            'other_price' => 'required|numeric|min:0',
            'dry_process_description' => 'nullable|string|max:255',


            'fabric.*' => 'required|string|max:200',
            'fabric_item_code.*' => 'string|nullable|max:100',
            'fabric_item_description.*' => 'nullable|string|max:255',
            'fabric_price.*' => 'required|numeric|min:0',
            'fabric_consumption.*' => 'required|numeric|min:0',
            'fabric_wastage.*' => 'required|numeric|min:0',
            'fabric_total_price.*' => 'required|numeric|min:0',

            'trimming.*' => 'required|string|max:200',
            'trim_item_code.*' => 'string|nullable|max:100',
            'trim_item_description.*' => 'string|nullable|max:255',
            'trim_price.*' => 'required|numeric|min:0',
            'trim_consumption.*' => 'required|numeric|min:0',
            'trim_wastage.*' => 'required|numeric|min:0',
            'trim_total_price.*' => 'required|numeric|min:0',

            'cmptw_total_price' => 'required|numeric|min:0',
            'fob_total_price' => 'required|numeric|min:0',
            'tf_wastage' => 'required|numeric|min:0',
            'tf_cost' => 'required|numeric|min:0',
            'cil_price' => 'numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
            'cost_per_pc' => 'required|numeric|min:0',

        ],[
            'customer_id.required' => 'Please select customer'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['is_active'] = true;
        
        DB::beginTransaction();

        try{
            $cost_sheet = CostSheet::findOrFail($id);
            $cost_sheet->update($data);

            //delete previous details
            $fabric = Fabric::where('cost_sheet_id', $id)->delete();

        if ($request->fabric_total_price != null) {
            $fabric = [];
            foreach($request->fabric_total_price as $key=>$price){
                $fabric['cost_sheet_id'] = $cost_sheet->id;
                $fabric['fabric'] = $data['fabric'][$key];
                $fabric['fabric_item_code'] = $data['fabric_item_code'][$key];
                $fabric['fabric_item_description'] = $data['fabric_item_description'][$key];
                $fabric['fabric_price'] = $data['fabric_price'][$key];
                $fabric['fabric_consumption'] = $data['fabric_consumption'][$key];
                $fabric['fabric_consump_unit'] = $data['fabric_consump_unit'][$key];
                $fabric['fabric_wastage'] = $data['fabric_wastage'][$key];
                $fabric['fabric_total_price'] = $price;
                $fabric['is_active'] = true;

                Fabric::create($fabric);
            }
        }

            //delete previous details
            $trim = CostSheetDetails::where('cost_sheet_id', $id)->delete();

        if ($request->trim_total_price != null) {
            $details = [];
            foreach($request->trim_total_price as $key=>$price){
                $details['cost_sheet_id'] = $cost_sheet->id;
                $details['trimming'] = $data['trimming'][$key];
                $details['trim_item_code'] = $data['trim_item_code'][$key];
                $details['trim_item_description'] = $data['trim_item_description'][$key];
                $details['trim_price'] = $data['trim_price'][$key];
                $details['trim_consumption'] = $data['trim_consumption'][$key];
                $details['trim_consump_unit'] = $data['trim_consump_unit'][$key];
                $details['trim_wastage'] = $data['trim_wastage'][$key];
                $details['trim_total_price'] = $price;
                $details['is_active'] = true;

                CostSheetDetails::create($details);
            }
        }
            DB::commit();
            $message = 'Cost sheet updated successfully';
        }catch(\Exception $e){
            DB::rollback();
            $message = 'something wrong !';
        }
        return redirect('cost_sheet')->with('message',$message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CostSheet::find($id)->delete();
        Fabric::where('cost_sheet_id', $id)->delete();
        CostSheetDetails::where('cost_sheet_id', $id)->delete();

        return redirect('cost_sheet')->with('message','Cost sheet deleted successfully');
    }

    public function printCostSheet($id){
        $lims_cost_data = CostSheet::find($id);
        $lims_fabrics_all = Fabric::where('cost_sheet_id',$id)->get();
        $lims_details_all = CostSheetDetails::where('cost_sheet_id',$id)->get();
        return view('cost_sheet.print',compact('lims_cost_data','lims_fabrics_all','lims_details_all'));
    }

    public function getFiltering(){

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('cost-sheet-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
                
        $lims_cost_all = CostSheet::where('is_active',true)->orderBy('id','DESC')->get();
        $lims_customer_all = Customer::where('is_active', true)->get();   
            
            return view('cost_sheet.list',compact('lims_cost_all','lims_customer_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function filtering(Request $request){
        if(($request->customer_id == null)){
                return redirect()->back()->with('not_permitted','Please select filtering criteria');
        }

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('cost-sheet-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
                
        $customerId = $request->customer_id;

        $lims_customer_all = Customer::where('is_active', true)->get();
        $lims_cost_all = CostSheet::where(function($query) use($customerId){
            if($customerId != null){
                 return $query->where('customer_id',$customerId);
            }
        })->where('is_active',true)->orderBy('id','DESC')->get();   
            
            return view('cost_sheet.list',compact('lims_cost_all','lims_customer_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }
    
    public function duplicateCost($id){

        $lims_cost_data = CostSheet::find($id);

        $data['user_id']          = $lims_cost_data->user_id;
        $data['customer_id']      = $lims_cost_data->customer_id;
        $data['style_no']         = $lims_cost_data->style_no;
        $data['season']           = $lims_cost_data->season;
        $data['brand']            = $lims_cost_data->brand;
        $data['size_scale']       = $lims_cost_data->size_scale;
        $data['item_description'] = $lims_cost_data->item_description;
        $data['order_quantity']   = $lims_cost_data->order_quantity;
        $data['target_price']     = $lims_cost_data->target_price;
        $data['fabric_total_cost'] = $lims_cost_data->fabric_total_cost;
        $data['trim_total_cost']  = $lims_cost_data->trim_total_cost;
        $data['making_price']     = $lims_cost_data->making_price;
        $data['washing_description'] = $lims_cost_data->washing_description;
        $data['washing_price']           = $lims_cost_data->washing_price;
        $data['other_price']             = $lims_cost_data->other_price;
        $data['dry_process_price']       = $lims_cost_data->dry_process_price;
        $data['dry_process_description'] = $lims_cost_data->dry_process_description;
        $data['cmptw_wastage']           = $lims_cost_data->cmptw_wastage;
        $data['cmptw_total_price']       = $lims_cost_data->cmptw_total_price;
        $data['fob_wastage']     = $lims_cost_data->fob_wastage;
        $data['fob_total_price'] = $lims_cost_data->fob_total_price;
        $data['tf_wastage']      = $lims_cost_data->tf_wastage;
        $data['tf_cost']         = $lims_cost_data->tf_cost;
        $data['cil_wastage']     = $lims_cost_data->cil_wastage;
        $data['cil_price']          = $lims_cost_data->cil_price;
        $data['total_cost_wastage'] = $lims_cost_data->total_cost_wastage;
        $data['total_cost']         = $lims_cost_data->total_cost;
        $data['wastage_per_pc']     = $lims_cost_data->wastage_per_pc;
        $data['cost_per_pc']        = $lims_cost_data->cost_per_pc;
        $data['offered_fob']        = $lims_cost_data->offered_fob;
        $data['is_active']          = true;


        DB::beginTransaction();

        try {
            $new_cost = CostSheet::create($data);
            $fabrics = Fabric::where('cost_sheet_id', $id)->get();
            $trims = CostSheetDetails::where('cost_sheet_id', $id)->get();

            foreach($fabrics as $key=>$item){
                $fabric['cost_sheet_id'] = $new_cost->id;
                $fabric['fabric'] = $item['fabric'];
                $fabric['fabric_item_code'] = $item['fabric_item_code'];
                $fabric['fabric_item_description'] = $item['fabric_item_description'];
                $fabric['fabric_price'] = $item['fabric_price'];
                $fabric['fabric_consumption'] = $item['fabric_consumption'];
                $fabric['fabric_consump_unit'] = $item['fabric_consump_unit'];
                $fabric['fabric_wastage'] = $item['fabric_wastage'];
                $fabric['fabric_total_price'] = $item['fabric_total_price'];
                $fabric['is_active'] = true;
                Fabric::create($fabric);
            }
            foreach($trims as $key=>$trim){
                $details['cost_sheet_id'] = $new_cost->id;
                $details['trimming'] = $trim['trimming'];
                $details['trim_item_code'] = $trim['trim_item_code'];
                $details['trim_item_description'] = $trim['trim_item_description'];
                $details['trim_price'] = $trim['trim_price'];
                $details['trim_consumption'] = $trim['trim_consumption'];
                $details['trim_consump_unit'] = $trim['trim_consump_unit'];
                $details['trim_wastage'] = $trim['trim_wastage'];
                $details['trim_total_price'] = $trim['trim_total_price'];
                $details['is_active'] = true;
                CostSheetDetails::create($details);
            }

            DB::commit();
            $message = "Data duplicated successfully";
        } catch (\Exception $e) {
            DB::rollback();
            $message = "Something went wrong";
        }
        return redirect()->back()->with('message',$message);

    }
}
