<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Comment;
use App\Customer;
use Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('comments-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

            $customer_list = Customer::where('is_active',true)->get();
            $comment_list = Comment::latest()->get();
            return view('comment.index',compact('comment_list','customer_list','all_permission'));
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
            'topic' => 'string|required',
            'details' => 'string|required',
        ],[
            'customer_id.required' => 'Please select customer',
        ]);
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['status'] = true;
        try{
            Comment::create($data);
            $message = 'Comment added successfully';
        }catch(\Exception $e){
            $message = 'something wrong !';
        }
        return redirect('comment')->with('create_message', $message);


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
        $comment = Comment::with('customer')->findOrFail($id);
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateComment(Request $request)
    {
        $this->validate($request,[
            'customer_id' => 'required|integer',
            'topic' => 'string|required',
            'details' => 'string|required',
        ],[
            'customer_id.required' => 'Please select customer',
        ]);
        $comment = Comment::findOrFail($request->comment_id);
        $comment['customer_id'] = $request->customer_id;
        $comment['topic'] = $request->topic;
        $comment['details'] = $request->details;
        $comment->save();

        $message = "Comment updated successfully";
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
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('create_message', 'Comment deleted successfully');
    }

    public function deleteBySelection(Request $request){

        $comment_id = $request['commentIdArray'];
        foreach ($comment_id as $id) {
            $lims_comment_data = Comment::find($id);
            $lims_comment_data->delete();
        }
        return 'Comment deleted successfully!';
    }
}
