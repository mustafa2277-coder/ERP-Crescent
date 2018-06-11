<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Employee;
use App\Project;
use App\Designation;
use App\EmployeeAdvance;
use App\EmployeeAllowance;
use App\EmployeeDeduction;
use App\Advance;
use App\Allowance;
use App\Deduction;

class EmployeeDeductionController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:payroll-manage|admin');
       //$this->middleware('role:admin');
    }
    public function employeeDeductionList()
    {
         $employeeList = DB::table('employee_deduction')
        
            ->join('employee', 'employee.id', '=', 'employee_deduction.empId')
            
            ->join('deduction', 'deduction.id', '=', 'employee_deduction.deductId')

            ->select('employee_deduction.*','employee.name','deduction.deduct')

            ->get();
            
        return view('employee/employeeDeduction/deduction_list')->with('employeesDeduction',$employeeList);
    }
    
    public function getAddEmployeeDeduction()
    {
        //$accountHeads=AccountHead::all();
        $employee=Employee::all();
        $deduct=Deduction::all();
       
        return view('employee/employeeDeduction/deductionForm',compact('employee','deduct'));
    }
    public function addEmployeeDeduction(Request $request)
    {

        $employeeDeduction=new EmployeeDeduction;
        //$product->code=$request->code;
        $employeeDeduction->empId=$request->employee;
        $employeeDeduction->deductId=$request->deduct;
        $employeeDeduction->amount=$request->amount;
        $employeeDeduction->dDate=date("Y-m-d",strtotime(str_replace('/', '-', $request->dDate)));
        $employeeDeduction->save();
       
        //return redirect('getAddProduct');
        return redirect('employeeDeductionList');
    }
    public function getEditEmployeeDeduction($id)
    {
        $employeesDeduction=EmployeeDeduction::find($id);
        $employee=Employee::all();
        $deduct=Deduction::all();       
        return view('employee/employeeDeduction/deductionForm',compact('employeesDeduction','employee','deduct'));
    }
    public function editEmployeeDeduction(Request $request){
        
        EmployeeDeduction::where('id','=',$request->id)->update(['empid' => $request->employee,
                'deductId'=>$request->deduct,
                'dDate'=>date("Y-m-d",strtotime(str_replace('/', '-', $request->dDate))),
                'amount'=>$request->amount,
                
                ]);
       return redirect('employeeDeductionList');
    }
}
