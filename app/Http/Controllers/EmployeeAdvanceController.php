<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Employee;
use App\Project;
use App\Designation;
use App\EmployeeAdvance;
use App\Advance;

class EmployeeAdvanceController extends Controller
{
    public function employeeAdvanceList()
    {
         $employeeList = DB::table('employee_advance')
        
            ->join('employee', 'employee.id', '=', 'employee_advance.empId')
            
            ->join('advance', 'advance.id', '=', 'employee_advance.advId')

            ->select('employee_advance.*','employee.name','advance.adv')

            ->get();
            
        return view('employee/employeeAdvance/advance_list')->with('employeesAdvance',$employeeList);
    }
    
    public function getAddEmployeeAdvance()
    {
        //$accountHeads=AccountHead::all();
        $employee=Employee::all();
        $advs=Advance::all();
       
        return view('employee/employeeAdvance/advanceForm',compact('employee','advs'));
    }
    public function addEmployeeAdvance(Request $request)
    {

        $employeeAdvance=new EmployeeAdvance;
        //$product->code=$request->code;
        $employeeAdvance->empId=$request->employee;
        $employeeAdvance->advId=$request->adv;
        $employeeAdvance->amount=$request->amount;
        $employeeAdvance->monthlyDeduction=$request->deductPerMonth;
        $employeeAdvance->startMonth=date("Y-m-d",strtotime(str_replace('/', '-', $request->start)));
        $employeeAdvance->endMonth=date("Y-m-d",strtotime(str_replace('/', '-', $request->end)));
        
        $employeeAdvance->save();
       
        //return redirect('getAddProduct');
        return redirect('employeeAdvanceList');
    }
    public function getEditEmployeeAdvance($id)
    {
        $employeesAdvance=EmployeeAdvance::find($id);
        $employee=Employee::all();
        $advs=Advance::all();       
        return view('employee/employeeAdvance/advanceForm',compact('employeesAdvance','employee','advs'));
    }
    public function editEmployeeAdvance(Request $request){
        
       EmployeeAdvance::where('id','=',$request->id)->update(['empid' => $request->employee,
                'advId'=>$request->adv,
                'amount'=>$request->amount,
                'monthlyDeduction' => $request->deductPerMonth,
                'startMonth'=> date("Y-m-d",strtotime(str_replace('/', '-', $request->start))),
                'endMonth'=> date("Y-m-d",strtotime(str_replace('/', '-', $request->end)))
                ]);
       return redirect('employeeAdvanceList');
    }
}
