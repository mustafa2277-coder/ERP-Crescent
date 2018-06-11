<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Employee;
use App\Project;
use App\Designation;
use App\EmployeeAdvance;
use App\EmployeeAllowance;
use App\Advance;
use App\Allowance;
class EmployeeAllowanceController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:payroll-manage|admin');
       //$this->middleware('role:admin');
    }
    public function employeeAllowanceList()
    {
         $employeeList = DB::table('employee_allowance')
        
            ->join('employee', 'employee.id', '=', 'employee_allowance.empId')
            
            ->join('allowance', 'allowance.id', '=', 'employee_allowance.alwncId')

            ->select('employee_allowance.*','employee.name','allowance.alwnc')

            ->get();
            
        return view('employee/employeeAllowance/allowance_list')->with('employeesAllowance',$employeeList);
    }
    
    public function getAddEmployeeAllowance()
    {
        //$accountHeads=AccountHead::all();
        $employee=Employee::all();
        $alwncs=Allowance::all();
       
        return view('employee/employeeAllowance/allowanceForm',compact('employee','alwncs'));
    }
    public function addEmployeeAllowance(Request $request)
    {

        $employeeAllowance=new EmployeeAllowance;
        //$product->code=$request->code;
        $employeeAllowance->empId=$request->employee;
        $employeeAllowance->alwncId=$request->alwnc;
        $employeeAllowance->amount=$request->amount;
        $employeeAllowance->aDate=$request->aDate;
        $employeeAllowance->save();
       
        //return redirect('getAddProduct');
        return redirect('employeeAllowanceList');
    }
    public function getEditEmployeeAllowance($id)
    {
        $employeesAllowance=EmployeeAllowance::find($id);
        $employee=Employee::all();
        $alwncs=Allowance::all();       
        return view('employee/employeeAllowance/allowanceForm',compact('employeesAllowance','employee','alwncs'));
    }
    public function editEmployeeAllowance(Request $request){
        
       EmployeeAllowance::where('id','=',$request->id)->update(['empid' => $request->employee,
                'alwncId'=>$request->alwnc,
                'amount'=>$request->amount,
                'aDate'=> date("Y-m-d",strtotime(str_replace('/', '-', $request->aDate))),
                ]);
       return redirect('employeeAllowanceList');
    }
}
