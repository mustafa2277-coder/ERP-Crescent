<?php

namespace App\Http\Controllers;

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
use Response;
use App\Allowance;
use App\Deduction;
use App\Salary;
use App\Payroll;
use App\PayrollMonth;
use PDF;

class PayrollController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:payroll-manage|admin');
       //$this->middleware('role:admin');
    }
    public function employeePayrollList()
    {
        $payrollMonths = PayrollMonth::all();
        
        return view('employee/payroll/payroll_list')->with('payrollMonths',$payrollMonths);
    }
    
    public function getAddEmployeePayroll()
    {
        //$accountHeads=AccountHead::all();
        $employees=Employee::all();
        $deduct=Deduction::all();
       
        return view('employee/payroll/payrollForm',compact('employees'));
    }
    public function addPayrollMonth(Request $request){

        $entry=new PayrollMonth;
        $entry->month=$request->month;
        $entry->year=$request->year;
        $entry->save();
        return Response::json(['message'=>'created','id'=>$entry->id],201);
    }
    public function editPayrollMonth(Request $request){

        PayrollMonth::where('id','=',$request->id)->update(['month' => $request->month,
                'year'=>$request->year                
                ]);
        return Response::json(['message'=>'updated'],201);

    }
    public function addEmployeePayroll(Request $request)
    {

        //return [$request->empId,$request->normaldays,$request->sundays,$request->overtime];
        $advanceTotal=0;
        $allowanceTotal=0;
        $deductionTotal=0;
        $days=0;
        $daysAmount=0;
        $overtimeAmount=0;
        $grossSalary=0;

        $advances=EmployeeAdvance::where('empId',$request->empId)
                                ->whereMonth('startMonth', '<=', date('m'))
                                ->whereMonth('endMonth', '>=', date('m'))                                
                                ->get();
                                
        $allowances=EmployeeAllowance::where('empId',$request->empId)
                                    ->whereMonth('aDate', '=', date('m'))                                
                                    ->get();

        $deductions=EmployeeDeduction::where('empId',$request->empId)
                                    ->whereMonth('dDate', '=', date('m'))                                
                                    ->get();

        $salary=Salary::where('empId',$request->empId)->get();
        if(sizeof($salary)<1){
            return Response::json(['message'=>'Add salary rate for this employee'],201);
        }
        
        $days=$request->normaldays+$request->sundays;
        $daysAmount=$salary[0]->salaryRate*$days;
        //return $daysAmount;
        $overtimeAmount=$salary[0]->hourlyRate*$request->overtime;
        //return $overtimeAmount;
        $grossSalary=$daysAmount+$overtimeAmount;
        //return $grossSalary;
        foreach($advances as $advance){
            $advanceTotal=$advanceTotal+$advance->monthlyDeduction;
        }

        foreach($allowances as $allowance){
            $allowanceTotal=$allowanceTotal+$allowance->amount;
        }

        foreach($deductions as $deduction){
            $deductionTotal=$deductionTotal+$deduction->amount;
        }
        
        $netAmount=$grossSalary+$allowanceTotal;
       // return $netAmount;
        $netAmount=$netAmount-$advanceTotal;
        //return $netAmount;
        $netAmount=$netAmount-$deductionTotal;
        if(!isset($request->id)){
            $payroll=new Payroll;
            $payroll->empId=$request->empId;
            $payroll->payrollMonthId=$request->payrollMonthId;
            $payroll->salaryId=$salary[0]->id;
            $payroll->normalDays=$request->normaldays;
            $payroll->sundays=$request->sundays;
            $payroll->daysAmount=$daysAmount;
            $payroll->overtime=$request->overtime;
            $payroll->overtimeAmount=$overtimeAmount;
            $payroll->grossSalary=$grossSalary;
            $payroll->alwncAmount=$allowanceTotal;
            $payroll->advAmount=$advanceTotal;
            $payroll->deductAmount=$deductionTotal;
            $payroll->netAmount=$netAmount;
            $payroll->save();
            //return $netAmount;
            return Response::json(['message'=>'inserted'],201);
        }else{
            $payroll=Payroll::find($request->id);
            $payroll->empId=$request->empId;
            $payroll->payrollMonthId=$request->payrollMonthId;
            $payroll->salaryId=$salary[0]->id;
            $payroll->normalDays=$request->normaldays;
            $payroll->sundays=$request->sundays;
            $payroll->daysAmount=$daysAmount;
            $payroll->overtime=$request->overtime;
            $payroll->overtimeAmount=$overtimeAmount;
            $payroll->grossSalary=$grossSalary;
            $payroll->alwncAmount=$allowanceTotal;
            $payroll->advAmount=$advanceTotal;
            $payroll->deductAmount=$deductionTotal;
            $payroll->netAmount=$netAmount;
            $payroll->save();
            //return $netAmount;
            return Response::json(['message'=>'updated'],201);
        }
    }
    /* public function editPayrollEntry($id){

         Payroll::where('id','=',$id)->update(['empid' => $request->employee,
                'deductId'=>$request->deduct,
                'dDate'=>date("Y-m-d",strtotime(str_replace('/', '-', $request->dDate))),
                'amount'=>$request->amount,
                
                ]);

        return Response::json(['message'=>'updated'],201);         
    } */
    public function deletePayrollEntry($id){

        $payroll=Payroll::find($id)->delete();
        return 'deleted'; 
    }
    public function getEditEmployeePayroll($id)
    {
        $payrollMonth=PayrollMonth::find($id);

        $payrolls=DB::table('employee_payroll')
        
                ->join('employee', 'employee.id', '=', 'employee_payroll.empId')
                
                /* ->join('payroll_month', 'payroll_month.id', '=', 'employee_payroll.payrollMonthId') */

                ->join('salary', 'salary.id', '=', 'employee_payroll.salaryId')

                ->select('employee_payroll.*','employee.name','salary.salaryRate')

                ->where('employee_payroll.payrollMonthId',$id)

                ->get();
        //return $payrolls;
        $employees=Employee::all();
       // $deduct=Deduction::all();       
        return view('employee/payroll/payrollForm',compact('payrolls','employees','payrollMonth'));
    }
    public function editEmployeeDeduction(Request $request){
        
        EmployeeDeduction::where('id','=',$request->id)->update(['empid' => $request->employee,
                'deductId'=>$request->deduct,
                'dDate'=>date("Y-m-d",strtotime(str_replace('/', '-', $request->dDate))),
                'amount'=>$request->amount,
                
                ]);
       return redirect('employeeDeductionList');
    }
    /* -------------------------Print Payroll---------------------------------------- */
    public function printPayroll($id)
    {
        $payrollMonth=PayrollMonth::find($id);

        $payrolls=DB::table('employee_payroll')
        
                ->join('employee', 'employee.id', '=', 'employee_payroll.empId')
                
                ->join('salary', 'salary.id', '=', 'employee_payroll.salaryId')

                ->leftjoin('project', 'project.id', '=', 'employee.projId')

                ->join('department', 'department.id', '=', 'employee.dptId')

                ->join('designation', 'designation.id', '=', 'employee.desgId')

                ->select('employee_payroll.*','employee.name','employee.dptId','department.dpt','designation.desg','project.title','project.code','salary.salaryRate')

                ->where('employee_payroll.payrollMonthId',$id)

                ->get();
        //return $payrolls;
        //$employees=Employee::all();
       // $deduct=Deduction::all();
      // return view('employee/payroll/printBlade/pPrint',compact('payrolls','employees','payrollMonth'));
       $pdf = PDF::loadView('employee/payroll/printBlade/pPrint',compact('payrolls','employees','payrollMonth'));
       return $pdf->setPaper('a4', 'landscape')->stream();
    }    


}
