<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\AccountHead;

class AccountHeadController extends Controller
{

    public function GetAccountHeads(Request $request){
        
            
        $accountHeads = DB::select( DB::raw("SELECT acchead.id id,acchead.name name,accht.type type,				acchead.code code from accounthead acchead left JOIN             accountheadtypes accht on accht.id=acchead.accHeadTypeId"));

        return view('/AccountHead/acc_head_list')->with('accountHeads',$accountHeads);
    	
    }

    // for opening a new record form   used for add new record from

    public function GetAccountHeadForm(){

    	$types = DB::select( DB::raw("SELECT * from accountheadtypes Order By type") );

        return view('/AccountHead/acc_head_add', compact('types'));
        
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
            ]);

       // $user=Auth::user();
        $insert= new AccountHead;
        $insert->name=$request->acchead_name;
        $insert->code=$request->acchead_code;
        $insert->accHeadTypeId=$request->type_id;
        $insert->isTransactional=$request->is_tran;
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
        'isTransactional'=> $request->is_tran
     
        ]);

        return redirect('getAccountHeads');   // redirect to MAIN list

    }


}
