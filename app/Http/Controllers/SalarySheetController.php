<?php

namespace App\Http\Controllers;

use App\Employee;
use App\SalarySheet;
use App\Helper\DateTime;
use App\SalarySheetDetails;
use App\SalarySheetSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalarySheetController extends Controller
{
    public function index(){
        $salarySheets= SalarySheet::all();
        return view('salary_sheet.index', compact('salarySheets'));
    }

    public function salarySheetCreate(Request $request){
        $employees= Employee::with('user', 'user.holiday')->where('status', 1)->where('is_active', 1)->get();
        $salarySetting= SalarySheetSettings::latest()->first();
        $requests= $request->all();
        
        return view("salary_sheet.salary_sheet", compact('employees', 'requests', 'salarySetting'));
    }

    public function salarySheetGenerate(Request $request){
        // dd($request->all());
        $employees= Employee::with('user', 'user.holiday')->get();
        $requests= $request->all();
        // dd($requests);

        // $salarySheet= SalarySheet::create([
        //     'date' => $request->date,
        //     'h_rent' => $request->h_rent,
        //     'medical' => $request->medical,
        //     't_port' => $request->t_port,
        //     'allowed_leave' => $request->allowed_leave,
        //     'status' => $request->status,
        //     'year' => $request->year,
        //     'month' => $request->month
        // ]);

        // SalarySheetDetails::create([
        //     'salary_sheet_id' => $salarySheet->id,
        //     'employee_name'   => $request->
        // ]);

        return view("salary_sheet.salary_sheet", compact('employees', 'requests'));
    }

    public function salarySheetConfirm(Request $request){
        // dd($request->all());
        $salarySheet= SalarySheet::create([
            'date' => $request->date,
            'salary_sheet_setting' => $request->salary_sheet_setting,
        ]);

        foreach($request->employee_id as $key=>$employee)
        SalarySheetDetails::create([
            'salary_sheet_id' => $salarySheet->id,
            'employee_id'   => $request->employee_id[$key],
            'gross_salary'   => $request->gross_salary[$key],
            'basic'   => $request->basic[$key],
            'h_rent'   => $request->h_rent[$key],
            'medical'   => $request->medical[$key],
            't_port'   => $request->t_port[$key],
            'absent'   => $request->absent[$key],
            'deduction'   => $request->deduction[$key],
            'net_pay'   => $request->net_pay[$key],
            'status'   => $request->status[$key],
            'payment_received_date'   => $request->payment_received_date[$key],
        ]);

        return redirect()->route('salary-sheet-index')->with('message', 'Salary Sheet generated successfully.');
    }

    public function show($id){
        $salarySheet=SalarySheet::find($id);
        $salarySheetDetails=SalarySheetDetails::with('employee')->where('salary_sheet_id', $id)->get();

        return view("salary_sheet.show", compact('salarySheet', 'salarySheetDetails'));
    }

    public function destroy($id){
        $salarySheet= SalarySheet::find($id);

        $salarySheetDetails= SalarySheetDetails::where('salary_sheet_id', $id)->get();

        foreach($salarySheetDetails as $salarySheetDetail){
            $salarySheetDetail->delete();
        }

        $salarySheet->delete();

        return redirect()->back()->with('message', 'Salary sheet deleted successfully.');
    }
}
