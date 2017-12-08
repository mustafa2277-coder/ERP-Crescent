<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\AccountHead;

class AccountHeadController extends Controller
{

    public function GetAccountHeads(Request $request){
        
            
       // $accountHeads=AccountHead::orderBy('id','DESC')->get();
       $accountHeads = DB::select( DB::raw("SELECT acchead.name name,accht.type type,acchead.code code from accounthead acchead 
        left JOIN accountheadtypes accht on accht.id=acchead.accHeadTypeId"));

      // $accountHeads = DB::select( DB::raw("SELECT name from accounthead"));
       
       return view('/AccountHead/acc_head_list')->with('accountHeads',$accountHeads);
      //   return view('/AccountHead/acc_head_list');

    }


}
