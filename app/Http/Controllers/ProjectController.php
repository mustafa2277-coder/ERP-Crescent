<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Project;
use App\User;
use DB;
use Auth;
use Response;

class ProjectController extends Controller
{
    public function projectList()
    {
        $projectList = DB::table('project')
        
            ->join('customers', 'customers.id', '=', 'project.customerId')

            ->select( 'customers.name','project.*')
            
            //->distinct()

            //->get();

            ->paginate('20');
       
        return view('project/project_list')->with('projectList',$projectList);
    }
    
    public function getAddProject()
    {
        $customer=Customer::all();
        return view('project/projectForm')->with('customers',$customer);
    }
    public function addProject(Request $request)
    {

        $project=new Project;
        $project->title=$request->title;
        $project->code=$request->code;
        $project->description=$request->description;
        $project->start=date("Y-m-d",strtotime(str_replace('/', '-', $request->start)));
        $project->end=date("Y-m-d",strtotime(str_replace('/', '-', $request->end)));
        $project->customerId=$request->customer;
        $project->save();
       

        return redirect('projectList');
    }
    public function getEditProject($id)
    {
        $projects= Project::where('id','=',$id)->get();
        $customers = Customer::all();
       
        return view('project/projectForm',compact('projects','customers'));
    }
    public function editProject(Request $request){
        
        $start=date("Y-m-d",strtotime(str_replace('/', '-', $request->start)));
        $end=date("Y-m-d",strtotime(str_replace('/', '-', $request->end)));

        Project::where('id','=',$request->id)->update(['code' => $request->code,
                'title'=>$request->title,
                'description'=>$request->description,
                'cost' => $request->cost,
                'customerId'=>$request->customer,
                'start'=>$start,
                'end'=>$end
                ]);
        return redirect('projectList');
        
    }
}
