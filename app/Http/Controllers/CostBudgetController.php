<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Account;
use App\Expense;
use App\CostBudget;
use App\Transaction;
use App\CashRegister;
use App\ExpenseCategory;
use Illuminate\Http\Request;
use App\Helper\AccountHelper;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class CostBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('expenses-index')) {
            $permissions = Role::findByName($role->name)->permissions;

            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if (empty($all_permission))
                $all_permission[] = 'dummy text';

            $lims_expense_category_all = ExpenseCategory::where('is_active', true)->get();

                $lims_cost_budgets = CostBudget::orderBy('id', 'desc')->get();

            return view('cost_budget.index', compact('lims_cost_budgets', 'all_permission', 'lims_expense_category_all'));
        } else
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
        $costBudget= new CostBudget();

        $costBudget->month = $request->month;
        $costBudget->purpose = json_encode($request->purpose);
        $costBudget->amount = json_encode($request->amount);
        $costBudget->payment_date = json_encode($request->payment_date);
        $costBudget->total = $request->total;
        $costBudget->note = $request->note;

        $costBudget->save();

        return redirect()->back()->with('message', 'Cost Budget created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $costBudget= CostBudget::find($id);
        $lims_expense_category_all = ExpenseCategory::where('is_active', true)->get();
        // dd($lims_expense_category_all);
        return view('cost_budget.show', compact('costBudget', 'lims_expense_category_all'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $costBudget= CostBudget::find($id);

        // return $costBudget;
        return view('cost_budget.edit', compact('costBudget'));
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
        // dd($request->all());
        $costBudget= CostBudget::find($id);

        $costBudget->month = $request->month;
        $costBudget->purpose = json_encode($request->purpose);
        $costBudget->amount = json_encode($request->amount);
        $costBudget->payment_date = json_encode($request->payment_date);
        $costBudget->total = $request->total;
        $costBudget->note = $request->edit_modal_note;

        $costBudget->save();

        return redirect(route('cost-budget.index'))->with('message', 'Cost Budget updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $costBudget= CostBudget::find($id);
            $costBudget->delete();

            return redirect()->back()->with('message', 'Cost budget deleted successfully.');
        }catch(\Exception $e){
            return redirect()->back()->with('message', $e);
        }
    }
}
