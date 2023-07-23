<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ServiceCategory;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use DNS2D;
use App\Tax;
use App\Service;
use App\Customer;
use App\Account;
use App\Biller;
use App\ServiceSale;
use App\ServiceSaleDetails;
use App\ServicePaymentWithCheque;
use App\ServicePayment;
use App\ServiceDelivery;
use Keygen;
use Auth;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('services-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission){
                $all_permission[] = $permission->name;
            }
            if(empty($all_permission)){
            $all_permission[] = 'dummy text';
        }
            $services = Service::where('is_active',true)->get();
            return view('service.index',compact('services','all_permission'));
        }else{
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lims_tax_list = Tax::where('is_active', true)->get();
        $service_categories = ServiceCategory::where('is_active',true)->get();
        return view('service.create',compact('lims_tax_list','service_categories'));
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
            'name' => 'required|string|max:200',
            'code' => 'required|string|unique:services|min:8',
            'category_id' => 'required|integer',
            'tax_id' => 'nullable|integer',
            'tax_method' => 'nullable|integer',
            'price' => 'required|integer|min:0',
            'details' => 'required|string|max:255'
        ],[
            'category_id.required' => 'Please select category',
            'tax_id.required' => 'Please select tax',
            'tax_method.required' => 'Please select tax method'
        ]);
        $data = $request->all();
        $data['is_active'] = true;
        Service::create($data);
        return redirect('services')->with('message','Service created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service_list = Service::findOrFail($id);
        $service[] = $service_list->name;
		$service[] = $service_list->code;
		$service[] = $service_list->category->name;
		$service[] = $service_list->tax->name;
        if($service_list->tax_method == 1){
            $service[] = 'Exclusive';
        }else{
            $service[] = 'Inclusive';
        }
		$service[] = $service_list->price;
		$service[] = $service_list->details;
        return $service;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service_list = Service::findOrFail($id);
        $lims_tax_list = Tax::where('is_active', true)->get();
        $service_categories = ServiceCategory::where('is_active',true)->get();
        return view('service.edit',compact('lims_tax_list','service_categories','service_list'));
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
            'name' => 'required|string|max:200',
            'code' => 'required|string|min:8',
            'category_id' => 'required|integer',
            'tax_id' => 'nullable|integer',
            'tax_method' => 'nullable|integer',
            'price' => 'required|integer|min:0',
            'details' => 'required|string|max:255'
        ],[
            'category_id.required' => 'Please select category',
            'tax_id.required' => 'Please select tax',
            'tax_method.required' => 'Please select tax method'
        ]);
        $data = $request->all();
        $data['is_active'] = true;
        $service = Service::findOrFail($id);
        $service->update($data);
        return redirect('services')->with('message','Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::find($id)->delete();
        return redirect()->back()->with('message','Service deleted successfully');
    }

    public function serviceSearch(Request $request){
        $service_code = explode(" ", $request['data']);
        $service_data = Service::where('code', $service_code[0])->first();
        $service[] = $service_data->name;
        $service[] = $service_data->code;
        $service[] = $service_data->price;
        $service[] = DNS2D::getBarcodePNG($service_data->code, 'QRCODE');
        return $service;
    }

    public function serviceSearchSale(Request $request){
        $service_code = explode(" ", $request['data']);

        $service_data = Service::where('code', $service_code[0])->first();
        $service[] = $service_data->name;
        $service[] = $service_data->code;
        $service[] = $service_data->price;

        if($service_data->tax_id) {
            $tax_data = Tax::find($service_data->tax_id);
            $service[] = $tax_data->rate;
            $service[] = $tax_data->name;
        }
        else{
            $service[] = 0;
            $service[] = 'No Tax';
        }
        $service[] = $service_data->tax_method;
        $service[] = $service_data->id;
        return $service;
    }

    public function generateCode(){
        $id = 'S-'.Keygen::numeric(8)->generate();
        return $id;
    }

    public function printQRcode(){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('print_qrcode')){
            $services = Service::where('is_active', true)->get();
            return view('service.print_qrcode',compact('services'));
        }else{
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }
    }

    public function serviceSaleList(){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('service-sales-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission){
                $all_permission[] = $permission->name;
            }
            if(empty($all_permission)){
            $all_permission[] = 'dummy text';
        }
            $all_service_sales = ServiceSale::latest()->get();
            $lims_account_list = Account::where('is_active', true)->get();
            return view('service.sale_list',compact('all_service_sales','all_permission','lims_account_list'));
        }else{
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
        }

    }

    public function serviceSaleCreate(){
        if(Auth::user()->role_id > 2) {
            $lims_biller_list = Biller::where([
                ['is_active', true],
                ['id', Auth::user()->biller_id]
            ])->get();
        }
        else {
            $lims_biller_list = Biller::where('is_active', true)->get();
        }

        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_customer_list = Customer::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        return view('service.service_sale',compact('lims_customer_list','lims_tax_list','lims_biller_list','services'));

    }

    public function serviceSaleStore(Request $request){
        //return $request->all();
        $this->validate($request,[
            'customer_id' =>'required|integer',
            'biller_id' =>'required|integer',
            'service_code.*' =>'required',
            'total_discount' => 'numeric',
            'total_tax' => 'numeric',
            'total_price' => 'numeric|required',
            'item' => 'integer|required',
            'order_tax' => 'numeric|nullable',
            'grand_total' => 'numeric|required',
            'order_tax_rate' => 'numeric',
            'order_discount' => 'numeric|nullable',
            'shipping_cost' => 'numeric|nullable',

            'sale_note'    =>'string|nullable|max:200',
            'staff_note'   =>'string|nullable|max:200',
            'payment_note' =>'string|nullable|max:200',
            'payment_status' => 'integer|required',
        ],[
            'service_code.required' => 'Please select service',
            'customer_id.required' => 'Please select Customer',
            'biller_id.required' => 'Please select biller',
            'payment_status.required' => 'Please select any payment method',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['reference_no'] = 'ss-' . date("Ymd") . '-'. date("his");
        if($data['payment_status'] == 1 || $data['payment_status'] == 2){
            $data['paid_amount'] = 0;
        }elseif($data['payment_status'] == 4){
            $data['paid_amount'] = $data['grand_total'];
        }

        $document = $request->document;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = $document->getClientOriginalName();
            $document->move('public/sale/documents', $documentName);
            $data['document'] = $documentName;
        }
            $sale_data = ServiceSale::create($data);

        $service_id = $data['service_id'];
        $service_code = $data['service_code'];
        $qty = $data['qty'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $service_sale = [];

        foreach($service_id as $i=>$id){
            $service_data = Service::find($id);
            $service_sale['sale_id'] = $sale_data->id;
            $service_sale['product_id'] = $id;
            $service_sale['qty'] =  $qty[$i];
            if($service_data->tax_method == 1){
                $extra = $tax[$i]+$discount[$i];
                $service_sale['unit_price'] = ($total[$i]-$extra);
            }elseif($service_data->tax_method == 2){
                $service_sale['unit_price'] = ($total[$i]-$discount[$i]);
            }
            $service_sale['discount'] = $discount[$i];
            $service_sale['tax_rate'] = $tax_rate[$i];
            $service_sale['tax'] = $tax[$i];
            $service_sale['total'] = ($total[$i]);

            ServiceSaleDetails::create($service_sale);
        }

        //Payment
         $payment_data = [];
         $account_data =  Account::where('is_default', true)->first();
         $payment_data['user_id'] = Auth::id();
         $payment_data['account_id'] = $account_data->id;
         $payment_data['payment_reference'] = 'ssp-'.date("Ymd").'-'.date("his");
         $payment_data['sale_id'] = $sale_data->id;
         $payment_data['payment_note'] = $data['payment_note'];

         $payment_data['amount'] = $data['paid_amount'];
         $payment_data['due'] = $data['grand_total'] - $data['paid_amount'];

        if($data['payment_status'] == 4 || $data['payment_status'] == 3){
            if($data['paid_by_id'] == 1){
                $paying_method = 'Cash';
            }else if($data['paid_by_id'] == 2){
                $paying_method = 'Chaque';
            }else{
                $paying_method = 'Deposit';
            }

            $payment_data['paying_method']=$paying_method;
            $service_payment = ServicePayment::create($payment_data);

            if($data['paid_by_id'] == 2){
                $chaque_data = [];
                $chaque_data['payment_id'] = $service_payment->id;
                $chaque_data['cheque_no'] = $data['cheque_no'];
                ServicePaymentWithCheque::create($chaque_data);
            }elseif($data['paid_by_id'] == 3){
                $lims_customer_data = Customer::find($data['customer_id']);
                $lims_customer_data->expense += $data['paid_amount'];
                $lims_customer_data->save();
            }
            $message = 'Sale created successfully with payment';
        }
        $message = 'Sale created successfully';

        return redirect()->route('service.sale.list')->with('message',$message);

    }
    public function saleEdit($id){
        if(Auth::user()->role_id > 2) {
            $lims_biller_list = Biller::where([
                ['is_active', true],
                ['id', Auth::user()->biller_id]
            ])->get();
        }
        else {
            $lims_biller_list = Biller::where('is_active', true)->get();
        }
        $lims_tax_list = Tax::where('is_active', true)->get();
        $lims_customer_list = Customer::where('is_active', true)->get();
        $lims_sale_data = ServiceSale::find($id);
        $lims_service_sale_data = ServiceSaleDetails::where('sale_id', $id)->get();
        $services = Service::where('is_active', true)->get();
        return view('service.service_sale_edit',compact('lims_customer_list','lims_biller_list','lims_sale_data','lims_tax_list','lims_service_sale_data','services'));
    }

    public function serviceSaleUpdate(Request $request, $id){
        $this->validate($request,[
            'customer_id' =>'required|integer',
            'biller_id' =>'required|integer',
            'service_code.*' =>'required',
            'total_discount' => 'numeric',
            'total_tax' => 'numeric',
            'total_price' => 'numeric|required',
            'item' => 'integer|required',
            'order_tax' => 'numeric|nullable',
            'grand_total' => 'numeric|required',
            'order_tax_rate' => 'numeric',
            'order_discount' => 'numeric|nullable',
            'shipping_cost' => 'numeric|nullable',

            'sale_note'    =>'string|nullable|max:200',
            'staff_note'   =>'string|nullable|max:200',
            'payment_note' =>'string|nullable|max:200',
            'payment_status' => 'integer|required',
        ],[
            'service_code.required' => 'Please select service',
            'customer_id.required' => 'Please select Customer',
            'biller_id.required' => 'Please select biller',
            'payment_status.required' => 'Please select any payment method',
        ]);

        $data = $request->except('document');
        $document = $request->document;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = $document->getClientOriginalName();
            $document->move('public/sale/documents', $documentName);
            $data['document'] = $documentName;
        }

        $balance = $data['grand_total'] - $data['paid_amount'];
        if($balance < 0 || $balance > 0){
            $data['payment_status'] = 2;
        }
        else{
            $data['payment_status'] = 4;
        }

        $lims_sale_data = ServiceSale::find($id);
        $lims_sale_data->update($data);
        $lims_sale_details_data = ServiceSaleDetails::where('sale_id',$id)->get();
        foreach($lims_sale_details_data as $key => $sale_details_data){
            if(!(in_array($sale_details_data->product_id,$data['service_id']))){
                ServiceSaleDetails::where([
                  ['sale_id',$id],
                  ['product_id',$sale_details_data->product_id]
                ])->delete();
            }
        }

        $service_id = $data['service_id'];
        $service_code = $data['service_code'];
        $qty = $data['qty'];
        $discount = $data['discount'];
        $tax_rate = $data['tax_rate'];
        $tax = $data['tax'];
        $total = $data['subtotal'];
        $old_service_id = [];
        $service_sale = [];

        foreach($lims_sale_details_data as $key => $sale_details_data){
            $old_service_id[] = $sale_details_data->product_id;
        }

        foreach($service_id as $i=>$pro_id){
            $service_data = Service::find($pro_id);
            $service_sale['sale_id'] = $id;
            $service_sale['product_id'] = $pro_id;
            $service_sale['qty'] =  $qty[$i];
            if($service_data->tax_method == 1){
                $extra = $tax[$i]+$discount[$i];
                $service_sale['unit_price'] = ($total[$i]-$extra);
            }elseif($service_data->tax_method == 2){
                $service_sale['unit_price'] = ($total[$i]-$discount[$i]);
            }
            $service_sale['discount'] = $discount[$i];
            $service_sale['tax_rate'] = $tax_rate[$i];
            $service_sale['tax'] = $tax[$i];
            $service_sale['total'] = ($total[$i]);

            if(in_array($pro_id,$old_service_id)){
                ServiceSaleDetails::where([
                    ['sale_id',$id],
                    ['product_id',$pro_id]
                    ])->update($service_sale);
            }else{
                ServiceSaleDetails::create($service_sale);
            }
        }
        $message = 'Service sale updated successfully';
        return redirect()->route('service.sale.list')->with('message',$message);

    }

    public function saleView($id){

       $sale = ServiceSale::find($id);
       $sale_details_list = ServiceSaleDetails::where('sale_id',$id)->get();

        $product = [];
        $qty = [];
        $unit_price = [];
        $tax = [];
        $discount = [];
        $sub_total = [];
        $tax_rate = [];

        $order_tax = $sale->order_tax;
        $order_tax_rate = $sale->order_tax_rate;
        $order_discount = $sale->order_discount;
        if($order_discount == null){
            $order_discount = 0;
        }
        $shippint_cost = $sale->shipping_cost;
        if($shippint_cost == null){
            $shippint_cost = 0;
        }
        $grand_total = $sale->grand_total;
        $paid_amount = $sale->paid_amount;
        if($paid_amount == null){
            $paid_amount = 0;
        }
        $total_price = $sale->total_price;
        $total_tax = $sale->total_tax;
        $total_discount  = $sale->total_discount;
        $reference = $sale->reference_no;
        $date = $sale->created_at->format('d F Y');
        $sale_status = $sale->sale_status;
        if($sale_status == 1){
            $sale_status = 'Completed';
        }else{
            $sale_status = 'Incomplete';
        }

        $biller_name =  $sale->biller->name;
        $biller_company_name =  $sale->biller->company_name;
        $biller_email =  $sale->biller->email;
        $biller_phone =  $sale->biller->phone_number;
        $biller_address =  $sale->biller->address;
        $biller_city =  $sale->biller->city;

        $customer_name =  $sale->customer->name;
        $customer_phone =  $sale->customer->phone_number;
        $customer_address =  $sale->customer->address;
        $customer_city =  $sale->customer->city;

        $sale_note = $sale->sale_note;
        if($sale_note == null){
            $sale_note = 'N/A';
        }
        $staff_note = $sale->staff_note;
        if($staff_note == null){
            $staff_note = 'N/A';
        }
        $user_name = $sale->user->name;
        $user_email = $sale->user->email;
        $sale_id = $sale->id;


        foreach($sale_details_list as $sale_details){
            $product[] = $sale_details->product->name;
            $qty[] = $sale_details->qty;
            $unit_price[] = $sale_details->unit_price;
            $discount[] = $sale_details->discount;
            $tax[] = $sale_details->tax;
            $tax_rate[] = $sale_details->tax_rate;
            $sub_total[] = $sale_details->total;
        }

        $details[] = $product;
        $details[] = $qty;
        $details[] = $unit_price;
        $details[] = $discount;
        $details[] = $tax;
        $details[] = $tax_rate;
        $details[] = $sub_total;
        $details[] = $order_tax;

        $details[] = $order_tax_rate;
        $details[] = $order_discount;
        $details[] = $shippint_cost;
        $details[] = $grand_total;
        $details[] = $paid_amount;
        $details[] = $total_price;
        $details[] = $total_tax;
        $details[] = $total_discount;
        $details[] = $reference;
        $details[] = $date;
        $details[] = $sale_status;

        $details[] = $biller_name;
        $details[] = $biller_company_name;
        $details[] = $biller_email;
        $details[] = $biller_phone;
        $details[] = $biller_address;
        $details[] = $biller_city;

        $details[] = $customer_name;
        $details[] = $customer_phone;
        $details[] = $customer_address;
        $details[] = $customer_city;

        $details[] = $sale_note;
        $details[] = $staff_note;
        $details[] = $user_name;
        $details[] = $user_email;
        $details[] = $sale_id;
        return $details;

    }

    public function getSaleData($id){
       $saleData = ServiceSale::with('customer')->where('id',$id)->first();
       return $saleData;
    }

    public function duePayment(Request $request){
        $this->validate($request,[
            'amount' => 'required|integer|min:0',
            'paid_by_id' => 'required|integer',
            'payment_note' => 'nullable|string|max:200',
        ],[
            'paid_by_id.required' => 'Please select mayment method'
        ]);
        if($request->paid_by_id == 2){
            $this->validate($request,[
                'cheque_no' => 'required'
            ]);
        }
        $data = $request->all();

        //Update Service sale table
        $serviceSale = ServiceSale::find($request->sale_id);
        $serviceSale->paid_amount += $data['amount'];
        $balance = $serviceSale->grand_total - $serviceSale->paid_amount;

        if($balance > 0 || $balance < 0)
            $serviceSale->payment_status = 2;
        elseif ($balance == 0)
            $serviceSale->payment_status = 4;
        $serviceSale->save();

        //Update customer expense for calculate deposit
        if($request->paid_by_id == 3){
            $lims_customer_data = Customer::find($serviceSale->customer->id);
            $lims_customer_data->expense += $data['amount'];
            $lims_customer_data->save();
        }

        //add payment
        $data['user_id'] = Auth::id();
        $data['payment_reference'] = 'ss-' . date("Ymd") . '-'. date("his");
        $data['due'] = $data['balance'] - $data['amount'];
        if($data['paid_by_id'] == 1){
            $data['paying_method'] = 'Cash';
        }else if($data['paid_by_id'] == 2){
            $data['paying_method'] = 'Chaque';
        }else if($data['paid_by_id'] == 3){
            $data['paying_method'] = 'Deposit';
        }
        $servicePayment = ServicePayment::create($data);

        if($data['paid_by_id'] == 2){

            $chaque_data = [];
            $chaque_data['payment_id'] = $servicePayment->id;
            $chaque_data['cheque_no'] = $data['cheque_no'];
            ServicePaymentWithCheque::create($chaque_data);
        }
        $message = 'Payment added successfully';
        return redirect()->back()->with('message',$message);

    }

    public function getPayment($id){
        $payment_list = ServicePayment::where('sale_id', $id)->get();
        $date = [];
        $payment_reference = [];
        $paid_amount = [];
        $paying_method = [];
        $payment_id = [];
        $payment_note = [];
        $cheque_no = [];
        $change = [];
        $paying_amount = [];

        foreach ($payment_list as $payment) {
            $date[] = date(config('date_format'), strtotime($payment->created_at->toDateString())) . ' '. $payment->created_at->toTimeString();
            $payment_reference[] = $payment->payment_reference;
            $paid_amount[] = $payment->amount;
            $change[] = $payment->change;
            $paying_method[] = $payment->paying_method;
            $paying_amount[] = $payment->amount + $payment->change;

            if($payment->paying_method == 'Chaque'){
                $payment_cheque_data = ServicePaymentWithCheque::where('payment_id',$payment->id)->first();
                $cheque_no[] = $payment_cheque_data->cheque_no;
            }
            else{
                $cheque_no[] =  '';
            }
            $payment_id[] = $payment->id;
            $payment_note[] = $payment->payment_note;
        }
        $payments[] = $date;
        $payments[] = $payment_reference;
        $payments[] = $paid_amount;
        $payments[] = $paying_method;
        $payments[] = $payment_id;
        $payments[] = $payment_note;
        $payments[] = $cheque_no;
        $payments[] = $change;
        $payments[] = $paying_amount;

        return $payments;
    }

    public function servicePaymentDelete(Request $request){
        $payment = ServicePayment::findOrFail($request->id)->delete();
        $payment_chaque = ServicePaymentWithCheque::where('payment_id',$request->id)->first();
        if(!empty($payment_chaque)){
            $paymentCheque = ServicePaymentWithCheque::fint($payment_chaque->id)->delete();
        }
        $message = 'Payment deleted successfully';
        return redirect()->back()->with('message',$message);
    }

    public function serviceDelivary($id){
        $customer_sale = ServiceSale::findOrFail($id);

        $delivery_data[] = 'sd-' . date("Ymd") . '-'. date("his");
        $delivery_data[] = $customer_sale->reference_no;
        $delivery_data[] = '';
        $delivery_data[] = '';
        $delivery_data[] = '';
        $delivery_data[] = $customer_sale->customer->name;
        $delivery_data[] = $customer_sale->customer->address.' '.$customer_sale->customer->city.' '.$customer_sale->customer->country;
        $delivery_data[] = '';

        return $delivery_data;
    }

    public function deliveryStore(Request $request){
         $this->validate($request,[
            'recieved_by' => 'string|required|max:100',
            'delivered_by' => 'string|required|max:100',
            'address' => 'string|required|max:200',
            'note' => 'string|nullable|max:200',
            'status' => 'integer|required'
         ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $document = $request->file;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails()){
                return redirect()->back()->withErrors($v->errors());
            }
            $ext = pathinfo($document->getClientOriginalName(), PATHINFO_EXTENSION);
            $documentName = $data['reference'] . '.' . $ext;
            $document->move('public/documents/delivery', $documentName);
            $data['file'] = $documentName;
        }
           ServiceDelivery::create($data);
          $message = 'Service delivary create successfully';

          return redirect()->back()->with('message',$message);
    }

    public function genInvoice($id){

        $lims_sale_data = ServiceSale::find($id);
        $lims_service_sale_data = ServiceSaleDetails::where('sale_id', $id)->get();
        $lims_biller_data = Biller::find($lims_sale_data->biller_id);
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);
        $lims_payment_data = ServicePayment::where('sale_id', $id)->get();

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer(\App::getLocale());
        $numberInWords = $numberTransformer->toWords($lims_sale_data->grand_total);

        return view('service.invoice',compact('lims_sale_data','lims_service_sale_data','lims_biller_data','lims_customer_data','lims_payment_data','numberInWords'));
    }

    public function deleteBySelection(Request $request){
        $service_id = $request['serviceIdArray'];
        foreach($service_id as $id){
            $service = Service::findOrFail($id);
            $service->is_active = false;
            $service->save();
        }
        return 'Service deleted successfully!';
    }

    public function sendMmail(Request $request){
        $data = $request->all();
        $lims_sale_data = ServiceSale::find($data['sale_id']);
        $lims_product_sale_data = ServiceSaleDetails::where('sale_id', $data['sale_id'])->get();
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);

        if($lims_customer_data->email) {
            //collecting male data
            $mail_data['email'] = $lims_customer_data->email;
            $mail_data['reference_no'] = $lims_sale_data->reference_no;
            $mail_data['sale_status'] = $lims_sale_data->sale_status;
            $mail_data['payment_status'] = $lims_sale_data->payment_status;
            $mail_data['total_qty'] = $lims_sale_data->total_qty;
            $mail_data['total_price'] = $lims_sale_data->total_price;
            $mail_data['order_tax'] = $lims_sale_data->order_tax;
            $mail_data['order_tax_rate'] = $lims_sale_data->order_tax_rate;
            $mail_data['order_discount'] = $lims_sale_data->order_discount;
            $mail_data['shipping_cost'] = $lims_sale_data->shipping_cost;
            $mail_data['grand_total'] = $lims_sale_data->grand_total;
            $mail_data['paid_amount'] = $lims_sale_data->paid_amount;
            //dd($mail_data);

            foreach ($lims_product_sale_data as $key => $product_sale_data) {
                $lims_product_data = Service::find($product_sale_data->product_id);
                //dd($product_sale_data);
                    $mail_data['products'][$key] = $lims_product_data->name;
                    $mail_data['qty'][$key] = $product_sale_data->qty;
                    $mail_data['unit_price'][$key] = $product_sale_data->unit_price;
                    $mail_data['discount'][$key] = $product_sale_data->discount;
                    $mail_data['tax'][$key] = $product_sale_data->tax;
                    $mail_data['total'][$key] = $product_sale_data->qty;
            }

            try{
                Mail::send( 'mail.service_sale_details', $mail_data, function( $message ) use ($mail_data)
                {
                    $message->to( $mail_data['email'] )->subject( 'Sale Details' );
                });
                $message = 'Mail sent successfully';
            }
            catch(\Exception $e){
                $message = 'Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }
        else
            $message = 'Customer doesnt have email!';

        return redirect()->back()->with('message', $message);
    }


}
