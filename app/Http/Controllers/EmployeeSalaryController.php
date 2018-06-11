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
use App\Salary;

class EmployeeSalaryController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:payroll-manage|admin');
       //$this->middleware('role:admin');
    }
    public function employeeSalaryList()
    {
         $employeeList = DB::table('salary')
        
            ->join('employee', 'employee.id', '=', 'salary.empId')

            ->select('salary.*','employee.name')

            ->get();
            
        return view('employee/employeeSalary/salary_list')->with('employeesSalary',$employeeList);
    }
    
    public function getAddEmployeeSalary()
    {
        //$accountHeads=AccountHead::all();
        $employee=Employee::all();
       
       
        return view('employee/employeeSalary/salaryForm',compact('employee'));
    }
    public function addEmployeeSalary(Request $request)
    {

        $employeeSalary=new Salary;
        //$product->code=$request->code;
        $employeeSalary->empId=$request->employee;
        $employeeSalary->salaryRate=$request->salaryDay;
        $employeeSalary->hourlyRate=$request->salaryHour;
        $employeeSalary->overTimeRate=$request->overtime;
        $employeeSalary->tax=$request->tax;
        $employeeSalary->save();
       
        //return redirect('getAddProduct');
        return redirect('employeeSalaryList');
    }
    public function getEditEmployeeSalary($id)
    {
        $employeesSalary=Salary::find($id);
        $employee=Employee::all();
             
        return view('employee/employeeSalary/salaryForm',compact('employeesSalary','employee'));
    }
    public function editEmployeeSalary(Request $request){
        
        Salary::where('id','=',$request->id)->update(['empid' => $request->employee,
                'salaryRate'=>$request->salaryDay,
                'hourlyRate'=>$request->salaryHour,
                'overTimeRate'=>$request->overtime,
                'tax'=>$request->tax,
                ]);
       return redirect('employeeSalaryList');
    }
}
