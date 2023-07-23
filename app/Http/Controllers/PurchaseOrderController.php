<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;
use App\Vendor;
use App\ShipTo;
use App\InvoiceTo;
use App\PurchaseOrder;
use App\QuotationBreakdown;
use App\Customer;
use Auth;
use DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('po-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_order_all = PurchaseOrder::where('is_active',true)->orderBy('id','DESC')->get();
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_ship_to_all = ShipTo::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active',true)->get();

            return view('purchase.order_list',compact('lims_order_all','lims_vendor_all','lims_ship_to_all','lims_invoice_to_all','lims_customer_all','all_permission'));
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
        $lims_ship_to_all = ShipTo::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active',true)->get();
        return view('purchase.order',compact('lims_vendor_all','lims_ship_to_all','lims_invoice_to_all','lims_customer_all'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //dd($request->all());
        $this->validate($request, [
            'po_number'=>'required|string|max:20',
            'rivision_no'=>'nullable',
            'order_date'=>'required',
            'vendor'=>'required|integer',
            'invoice_to'=>'required|integer',
            'ship_to'=>'required|integer',
            'ship_via'=>'string|max:100',
            'season'=>'required|string',
            'ship_exp_date'=>'required|date',
            'ship_terms'=>'string|max:200',
            'payment_terms'=>'string|max:200',
            'febric_ref'=>'string|max:200',
            'brand'=>'string|max:100',
            'style_no'=>'string|required|max:20',
            'ca'=>'string|max:20',
            'total_quantity'=>'required|integer',
            'total_amount'=>'required|numeric',
            'fabrication'=>'string|max:255',
            'description'=>'string|max:255',
            'packing_instruction'=>'string|max:500',
            'instruction_notes'=>'string|max:1000',
        ]);
        DB::beginTransaction();
        // try {

            $data = $request->all();
            $data['rivision_no'] = date("Y-m-d", strtotime($request->rivision_no));
            $data['ship_exp_date'] = date("Y-m-d", strtotime($request->ship_exp_date));
            $data['order_date'] = date("Y-m-d", strtotime($request->order_date));

            $data['user_id'] = Auth::id();
            $data['is_active'] = true;

            $order = PurchaseOrder::create($data);

            $breakdown = [];
            $x=0;
            foreach($request->color as $key=>$color){
                $x++;
                $breakdown['purchase_id'] = $order->id;
                $breakdown['color'] = $color;
                $breakdown['color_code'] = $data['color_code'][$key];
                $breakdown['color_wise_quantity'] = $data['color_wise_quantity'][$key];
                $breakdown['color_unit_price'] = $data['color_unit_price'][$key];
                $breakdown['sub_total'] = $data['sub_total'][$key];

                for ($i = 1; $i<14; $i++){
                    $breakdown['size'.$i] = isset($data['color_'.$x.'_size'.$i]) ? $data['color_'.$x.'_size'.$i] : null;
                    $breakdown['prepack'.$i] = isset($data['color_'.$x.'_prepack'.$i]) ? $data['color_'.$x.'_prepack'.$i] : null;
                    $breakdown['quantity'.$i] = isset($data['color_'.$x.'_quantity'.$i]) ? $data['color_'.$x.'_quantity'.$i] : 0;

                }

                $breakdown['is_active'] = true;

                QuotationBreakdown::create($breakdown);
            }
            DB::commit();
            $message = 'Purchase order created successfully';
        // }
        // catch(\Exception $e){
        //     DB::rollback();
        //     $message = $e->getMessage();
        // }

        return redirect('purchase_order')->with('message', $message);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = PurchaseOrder::find($id);
        $sizeCount = 0;
        $lim_sizes = QuotationBreakdown::select('size1','size2','size3','size4','size5','size6','size7','size8','size9','size10','size11','size12','size13')
                    ->where('purchase_id',$id)->first();
        // dd(sizeof($lim_sizes->toArray()));
        foreach($lim_sizes->toArray() as $lim_size){
            if($lim_size){
                $sizeCount++;
            }
        }
        $lim_details = QuotationBreakdown::where('purchase_id',$id)->get();
        // dd($sizeCount);
        return view('purchase.order_view',compact('order','lim_details','lim_sizes', 'sizeCount'));
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
        $lims_ship_to_all = ShipTo::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active',true)->get();
        $lim_order_data = PurchaseOrder::find($id);
        $lim_details = QuotationBreakdown::where('purchase_id',$id)->get();

        $sizeCount = 13;
        $lim_sizes = QuotationBreakdown::select('size1','size2','size3','size4','size5','size6','size7','size8','size9','size10','size11','size12','size13')
                    ->where('purchase_id',$id)->first();

        // foreach($lim_sizes->toArray() as $lim_size){
        //     if($lim_size){
        //         $sizeCount++;
        //     }
        // }
        return view('purchase.order_edit',compact('lims_vendor_all','lims_ship_to_all','lims_invoice_to_all','lim_order_data','lim_details','lims_customer_all', 'sizeCount'));
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
        //return $request->all();
        $this->validate($request, [
            'po_number'=>'required|string|max:20',
            'rivision_no'=>'nullable',
            'order_date'=>'required',
            'vendor'=>'required|integer',
            'invoice_to'=>'required|integer',
            'ship_to'=>'required|integer',
            'ship_via'=>'string|max:100',
            'season'=>'required|string',
            'ship_exp_date'=>'required',
            'ship_terms'=>'string|max:200',
            'payment_terms'=>'string|max:200',
            'febric_ref'=>'string|max:200',
            'brand'=>'string|max:100',
            'style_no'=>'string|max:20',
            'ca'=>'string|max:20',
            'total_quantity'=>'required|integer',
            'total_amount'=>'required|numeric',
            'fabrication'=>'string|max:255',
            'description'=>'string|max:255',
            'packing_instruction'=>'string|max:500',
            'instruction_notes'=>'string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();

            $data['rivision_no'] = date("Y-m-d", strtotime($request->rivision_no));
            $data['ship_exp_date'] = date("Y-m-d", strtotime($request->ship_exp_date));
            $data['order_date'] = date("Y-m-d", strtotime($request->order_date));

            $lim_order_data = PurchaseOrder::find($id);
            $lim_order_data->update($data);

            $lim_order_details = QuotationBreakdown::where('purchase_id',$id)->get();
            foreach($lim_order_details as $detail){
                $old_color[] = $detail->color;
                if (!(in_array($detail->color,$data['color']))) {
                    QuotationBreakdown::where([
                        ['purchase_id',$id],
                        ['color',$detail->color]
                    ])->delete();
                }
            }
            $x=0;
            $breakdown = [];
            foreach($request->color as $key=>$color){
                $x++;
                $breakdown['purchase_id'] = $id;
                $breakdown['color'] = $color;
                $breakdown['color_code'] = $data['color_code'][$key];
                $breakdown['color_wise_quantity'] = $data['color_wise_quantity'][$key];
                $breakdown['color_unit_price'] = $data['color_unit_price'][$key];
                $breakdown['sub_total'] = $data['sub_total'][$key];

                for ($i = 1; $i<14; $i++){
                    $breakdown['size'.$i] = isset($data['color_'.$x.'_size'.$i]) ? $data['color_'.$x.'_size'.$i] : null;
                    $breakdown['prepack'.$i] = isset($data['color_'.$x.'_prepack'.$i]) ? $data['color_'.$x.'_prepack'.$i] : null;
                    $breakdown['quantity'.$i] = isset($data['color_'.$x.'_quantity'.$i]) ? $data['color_'.$x.'_quantity'.$i] : 0;

                }

                // $breakdown['size1'] = $data['size1'][$key];
                // $breakdown['size2'] = $data['size2'][$key];
                // $breakdown['size3'] = $data['size3'][$key];
                // $breakdown['size4'] = $data['size4'][$key];
                // $breakdown['size5'] = $data['size5'][$key];
                // $breakdown['size6'] = $data['size6'][$key];
                // $breakdown['size7'] = $data['size7'][$key];
                // $breakdown['size8'] = $data['size8'][$key];
                // $breakdown['size9'] = $data['size9'][$key];
                // $breakdown['size10'] = $data['size10'][$key];
                // $breakdown['size11'] = $data['size11'][$key];
                // $breakdown['size12'] = $data['size12'][$key];
                // $breakdown['size13'] = $data['size13'][$key];
                // $breakdown['prepack1'] = $data['prepack1'][$key];
                // $breakdown['prepack2'] = $data['prepack2'][$key];
                // $breakdown['prepack3'] = $data['prepack3'][$key];
                // $breakdown['prepack4'] = $data['prepack4'][$key];
                // $breakdown['prepack5'] = $data['prepack5'][$key];
                // $breakdown['prepack6'] = $data['prepack6'][$key];
                // $breakdown['prepack7'] = $data['prepack7'][$key];
                // $breakdown['prepack8'] = $data['prepack8'][$key];
                // $breakdown['prepack9'] = $data['prepack9'][$key];
                // $breakdown['prepack10'] = $data['prepack10'][$key];
                // $breakdown['prepack11'] = $data['prepack11'][$key];
                // $breakdown['prepack12'] = $data['prepack12'][$key];
                // $breakdown['prepack13'] = $data['prepack13'][$key];
                // $breakdown['quantity1'] = $data['quantity1'][$key];
                // $breakdown['quantity2'] = $data['quantity2'][$key];
                // $breakdown['quantity3'] = $data['quantity3'][$key];
                // $breakdown['quantity4'] = $data['quantity4'][$key];
                // $breakdown['quantity5'] = $data['quantity5'][$key];
                // $breakdown['quantity6'] = $data['quantity6'][$key];
                // $breakdown['quantity7'] = $data['quantity7'][$key];
                // $breakdown['quantity8'] = $data['quantity8'][$key];
                // $breakdown['quantity9'] = $data['quantity9'][$key];
                // $breakdown['quantity10'] = $data['quantity10'][$key];
                // $breakdown['quantity11'] = $data['quantity11'][$key];
                // $breakdown['quantity12'] = $data['quantity12'][$key];
                // $breakdown['quantity13'] = $data['quantity13'][$key];
                $breakdown['is_active'] = true;

                if(in_array($color,$old_color)){
                    QuotationBreakdown::where([
                        ['purchase_id',$id],
                        ['color',$color]
                    ])->update($breakdown);
                }else{
                    QuotationBreakdown::create($breakdown);
                }
            }
            DB::commit();
            $message = 'Purchase order updated successfully';
        }
        catch(\Exception $e){
            DB::rollback();
            $message = $e->getMessage();
        }
        return redirect('purchase_order')->with('message', $message);
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
            $order = PurchaseOrder::find($id);
            $order->delete();
            $breakdowns = QuotationBreakdown::where('purchase_id',$id)->delete();

        }catch(\Exception $e){
            $message = 'Something error found';
        }
        return redirect()->back()->with('message','Purchase order deleted  successfully');
    }

    public function printOrder($id){

        $order = PurchaseOrder::find($id);
        $sizeCount = 0;
        $lim_sizes = QuotationBreakdown::select('size1','size2','size3','size4','size5','size6','size7','size8','size9','size10','size11','size12','size13')
            ->where('purchase_id',$id)->first();
        // dd(sizeof($lim_sizes->toArray()));
        foreach($lim_sizes->toArray() as $lim_size){
            if($lim_size){
                $sizeCount++;
            }
        }
        $lim_details = QuotationBreakdown::where('purchase_id',$id)->get();
        // dd($sizeCount);
        return view('purchase.order_print',compact('order','lim_details','lim_sizes', 'sizeCount'));

        //$order = PurchaseOrder::find($id);
        //$lim_sizes = QuotationBreakdown::select('size1','size2','size1','size3','size4','size5','size6','size7','size8','size9','size10','size11','size12','size13')
                   // ->where('purchase_id',$id)->first();
        //$lim_details = QuotationBreakdown::where('purchase_id',$id)->get();
       // return view('purchase.order_print',compact('order','lim_details','lim_sizes'));
    }

    public function getFiltering(){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('po-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $lims_order_all = PurchaseOrder::where('is_active',true)->orderBy('id','DESC')->get();
        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_ship_to_all = ShipTo::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active',true)->get();

            return view('purchase.order_list',compact('lims_order_all','lims_vendor_all','lims_ship_to_all','lims_invoice_to_all','lims_customer_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function filtering(Request $request){
        if(($request->vendor_id == null) && ($request->customer_id == null) && ($request->ship_to_id == null)){
            return redirect()->back()->with('not_permitted','Please select filtering criteria');
        }

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('po-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

        $vendorId = $request->vendor_id;
        $customerId = $request->customer_id;
        $shipId = $request->ship_to_id;

        $lims_vendor_all = Vendor::where('is_active',true)->get();
        $lims_ship_to_all = ShipTo::where('is_active',true)->get();
        $lims_invoice_to_all = InvoiceTo::where('is_active',true)->get();
        $lims_customer_all = Customer::where('is_active',true)->get();

        $lims_order_all = PurchaseOrder::where(function($query) use($vendorId, $customerId, $shipId){
                        if($vendorId != null && $customerId != null && $shipId != null){
                            return $query->where('vendor',$vendorId)
                                         ->where('ship_to',$shipId)
                                         ->where('customer_id',$customerId);
                        }elseif($vendorId != null && $customerId != null){
                            return $query->where('vendor',$vendorId)
                                        ->where('customer_id',$customerId);
                        }elseif($vendorId != null && $shipId != null){
                            return $query->where('vendor',$vendorId)
                                        ->where('ship_to',$shipId);
                        }elseif($customerId != null && $shipId != null){
                            return $query->where('ship_to',$shipId)
                                        ->where('customer_id',$customerId);
                        }elseif($vendorId != null){
                            return $query->where('vendor',$vendorId);
                        }elseif($customerId != null){
                            return $query->where('customer_id',$customerId);
                        }elseif($shipId != null){
                            return $query->where('ship_to',$shipId);
                        }
                    })->where('is_active', true)->orderBy('id','DESC')->get();

            return view('purchase.order_list',compact('lims_order_all','lims_vendor_all','lims_ship_to_all','lims_invoice_to_all','vendorId','shipId','customerId','lims_customer_all','all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    public function duplicateOrder($id){
         $lim_order_data = PurchaseOrder::find($id);

         $data['po_number']     = $lim_order_data->po_number;
         $data['customer_id']   = $lim_order_data->customer_id;
         $data['user_id']       = $lim_order_data->user_id;
         $data['rivision_no']   = $lim_order_data->rivision_no;
         $data['order_date']    = $lim_order_data->order_date;
         $data['vendor']        = $lim_order_data->vendor;
         $data['invoice_to']    = $lim_order_data->invoice_to;
         $data['ship_to']       = $lim_order_data->ship_to;
         $data['ship_via']      = $lim_order_data->ship_via;
         $data['season']        = $lim_order_data->season;
         $data['ship_exp_date'] = $lim_order_data->ship_exp_date;
         $data['ship_terms']    = $lim_order_data->ship_terms;
         $data['payment_terms'] = $lim_order_data->payment_terms;
         $data['febric_ref']    = $lim_order_data->febric_ref;
         $data['brand']         = $lim_order_data->brand;
         $data['style_no']      = $lim_order_data->style_no;
         $data['ca']            = $lim_order_data->ca;
         $data['total_quantity'] = $lim_order_data->total_quantity;
         $data['total_amount'] = $lim_order_data->total_amount;
         $data['fabrication'] = $lim_order_data->fabrication;
         $data['description'] = $lim_order_data->description;
         $data['packing_instruction'] = $lim_order_data->packing_instruction;
         $data['instruction_notes'] = $lim_order_data->instruction_notes;
         $data['is_active'] = $lim_order_data->is_active;


         DB::beginTransaction();

        try {
            $new_order = PurchaseOrder::create($data);
            $lim_breakdowns = QuotationBreakdown::where('purchase_id',$id)->get();

         foreach($lim_breakdowns as $key=>$item){
                $breakdown['purchase_id'] = $new_order->id;
                $breakdown['color'] = $item['color'];
                $breakdown['color_code'] = $item['color_code'];
                $breakdown['color_wise_quantity'] = $item['color_wise_quantity'];
                $breakdown['color_unit_price'] = $item['color_unit_price'];
                $breakdown['sub_total'] = $item['sub_total'];
                $breakdown['size1'] = $item['size1'];
                $breakdown['size2'] = $item['size2'];
                $breakdown['size3'] = $item['size3'];
                $breakdown['size4'] = $item['size4'];
                $breakdown['size5'] = $item['size5'];
                $breakdown['size6'] = $item['size6'];
                $breakdown['size7'] = $item['size7'];
                $breakdown['size8'] = $item['size8'];
                $breakdown['size9'] = $item['size9'];
                $breakdown['size10'] = $item['size10'];
                $breakdown['size11'] = $item['size11'];
                $breakdown['size12'] = $item['size12'];
                $breakdown['size13'] = $item['size13'];
                $breakdown['prepack1'] = $item['prepack1'];
                $breakdown['prepack2'] = $item['prepack2'];
                $breakdown['prepack3'] = $item['prepack3'];
                $breakdown['prepack4'] = $item['prepack4'];
                $breakdown['prepack5'] = $item['prepack5'];
                $breakdown['prepack6'] = $item['prepack6'];
                $breakdown['prepack7'] = $item['prepack7'];
                $breakdown['prepack8'] = $item['prepack8'];
                $breakdown['prepack9'] = $item['prepack9'];
                $breakdown['prepack10'] = $item['prepack10'];
                $breakdown['prepack11'] = $item['prepack11'];
                $breakdown['prepack12'] = $item['prepack12'];
                $breakdown['prepack13'] = $item['prepack13'];
                $breakdown['quantity1'] = $item['quantity1'];
                $breakdown['quantity2'] = $item['quantity2'];
                $breakdown['quantity3'] = $item['quantity3'];
                $breakdown['quantity4'] = $item['quantity4'];
                $breakdown['quantity5'] = $item['quantity5'];
                $breakdown['quantity6'] = $item['quantity6'];
                $breakdown['quantity7'] = $item['quantity7'];
                $breakdown['quantity8'] = $item['quantity8'];
                $breakdown['quantity9'] = $item['quantity9'];
                $breakdown['quantity10'] = $item['quantity10'];
                $breakdown['quantity11'] = $item['quantity11'];
                $breakdown['quantity12'] = $item['quantity12'];
                $breakdown['quantity13'] = $item['quantity13'];
                $breakdown['is_active'] = true;
            QuotationBreakdown::create($breakdown);
         }
            DB::commit();
            $message = 'Purchase order duplicated successfully';

        } catch (\Exception $e) {
            DB::rollback();
            $message = 'Something error found';
        }

         return redirect()->back()->with('message',$message);
    }
}
