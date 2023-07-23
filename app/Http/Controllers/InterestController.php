<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interest;
use Complex\Exception;
use Spatie\Permission\Models\Role;
use Auth;

class InterestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('interest')) {
            $lims_interest_all = Interest::where('is_active',true)->get();
            return view('interest.create',compact('lims_interest_all'));
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
        $this->validate($request, [
            'topic' => 'string | required',
            'details' => 'string | nullable',
        ]);
        $data = $request->all();
        $data['is_active'] = true;
        try{
            Interest::create($data);
        }catch(\Exception $e){
            return redirect('interest')->with('not_permitted', 'Something error found');
        }
        return redirect('interest')->with('message', 'Interest added successfully');
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
        $interest = Interest::findOrFail($id);
        return $interest;
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
            'topic' => 'string | required',
            'details' => 'string | nullable',
        ]);
        $interest = Interest::findOrFail($request->interest_id);
        $interest->topic = $request->topic;
        $interest->details = $request->details;
        $interest->save();
        return redirect('interest')->with('message', 'Interest updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $interest = Interest::findOrFail($id);
        $interest->is_active = false;
        $interest->save();

        return redirect('interest')->with('message', 'Interest deleted successfully');
    }

    public function deleteBySelection(Request $request){

        $interest_id = $request['interestIdArray'];
        foreach ($interest_id as $id) {
            $lims_interest_data = Interest::findOrFail($id);
            $lims_interest_data->is_active = false;
            $lims_interest_data->save();
        }
        return 'Interest deleted successfully!';
    }
}


