<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ServiceDelivery;

class ServiceDelivaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_delivery_list = ServiceDelivery::get();
        return view('service_delivery.index',compact('service_delivery_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $delivery_data = ServiceDelivery::findOrFail($id);

        $delivery[] = $delivery_data->reference;
		$delivery[] = $delivery_data->sale->reference_no;
		$delivery[] = $delivery_data->status;
		$delivery[] = $delivery_data->delivered_by;
		$delivery[] = $delivery_data->recieved_by;
		$delivery[] = $delivery_data->sale->customer->name;
		$delivery[] = $delivery_data->address;
		$delivery[] = $delivery_data->note;
    	return $delivery;
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delivery_data = ServiceDelivery::findOrFail($id);
        $delivery_data->delete();
        return redirect()->back()->with('message','Service delivery deleted successfully');
    }

    public function updateDelivery(Request $request){
        $this->validate($request,[
            'recieved_by' => 'string|required|max:100',
            'delivered_by' => 'string|required|max:100',
            'address' => 'string|required|max:200',
            'note' => 'string|nullable|max:200',
            'status' => 'integer|required'
         ]);
        $data = $request->all();
        $delivery_data = ServiceDelivery::find($data['delivery_id']);
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
        $delivery_data->update($data);
        $message = "Service delivery updated successfully";
        return redirect()->back()->with('message',$message);
    }
}
