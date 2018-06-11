<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Project;
use App\User;
use App\AccountHead;
use DB;
use Auth;
use Response;

class ProjectController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:acc-manage|admin');
       //$this->middleware('role:admin');
    }
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
        $customers=Customer::all();
        $accountHeads=AccountHead::where('isTransactional','=','1')->get();
        return view('project/projectForm',compact('customers','accountHeads'));
    }
    public function addProject(Request $request)
    {

        $tt =$request->code;
        $res1 = trim($tt,'_');

        $this->validate($request, [
            'code'=>'required|unique:project,code',
            ],

            ['code.unique'=>'Code Already exist',
                ]
        );

        $project=new Project;
        $project->title=$request->title;
        $project->creditAccHeadId=$request->credit;
        $project->debitAccHeadId=$request->debit;
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
        $accountHeads=AccountHead::where('isTransactional','=','1')->get();
        return view('project/projectForm',compact('projects','customers','accountHeads'));
    }
    public function editProject(Request $request){


    $tt = $request->cost;
    $res1 = trim($tt,'_');

    if(Project::where('code','=',$request->code)->where('id','<>',$request->id)
          ->exists())
    {

       $this->validate($request, [
                'code'=>'required|unique:accounthead,code',
                ],
                [
                 'code.unique'=>'Code Already exist',
                ]);
        
    }
        
        $start=date("Y-m-d",strtotime(str_replace('/', '-', $request->start)));
        $end=date("Y-m-d",strtotime(str_replace('/', '-', $request->end)));

        Project::where('id','=',$request->id)->update(['code' => $request->code,
                'title'=>$request->title,
                'description'=>$request->description,
                'cost' => $res1,
                'creditAccHeadId'=>$request->credit,
                'debitAccHeadId'=>$request->debit,
                'customerId'=>$request->customer,
                'start'=>$start,
                'end'=>$end
                ]);
        return redirect('projectList');
        
    }
}
