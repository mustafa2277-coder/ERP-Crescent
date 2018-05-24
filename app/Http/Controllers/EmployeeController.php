<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Employee;
use App\Project;
use App\Designation;
use App\Department;

class EmployeeController extends Controller
{
    public function employeeList()
    {
         $employeeList = DB::table('employee')
        
            ->join('project', 'project.id', '=', 'employee.projId')
            
            ->join('designation', 'designation.id', '=', 'employee.desgId')

            ->join('department', 'department.id', '=', 'employee.dptId')

            ->select('employee.*','designation.desg','project.title','department.dpt')

            ->get();
            
        return view('employee/employee_list')->with('employees',$employeeList);
    }
    
    public function getAddEmployee()
    {
        //$accountHeads=AccountHead::all();
        $projects=Project::all();
        $designations=Designation::all();
        $departments=Department::all();
       
        return view('employee/employeeForm',compact('projects','designations','departments'));
    }
    public function addEmployee(Request $request)
    {

        $this->validate($request, [
            'cnic'=>'required|unique:employee,cnic',
            ],

            ['cnic.unique'=>'CNIC Already exist'
                ]
        );

        $employee=new Employee;
        //$product->code=$request->code;
        $employee->name=$request->name;
        $employee->address=$request->address;
        $employee->phone=$request->phone;
        $employee->mobile=$request->mobile;
        $employee->cnic=$request->cnic;
        $employee->dptId=$request->department;
        $employee->desgId=$request->designation;
        $employee->projId=$request->project;
        
        
        
        $employee->save();
       
        //return redirect('getAddProduct');
        return redirect('employeeList');
    }
    public function getEditEmployee($id)
    {
        $employees=Employee::find($id);
        $projects=Project::all();
        $designations=Designation::all();
        $departments=Department::all();
       
        return view('employee/employeeForm',compact('employees','projects','designations','departments'));
    }
    public function editEmployee(Request $request){


    if(Employee::where('cnic','=',$request->code)->where('id','<>',$request->id)
          ->exists())
    {

        $this->validate($request, [
            'cnic'=>'required|unique:employee,cnic',
            ],

            ['cnic.unique'=>'CNIC Already exist'
                ]
        );
        
    }
        
       Employee::where('id','=',$request->id)->update(['name' => $request->name,
                'name'=>$request->name,
                'address'=>$request->address,
                'phone' => $request->phone,
                'mobile'=>$request->mobile,
                'cnic'=>$request->cnic,
                'dptId'=>$request->department,
                'desgId'=>$request->designation,
                'projId'=>$request->project
                ]);
       return redirect('employeeList');
    } 
}
