<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Reminder;
use App\Customer;
use Auth;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('reminder-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach($permissions as $permission){
                $all_permission[] = $permission->name;
            }
            $reminders = Reminder::where('is_active',true)->get();
            $customers = Customer::where('is_active', true)->get();
            return view('reminder.index', compact('reminders','customers','all_permission'));
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
        $this->validate($request,[
            'customer_id' => 'required|integer',
            'topic' => 'string|required|max:100',
            'note' => 'string|nullable|max:255',
            'date' => 'date|required',
            'time' => 'required'
        ],[
            'customer_id.required' => 'Please select customer'
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status'] = true;
        $data['is_active'] = true;
        try{
          $reminder = Reminder::create($data);
          $message = 'Reminder added successfully';
        }catch(\Exception $e){
           $message = 'something wrong !';
        }
        return redirect('reminder')->with('create_message', $message);
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
        $reminder = Reminder::with('customer')->findOrFail($id);
        return response()->json($reminder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateReminder(Request $request)
    {
        $this->validate($request,[
            'customer_id' => 'required|integer',
            'topic' => 'string|required|max:100',
            'note' => 'string|nullable|max:255',
            'date' => 'date|required',
            'time' => 'required'
        ],[
            'customer_id.required' => 'Please select customer'
        ]);
        $reminder = Reminder::findOrFail($request->reminder_id);
        $reminder['customer_id'] = $request->customer_id;
        $reminder['topic'] = $request->topic;
        $reminder['date'] = $request->date;
        $reminder['time'] = $request->time;
        $reminder['note'] = $request->note;
        $reminder->save();

        $message = "Reminder updated successfully";
        return redirect()->back()->with('create_message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder['is_active'] = false;
        $reminder->save();
        $message = "Reminder deleted successfully";
        return redirect()->back()->with('create_message', $message);
    }

    public function statusComplete($id){
         $reminder = Reminder::findOrFail($id);
         $reminder['status'] = 0;
         $reminder->save();
         $message = "Reminder status change successfully";
         return redirect()->back()->with('create_message', $message);
    }

    public function statusIncomplete($id){
        $reminder = Reminder::findOrFail($id);
        $reminder['status'] = 1;
        $reminder->save();
        $message = "Reminder status change successfully";
        return redirect()->back()->with('create_message', $message);;
    }

    public function deleteBySelection(Request $request){
        $reminder_id = $request['reminderIdArray'];
        foreach ($reminder_id as $id) {
            $lims_reminder_data = Reminder::find($id);
            $lims_reminder_data->is_active = false;
            $lims_reminder_data->save();
        }
        return 'Reminder deleted successfully!';
    }
}

