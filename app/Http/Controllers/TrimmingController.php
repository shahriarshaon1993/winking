<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trimming;

class TrimmingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lim_treams = Trimming::where('is_active',true)->get();
        return view('trimming.index',compact('lim_treams'));
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
        $this->validate($request,[
            'trimming' => 'required|string|max:100',
            'code' => 'string|max:20|nullable',
            'description' => 'string|max:200|nullable',
        ]);
        $data = $request->all();
        $data['is_active']=true;

        Trimming::create($data);
        return redirect('treams')->with('message','Data inserted successfully');
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
        $lim_trimming_data = Trimming::find($id);
        return $lim_trimming_data;
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
            'trimming' => 'required|string|max:100',
            'code' => 'string|max:20',
            'description' => 'string|max:200',
        ]);
        $data = $request->all();

        $lim_trimming_data = Trimming::find($data['tream_id']);
        $lim_trimming_data->update($data);
        return redirect('treams')->with('message','Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lim_trimming_data = Trimming::find($id)->delete();
        return redirect()->back()->with('message','Data deleted successfully');
    }
}
