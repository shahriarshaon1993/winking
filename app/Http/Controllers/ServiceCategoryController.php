<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ServiceCategory;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Auth;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('service_category')) {
            $categories = ServiceCategory::where('is_active', true)->pluck('name', 'id');
            $all_categories = ServiceCategory::where('is_active', true)->get();
            return view('service_category.create',compact('categories','all_categories'));
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
            'name' => 'required|string|max:100|unique:service_categories',
            'parent_id' => 'integer|nullable'
        ]);
        $data = $request->all();
        $data['is_active'] = true;

        ServiceCategory::create($data);
        return redirect('categories')->with('message', 'Service Category inserted successfully');

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
        $category_data = ServiceCategory::findOrFail($id);
        $parent_data = ServiceCategory::where('id', $category_data['parent_id'])->first();
        if($parent_data)
            $category_data['parent'] = $parent_data['name'];
        return $category_data;
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
            'name' => 'required|max:100|string',
            'parent_id' => 'integer|nullable'
        ]);
        $data = $request->all();
        ServiceCategory::find($data['category_id'])->update($data);
        return redirect()->back()->with('message', 'Service Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ServiceCategory::find($id)->delete();
        return redirect()->back()->with('message', 'Service Category deleted successfully');
    }

    public function deleteBySelection(Request $request){

        $category_id = $request['categoryIdArray'];
        foreach($category_id as $id){
            $category = ServiceCategory::findOrFail($id);
            $category->is_active = false;
            $category->save();
        }
        return 'Service Category deleted successfully!';
    }
}
