<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\AccountHead;
use Illuminate\Support\Facades\Route;
class AccountHeadController extends Controller
{

    public function GetAccountHeads(Request $request){
        
        $arr=null;
        

        

        $accountHeads = DB::select( DB::raw("SELECT acchead.id id,acchead.name name,accht.type type,				acchead.code code from accounthead acchead left JOIN             accountheadtypes accht on accht.id=acchead.accHeadTypeId"));

        $accountHeads2 = DB::select( DB::raw("
                    SELECT aha.name ,aha.id id  FROM accounthead aha
                    WHERE aha.`parentId` = 0 OR aha.`parentId`IS NULL"));
       

        foreach($accountHeads2 as $item){

        $addNew = '<a   style="float: right; " id="addew" href="'. URL('/addAccountHead').'/'.$item->id.'"> <i class="material-icons"  title="Add Sub Head">add_circle_outline</i></a>';    

        $edit = '<a  style="float: right; " href="'.URL('/editAccountHead').'/'.$item->id.'"><i class="material-icons" title="Edit Head">mode_edit</i></a>';
        //$arr .= '<li class="dd-item" data-id="'.$item->id.'"><div class="dd-handle">'.$this->GetTreeAccountHeads($item).'</div>';    

        //$arr.= $this->GetTreeAccountHeads($item);

        $arr.='<li class="dd-item" data-id="'.$item->id.'"><div class="dd-handle">'.$item->name.$addNew.$edit.'  </div>'.$this->GetTreeAccountHeads($item).'</li>';

        }

//         $accountHeads2 = DB::select( DB::raw("
// SELECT aha.name parent,aha.id parentid  FROM accounthead aha"));

//         $accountHeads3 = DB::select( DB::raw("
// SELECT aha.name child ,aha.id childid ,aha.parentId parentid FROM accounthead aha
// WHERE aha.parentId IS NOT NULL AND aha.parentId <> 0"));

        return view('/AccountHead/acc_head_list',compact('accountHeads','arr'));//,'accountHeads3'));
    	
    }


    public function GetTreeAccountHeads($parent){

    $arr=null;  

     //$arr .= "<div class='dd-handle'>"{{$request->parent}}."</div>";
     $accountHeads2 = DB::select( DB::raw("
                    SELECT * from accounthead where parentId=".$parent->id));

    if(count($accountHeads2)!=0){

        foreach($accountHeads2 as $item){


         $addNew = '<a style="float:  right;" id="addew" href="'. URL('/addAccountHead').'/'.$item->id.'"> <i class="material-icons"   title="Add Sub Head">add_circle_outline</i></a>';    

        $edit = '<a style="float:  right;" href="'.URL('/editAccountHead').'/'.$item->id.'"><i class="material-icons" title="Edit Head">mode_edit</i></a>';    
        
         $arr .= '<ol class="dd-list"><li class="dd-item" data-id="'.$item->id.'"><div class="dd-handle">'.$item->name. $addNew.$edit.'</div>'.$this->GetTreeAccountHeads($item).'</li></ol>';

        }
        return $arr;
    }else{

        return  ; 


    }



    }

    // for opening a new record form   used for add new record from

    public function GetAccountHeadForm($id){

    	$types = DB::select( DB::raw("SELECT * from accountheadtypes Order By type") );
        $parentId = $id;

        return view('/AccountHead/acc_head_add', compact('types','parentId'));
        
    }

    // for getiing a record against its id  used for editing a record
    public function GetAccountHeadById($id){
       
        $record=AccountHead::find($id);

        $types = DB::select( DB::raw("SELECT * from accountheadtypes Order By type") );
      

       return view('/AccountHead/acc_head_add', compact('types','record'));
       
    }

     // for inserting a record   used for add new record

    public function InsertAccountHead(Request $request){
        $this->validate($request, [
            'acchead_code'=>'required|unique:accounthead,code',
            'acchead_name'=>'required|unique:accounthead,name',
            'type_id'=>'required'
            ],

            ['acchead_name.unique'=>'Name Already exist',
             'acchead_code.unique'=>'Code Already exist',
                ]
        );

       // $user=Auth::user();
        $insert= new AccountHead;
        $insert->name=$request->acchead_name;
        $insert->code=$request->acchead_code;
        $insert->accHeadTypeId=$request->type_id;
        $insert->isTransactional=$request->is_tran=="on"?1:0;
        $insert->parentId=$request->parent_id;
      	$insert->save();

        return redirect('getAccountHeads');   // redirect to MAIN list

    }

       // for updating a record   used for edit

    public function UpdateAccountHead(Request $request){
        
  
        $this->validate($request, [
            'acchead_code'=>'required',
            'acchead_name'=>'required',
            'type_id'=>'required'
            ]);

       // $user=Auth::user();
        $record= AccountHead::where('id','=',$request->acchead_id)->update([
        'name'         => $request->acchead_name,
        'code'         => $request->acchead_code,
        'accHeadTypeId'=> $request->type_id,
        'isTransactional'=> $request->is_tran=="on"?1:0,
     
        ]);

        return redirect('getAccountHeads');   // redirect to MAIN list

    }


}
