<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Roles;
use App\User;
use Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        if(Auth::user()->role_id <= 2) {
            $lims_role_all = Roles::where('is_active', true)->get();
            return view('role.create', compact('lims_role_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }


    public function create()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                    Rule::unique('roles')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $data = $request->all();
        Roles::create($data);
        return redirect('role')->with('message', 'Data inserted successfully');
    }

    public function edit($id)
    {
        if(Auth::user()->role_id <= 2) {
            $lims_role_data = Roles::find($id);
            return $lims_role_data;
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'max:255',
                Rule::unique('roles')->ignore($request->role_id)->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);

        $input = $request->all();
        $lims_role_data = Roles::where('id', $input['role_id'])->first();
        $lims_role_data->update($input);
        return redirect('role')->with('message', 'Data updated successfully');
    }

    public function permission($id)
    {
        if(Auth::user()->role_id <= 2) {
            $lims_role_data = Roles::find($id);
            $permissions = Role::findByName($lims_role_data->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            return view('role.permission', compact('lims_role_data', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function setPermission(Request $request)
    {
        //dd($request->input());
        // if(!env('USER_VERIFIED'))
        //     return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');

        $role = Role::firstOrCreate(['id' => $request['role_id']]);
        if($request->has('cost-breakdown-index')){
            $permission = Permission::firstOrCreate(['name' => 'cost-breakdown-index']);
            if(!$role->hasPermissionTo('cost-breakdown-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('cost-breakdown-index');
        //dd($request->input());
        if($request->has('cost-breakdown-add')){

            $permission = Permission::firstOrCreate(['name' => 'cost-breakdown-add']);
            if(!$role->hasPermissionTo('cost-breakdown-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('cost-breakdown-add');

        if($request->has('cost-breakdown-edit')){
            $permission = Permission::firstOrCreate(['name' => 'cost-breakdown-edit']);
            if(!$role->hasPermissionTo('cost-breakdown-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('cost-breakdown-edit');

        if($request->has('cost-breakdown-delete')){
            $permission = Permission::firstOrCreate(['name' => 'cost-breakdown-delete']);
            if(!$role->hasPermissionTo('cost-breakdown-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('cost-breakdown-delete');



        if($request->has('trimming-index')){
            $permission = Permission::firstOrCreate(['name' => 'trimming-index']);
            if(!$role->hasPermissionTo('trimming-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('trimming-index');



        if($request->has('income-list')){
            $permission = Permission::firstOrCreate(['name' => 'income-list']);
            if(!$role->hasPermissionTo('income-list')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('income-list');


        if($request->has('uesr-profile')){
            $permission = Permission::firstOrCreate(['name' => 'uesr-profile']);
            if(!$role->hasPermissionTo('uesr-profile')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('uesr-profile');


        if($request->has('income-source')){
            $permission = Permission::firstOrCreate(['name' => 'income-source']);
            if(!$role->hasPermissionTo('income-source')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('income-source');


        if($request->has('account-withdraw')){
            $permission = Permission::firstOrCreate(['name' => 'account-withdraw']);
            if(!$role->hasPermissionTo('account-withdraw')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('account-withdraw');


        if($request->has('export-index')){
            $permission = Permission::firstOrCreate(['name' => 'export-index']);
            if(!$role->hasPermissionTo('export-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('export-index');


        if($request->has('export-add')){
            $permission = Permission::firstOrCreate(['name' => 'export-add']);
            if(!$role->hasPermissionTo('export-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('export-add');


        if($request->has('export-edit')){
            $permission = Permission::firstOrCreate(['name' => 'export-edit']);
            if(!$role->hasPermissionTo('export-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('export-edit');


        if($request->has('export-delete')){
            $permission = Permission::firstOrCreate(['name' => 'export-delete']);
            if(!$role->hasPermissionTo('export-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('export-delete');



        if($request->has('account-deposit')){
            $permission = Permission::firstOrCreate(['name' => 'account-deposit']);
            if(!$role->hasPermissionTo('account-deposit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('account-deposit');


        if($request->has('purchase-contract-index')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-contract-index']);
            if(!$role->hasPermissionTo('purchase-contract-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-contract-index');


        if($request->has('purchase-contract-add')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-contract-add']);
            if(!$role->hasPermissionTo('purchase-contract-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-contract-add');

        if($request->has('purchase-contract-edit')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-contract-edit']);
            if(!$role->hasPermissionTo('purchase-contract-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-contract-edit');


        if($request->has('purchase-contract-delete')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-contract-delete']);
            if(!$role->hasPermissionTo('purchase-contract-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-contract-delete');



        if($request->has('cost-sheet-index')){
            $permission = Permission::firstOrCreate(['name' => 'cost-sheet-index']);
            if(!$role->hasPermissionTo('cost-sheet-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('cost-sheet-index');


        if($request->has('cost-sheet-add')){
            $permission = Permission::firstOrCreate(['name' => 'cost-sheet-add']);
            if(!$role->hasPermissionTo('cost-sheet-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('cost-sheet-add');

        if($request->has('cost-sheet-edit')){
            $permission = Permission::firstOrCreate(['name' => 'cost-sheet-edit']);
            if(!$role->hasPermissionTo('cost-sheet-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('cost-sheet-edit');


        if($request->has('cost-sheet-delete')){
            $permission = Permission::firstOrCreate(['name' => 'cost-sheet-delete']);
            if(!$role->hasPermissionTo('cost-sheet-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('cost-sheet-delete');


        if($request->has('po-index')){
            $permission = Permission::firstOrCreate(['name' => 'po-index']);
            if(!$role->hasPermissionTo('po-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('po-index');


        if($request->has('po-add')){
            $permission = Permission::firstOrCreate(['name' => 'po-add']);
            if(!$role->hasPermissionTo('po-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('po-add');

        if($request->has('po-edit')){
            $permission = Permission::firstOrCreate(['name' => 'po-edit']);
            if(!$role->hasPermissionTo('po-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('po-edit');


        if($request->has('po-delete')){
            $permission = Permission::firstOrCreate(['name' => 'po-delete']);
            if(!$role->hasPermissionTo('po-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('po-delete');


        if($request->has('proforma-invoice-index')){
            $permission = Permission::firstOrCreate(['name' => 'proforma-invoice-index']);
            if(!$role->hasPermissionTo('proforma-invoice-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('proforma-invoice-index');


        if($request->has('proforma-invoice-add')){
            $permission = Permission::firstOrCreate(['name' => 'proforma-invoice-add']);
            if(!$role->hasPermissionTo('proforma-invoice-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('proforma-invoice-add');

        if($request->has('proforma-invoice-edit')){
            $permission = Permission::firstOrCreate(['name' => 'proforma-invoice-edit']);
            if(!$role->hasPermissionTo('proforma-invoice-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('proforma-invoice-edit');


        if($request->has('proforma-invoice-delete')){
            $permission = Permission::firstOrCreate(['name' => 'proforma-invoice-delete']);
            if(!$role->hasPermissionTo('proforma-invoice-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('proforma-invoice-delete');


        if($request->has('products-index')){
            $permission = Permission::firstOrCreate(['name' => 'products-index']);
            if(!$role->hasPermissionTo('products-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('products-index');

        if($request->has('products-add')){
            $permission = Permission::firstOrCreate(['name' => 'products-add']);
            if(!$role->hasPermissionTo('products-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('products-add');
        if($request->has('products-edit')){
            $permission = Permission::firstOrCreate(['name' => 'products-edit']);
            if(!$role->hasPermissionTo('products-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('products-edit');

        if($request->has('products-delete')){
            $permission = Permission::firstOrCreate(['name' => 'products-delete']);
            if(!$role->hasPermissionTo('products-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('products-delete');

        if($request->has('services-index')){
            $permission = Permission::firstOrCreate(['name' => 'services-index']);
            if(!$role->hasPermissionTo('services-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('services-index');

        if($request->has('services-add')){
            $permission = Permission::firstOrCreate(['name' => 'services-add']);
            if(!$role->hasPermissionTo('services-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('services-add');

        if($request->has('services-edit')){
            $permission = Permission::firstOrCreate(['name' => 'services-edit']);
            if(!$role->hasPermissionTo('services-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('services-edit');

        if($request->has('services-delete')){
            $permission = Permission::firstOrCreate(['name' => 'services-delete']);
            if(!$role->hasPermissionTo('services-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('services-delete');

        if($request->has('purchases-index')){
            $permission = Permission::firstOrCreate(['name' => 'purchases-index']);
            if(!$role->hasPermissionTo('purchases-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchases-index');

        if($request->has('purchases-add')){
            $permission = Permission::firstOrCreate(['name' => 'purchases-add']);
            if(!$role->hasPermissionTo('purchases-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchases-add');

        if($request->has('purchases-edit')){
            $permission = Permission::firstOrCreate(['name' => 'purchases-edit']);
            if(!$role->hasPermissionTo('purchases-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchases-edit');

        if($request->has('purchases-delete')){
            $permission = Permission::firstOrCreate(['name' => 'purchases-delete']);
            if(!$role->hasPermissionTo('purchases-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchases-delete');

        if($request->has('sales-index')){
            $permission = Permission::firstOrCreate(['name' => 'sales-index']);
            if(!$role->hasPermissionTo('sales-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('sales-index');

        if($request->has('sales-add')){
            $permission = Permission::firstOrCreate(['name' => 'sales-add']);
            if(!$role->hasPermissionTo('sales-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('sales-add');

        if($request->has('sales-edit')){
            $permission = Permission::firstOrCreate(['name' => 'sales-edit']);
            if(!$role->hasPermissionTo('sales-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('sales-edit');

        if($request->has('sales-delete')){
            $permission = Permission::firstOrCreate(['name' => 'sales-delete']);
            if(!$role->hasPermissionTo('sales-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('sales-delete');

        if($request->has('service-sales-index')){
            $permission = Permission::firstOrCreate(['name' => 'service-sales-index']);
            if(!$role->hasPermissionTo('service-sales-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('service-sales-index');

        if($request->has('service-sales-add')){
            $permission = Permission::firstOrCreate(['name' => 'service-sales-add']);
            if(!$role->hasPermissionTo('service-sales-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('service-sales-add');

        if($request->has('service-sales-edit')){
            $permission = Permission::firstOrCreate(['name' => 'service-sales-edit']);
            if(!$role->hasPermissionTo('service-sales-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('service-sales-edit');

        if($request->has('service-sales-delete')){
            $permission = Permission::firstOrCreate(['name' => 'service-sales-delete']);
            if(!$role->hasPermissionTo('service-sales-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('service-sales-delete');

        if($request->has('print_qrcode')){
            $permission = Permission::firstOrCreate(['name' => 'print_qrcode']);
            if(!$role->hasPermissionTo('print_qrcode')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('print_qrcode');


        if($request->has('expenses-index')){
            $permission = Permission::firstOrCreate(['name' => 'expenses-index']);
            if(!$role->hasPermissionTo('expenses-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('expenses-index');

        if($request->has('expenses-add')){
            $permission = Permission::firstOrCreate(['name' => 'expenses-add']);
            if(!$role->hasPermissionTo('expenses-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('expenses-add');

        if($request->has('expenses-edit')){
            $permission = Permission::firstOrCreate(['name' => 'expenses-edit']);
            if(!$role->hasPermissionTo('expenses-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('expenses-edit');

        if($request->has('expenses-delete')){
            $permission = Permission::firstOrCreate(['name' => 'expenses-delete']);
            if(!$role->hasPermissionTo('expenses-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('expenses-delete');

        if($request->has('quotes-index')){
            $permission = Permission::firstOrCreate(['name' => 'quotes-index']);
            if(!$role->hasPermissionTo('quotes-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('quotes-index');

        if($request->has('quotes-add')){
            $permission = Permission::firstOrCreate(['name' => 'quotes-add']);
            if(!$role->hasPermissionTo('quotes-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('quotes-add');

        if($request->has('quotes-edit')){
            $permission = Permission::firstOrCreate(['name' => 'quotes-edit']);
            if(!$role->hasPermissionTo('quotes-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('quotes-edit');

        if($request->has('quotes-delete')){
            $permission = Permission::firstOrCreate(['name' => 'quotes-delete']);
            if(!$role->hasPermissionTo('quotes-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('quotes-delete');

        if($request->has('transfers-index')){
            $permission = Permission::firstOrCreate(['name' => 'transfers-index']);
            if(!$role->hasPermissionTo('transfers-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('transfers-index');

        if($request->has('transfers-add')){
            $permission = Permission::firstOrCreate(['name' => 'transfers-add']);
            if(!$role->hasPermissionTo('transfers-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('transfers-add');

        if($request->has('transfers-edit')){
            $permission = Permission::firstOrCreate(['name' => 'transfers-edit']);
            if(!$role->hasPermissionTo('transfers-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('transfers-edit');

        if($request->has('transfers-delete')){
            $permission = Permission::firstOrCreate(['name' => 'transfers-delete']);
            if(!$role->hasPermissionTo('transfers-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('transfers-delete');

        if($request->has('comments-index')){
            $permission = Permission::firstOrCreate(['name' => 'comments-index']);
            if(!$role->hasPermissionTo('comments-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('comments-index');

        if($request->has('comments-add')){
            $permission = Permission::firstOrCreate(['name' => 'comments-add']);
            if(!$role->hasPermissionTo('comments-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('comments-add');

        if($request->has('comments-edit')){
            $permission = Permission::firstOrCreate(['name' => 'comments-edit']);
            if(!$role->hasPermissionTo('comments-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('comments-edit');

        if($request->has('comments-delete')){
            $permission = Permission::firstOrCreate(['name' => 'comments-delete']);
            if(!$role->hasPermissionTo('comments-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('comments-delete');

        if($request->has('returns-index')){
            $permission = Permission::firstOrCreate(['name' => 'returns-index']);
            if(!$role->hasPermissionTo('returns-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('returns-index');

        if($request->has('returns-add')){
            $permission = Permission::firstOrCreate(['name' => 'returns-add']);
            if(!$role->hasPermissionTo('returns-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('returns-add');

        if($request->has('returns-edit')){
            $permission = Permission::firstOrCreate(['name' => 'returns-edit']);
            if(!$role->hasPermissionTo('returns-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('returns-edit');

        if($request->has('returns-delete')){
            $permission = Permission::firstOrCreate(['name' => 'returns-delete']);
            if(!$role->hasPermissionTo('returns-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('returns-delete');

        if($request->has('purchase-return-index')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-return-index']);
            if(!$role->hasPermissionTo('purchase-return-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-return-index');

        if($request->has('purchase-return-add')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-return-add']);
            if(!$role->hasPermissionTo('purchase-return-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-return-add');

        if($request->has('purchase-return-edit')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-return-edit']);
            if(!$role->hasPermissionTo('purchase-return-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-return-edit');

        if($request->has('purchase-return-delete')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-return-delete']);
            if(!$role->hasPermissionTo('purchase-return-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-return-delete');

        if($request->has('account-index')){
            $permission = Permission::firstOrCreate(['name' => 'account-index']);
            if(!$role->hasPermissionTo('account-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('account-index');

        if($request->has('money-transfer')){
            $permission = Permission::firstOrCreate(['name' => 'money-transfer']);
            if(!$role->hasPermissionTo('money-transfer')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('money-transfer');

        if($request->has('balance-sheet')){
            $permission = Permission::firstOrCreate(['name' => 'balance-sheet']);
            if(!$role->hasPermissionTo('balance-sheet')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('balance-sheet');

        if($request->has('account-statement')){
            $permission = Permission::firstOrCreate(['name' => 'account-statement']);
            if(!$role->hasPermissionTo('account-statement')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('account-statement');

        if($request->has('department')){
            $permission = Permission::firstOrCreate(['name' => 'department']);
            if(!$role->hasPermissionTo('department')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('department');

        if($request->has('attendance')){
            $permission = Permission::firstOrCreate(['name' => 'attendance']);
            if(!$role->hasPermissionTo('attendance')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('attendance');

        if($request->has('payroll')){
            $permission = Permission::firstOrCreate(['name' => 'payroll']);
            if(!$role->hasPermissionTo('payroll')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('payroll');

        if($request->has('employees-index')){
            $permission = Permission::firstOrCreate(['name' => 'employees-index']);
            if(!$role->hasPermissionTo('employees-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('employees-index');

        if($request->has('employees-add')){
            $permission = Permission::firstOrCreate(['name' => 'employees-add']);
            if(!$role->hasPermissionTo('employees-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('employees-add');

        if($request->has('employees-edit')){
            $permission = Permission::firstOrCreate(['name' => 'employees-edit']);
            if(!$role->hasPermissionTo('employees-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('employees-edit');

        if($request->has('employees-delete')){
            $permission = Permission::firstOrCreate(['name' => 'employees-delete']);
            if(!$role->hasPermissionTo('employees-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('employees-delete');

        if($request->has('users-index')){
            $permission = Permission::firstOrCreate(['name' => 'users-index']);
            if(!$role->hasPermissionTo('users-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('users-index');

        if($request->has('users-add')){
            $permission = Permission::firstOrCreate(['name' => 'users-add']);
            if(!$role->hasPermissionTo('users-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('users-add');

        if($request->has('users-edit')){
            $permission = Permission::firstOrCreate(['name' => 'users-edit']);
            if(!$role->hasPermissionTo('users-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('users-edit');

        if($request->has('users-delete')){
            $permission = Permission::firstOrCreate(['name' => 'users-delete']);
            if(!$role->hasPermissionTo('users-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('users-delete');





        if($request->has('customers-index')){
            $permission = Permission::firstOrCreate(['name' => 'customers-index']);
            if(!$role->hasPermissionTo('customers-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('customers-index');

        if($request->has('customers-add')){
            $permission = Permission::firstOrCreate(['name' => 'customers-add']);
            if(!$role->hasPermissionTo('customers-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('customers-add');

        if($request->has('customers-edit')){
            $permission = Permission::firstOrCreate(['name' => 'customers-edit']);
            if(!$role->hasPermissionTo('customers-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('customers-edit');

        if($request->has('customers-delete')){
            $permission = Permission::firstOrCreate(['name' => 'customers-delete']);
            if(!$role->hasPermissionTo('customers-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('customers-delete');


        if($request->has('reminder-index')){
            $permission = Permission::firstOrCreate(['name' => 'reminder-index']);
            if(!$role->hasPermissionTo('reminder-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('reminder-index');

        if($request->has('reminder-add')){
            $permission = Permission::firstOrCreate(['name' => 'reminder-add']);
            if(!$role->hasPermissionTo('reminder-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('reminder-add');

        if($request->has('reminder-edit')){
            $permission = Permission::firstOrCreate(['name' => 'reminder-edit']);
            if(!$role->hasPermissionTo('reminder-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('reminder-edit');

        if($request->has('reminder-delete')){
            $permission = Permission::firstOrCreate(['name' => 'reminder-delete']);
            if(!$role->hasPermissionTo('reminder-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('reminder-delete');

        if($request->has('reminder-alert')){
            $permission = Permission::firstOrCreate(['name' => 'reminder-alert']);
            if(!$role->hasPermissionTo('reminder-alert')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('reminder-alert');

        if($request->has('billers-index')){
            $permission = Permission::firstOrCreate(['name' => 'billers-index']);
            if(!$role->hasPermissionTo('billers-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('billers-index');

        if($request->has('billers-add')){
            $permission = Permission::firstOrCreate(['name' => 'billers-add']);
            if(!$role->hasPermissionTo('billers-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('billers-add');

        if($request->has('billers-edit')){
            $permission = Permission::firstOrCreate(['name' => 'billers-edit']);
            if(!$role->hasPermissionTo('billers-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('billers-edit');

        if($request->has('billers-delete')){
            $permission = Permission::firstOrCreate(['name' => 'billers-delete']);
            if(!$role->hasPermissionTo('billers-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('billers-delete');

        if($request->has('suppliers-index')){
            $permission = Permission::firstOrCreate(['name' => 'suppliers-index']);
            if(!$role->hasPermissionTo('suppliers-index')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('suppliers-index');

        if($request->has('suppliers-add')){
            $permission = Permission::firstOrCreate(['name' => 'suppliers-add']);
            if(!$role->hasPermissionTo('suppliers-add')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('suppliers-add');

        if($request->has('suppliers-edit')){
            $permission = Permission::firstOrCreate(['name' => 'suppliers-edit']);
            if(!$role->hasPermissionTo('suppliers-edit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('suppliers-edit');

        if($request->has('suppliers-delete')){
            $permission = Permission::firstOrCreate(['name' => 'suppliers-delete']);
            if(!$role->hasPermissionTo('suppliers-delete')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('suppliers-delete');

        if($request->has('profit-loss')){
            $permission = Permission::firstOrCreate(['name' => 'profit-loss']);
            if(!$role->hasPermissionTo('profit-loss')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('profit-loss');

        if($request->has('best-seller')){
            $permission = Permission::firstOrCreate(['name' => 'best-seller']);
            if(!$role->hasPermissionTo('best-seller')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('best-seller');

        if($request->has('product-report')){
            $permission = Permission::firstOrCreate(['name' => 'product-report']);
            if(!$role->hasPermissionTo('product-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('product-report');

        if($request->has('daily-sale')){
            $permission = Permission::firstOrCreate(['name' => 'daily-sale']);
            if(!$role->hasPermissionTo('daily-sale')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('daily-sale');

        if($request->has('monthly-sale')){
            $permission = Permission::firstOrCreate(['name' => 'monthly-sale']);
            if(!$role->hasPermissionTo('monthly-sale')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('monthly-sale');

        if($request->has('daily-purchase')){
            $permission = Permission::firstOrCreate(['name' => 'daily-purchase']);
            if(!$role->hasPermissionTo('daily-purchase')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('daily-purchase');

        if($request->has('monthly-purchase')){
            $permission = Permission::firstOrCreate(['name' => 'monthly-purchase']);
            if(!$role->hasPermissionTo('monthly-purchase')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('monthly-purchase');

        if($request->has('sale-report')){
            $permission = Permission::firstOrCreate(['name' => 'sale-report']);
            if(!$role->hasPermissionTo('sale-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('sale-report');

        if($request->has('payment-report')){
            $permission = Permission::firstOrCreate(['name' => 'payment-report']);
            if(!$role->hasPermissionTo('payment-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('payment-report');

        if($request->has('purchase-report')){
            $permission = Permission::firstOrCreate(['name' => 'purchase-report']);
            if(!$role->hasPermissionTo('purchase-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('purchase-report');

        if($request->has('warehouse-report')){
            $permission = Permission::firstOrCreate(['name' => 'warehouse-report']);
            if(!$role->hasPermissionTo('warehouse-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('warehouse-report');

        if($request->has('warehouse-stock-report')){
            $permission = Permission::firstOrCreate(['name' => 'warehouse-stock-report']);
            if(!$role->hasPermissionTo('warehouse-stock-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('warehouse-stock-report');

        if($request->has('product-qty-alert')){
            $permission = Permission::firstOrCreate(['name' => 'product-qty-alert']);
            if(!$role->hasPermissionTo('product-qty-alert')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('product-qty-alert');

        if($request->has('user-report')){
            $permission = Permission::firstOrCreate(['name' => 'user-report']);
            if(!$role->hasPermissionTo('user-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('user-report');

        if($request->has('customer-report')){
            $permission = Permission::firstOrCreate(['name' => 'customer-report']);
            if(!$role->hasPermissionTo('customer-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('customer-report');

        if($request->has('supplier-report')){
            $permission = Permission::firstOrCreate(['name' => 'supplier-report']);
            if(!$role->hasPermissionTo('supplier-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('supplier-report');

        if($request->has('due-report')){
            $permission = Permission::firstOrCreate(['name' => 'due-report']);
            if(!$role->hasPermissionTo('due-report')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('due-report');

        if($request->has('backup_database')){
            $permission = Permission::firstOrCreate(['name' => 'backup_database']);
            if(!$role->hasPermissionTo('backup_database')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('backup_database');

        if($request->has('general_setting')){
            $permission = Permission::firstOrCreate(['name' => 'general_setting']);
            if(!$role->hasPermissionTo('general_setting')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('general_setting');

        if($request->has('mail_setting')){
            $permission = Permission::firstOrCreate(['name' => 'mail_setting']);
            if(!$role->hasPermissionTo('mail_setting')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('mail_setting');

        if($request->has('sms_setting')){
            $permission = Permission::firstOrCreate(['name' => 'sms_setting']);
            if(!$role->hasPermissionTo('sms_setting')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('sms_setting');

        if($request->has('create_sms')){
            $permission = Permission::firstOrCreate(['name' => 'create_sms']);
            if(!$role->hasPermissionTo('create_sms')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('create_sms');

        if($request->has('pos_setting')){
            $permission = Permission::firstOrCreate(['name' => 'pos_setting']);
            if(!$role->hasPermissionTo('pos_setting')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('pos_setting');

        if($request->has('hrm_setting')){
            $permission = Permission::firstOrCreate(['name' => 'hrm_setting']);
            if(!$role->hasPermissionTo('hrm_setting')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('hrm_setting');

        if($request->has('stock_count')){
            $permission = Permission::firstOrCreate(['name' => 'stock_count']);
            if(!$role->hasPermissionTo('stock_count')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('stock_count');

        if($request->has('adjustment')){
            $permission = Permission::firstOrCreate(['name' => 'adjustment']);
            if(!$role->hasPermissionTo('adjustment')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('adjustment');

        if($request->has('print_barcode')){
            $permission = Permission::firstOrCreate(['name' => 'print_barcode']);
            if(!$role->hasPermissionTo('print_barcode')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('print_barcode');

        if($request->has('empty_database')){
            $permission = Permission::firstOrCreate(['name' => 'empty_database']);
            if(!$role->hasPermissionTo('empty_database')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('empty_database');

        if($request->has('send_notification')){
            $permission = Permission::firstOrCreate(['name' => 'send_notification']);
            if(!$role->hasPermissionTo('send_notification')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('send_notification');

        if($request->has('warehouse')){
            $permission = Permission::firstOrCreate(['name' => 'warehouse']);
            if(!$role->hasPermissionTo('warehouse')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('warehouse');


        if($request->has('interest')){
            $permission = Permission::firstOrCreate(['name' => 'interest']);
            if(!$role->hasPermissionTo('interest')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('interest');

        if($request->has('brand')){
            $permission = Permission::firstOrCreate(['name' => 'brand']);
            if(!$role->hasPermissionTo('brand')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('brand');

        if($request->has('unit')){
            $permission = Permission::firstOrCreate(['name' => 'unit']);
            if(!$role->hasPermissionTo('unit')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('unit');

        if($request->has('currency')){
            $permission = Permission::firstOrCreate(['name' => 'currency']);
            if(!$role->hasPermissionTo('currency')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('currency');

        if($request->has('tax')){
            $permission = Permission::firstOrCreate(['name' => 'tax']);
            if(!$role->hasPermissionTo('tax')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('tax');

        if($request->has('gift_card')){
            $permission = Permission::firstOrCreate(['name' => 'gift_card']);
            if(!$role->hasPermissionTo('gift_card')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('gift_card');

        if($request->has('coupon')){
            $permission = Permission::firstOrCreate(['name' => 'coupon']);
            if(!$role->hasPermissionTo('coupon')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('coupon');

        if($request->has('holiday')){
            $permission = Permission::firstOrCreate(['name' => 'holiday']);
            if(!$role->hasPermissionTo('holiday')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('holiday');

        if($request->has('category')){
            $permission = Permission::firstOrCreate(['name' => 'category']);
            if(!$role->hasPermissionTo('category')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('category');

        if($request->has('service_category')){
            $permission = Permission::firstOrCreate(['name' => 'service_category']);
            if(!$role->hasPermissionTo('service_category')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('service_category');
        if($request->has('service_delivery')){
            $permission = Permission::firstOrCreate(['name' => 'service_delivery']);
            if(!$role->hasPermissionTo('service_delivery')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('service_delivery');

        if($request->has('delivery')){
            $permission = Permission::firstOrCreate(['name' => 'delivery']);
            if(!$role->hasPermissionTo('delivery')){
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('delivery');

        if($request->has('today_sale')) {
            $permission = Permission::firstOrCreate(['name' => 'today_sale']);
            if(!$role->hasPermissionTo('today_sale')) {
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('today_sale');

        if($request->has('today_profit')) {
            $permission = Permission::firstOrCreate(['name' => 'today_profit']);
            if(!$role->hasPermissionTo('today_profit')) {
                $role->givePermissionTo($permission);
            }
        }
        else
            $role->revokePermissionTo('today_profit');

        return redirect('role')->with('message', 'Permission updated successfully');
    }

    public function destroy($id)
    {
        if(!env('USER_VERIFIED'))
            return redirect()->back()->with('not_permitted', 'This feature is disable for demo!');
        $lims_role_data = Roles::find($id);
        $lims_role_data->is_active = false;
        $lims_role_data->save();
        return redirect('role')->with('not_permitted', 'Data deleted successfully');
    }
}
