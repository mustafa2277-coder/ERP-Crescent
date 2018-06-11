<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\AccountHead;
use PDF;
use App\Providers\fpdf;
use Illuminate\Support\Facades\Route;
class AccountHeadController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:acc-manage|admin');
       //$this->middleware('role:admin');
    }
    public function GetAccountHeads(Request $request){
        
        $arr=null;

        //======= Start Raw query =========//

            // $accountHeads2 = DB::select( DB::raw("
            //             SELECT aha.name,aha.code code ,aha.id id,aha.isTransactional isTrans  FROM accounthead aha
            //             WHERE aha.`parentId` = 0 OR aha.`parentId`IS NULL"));

        //======= End Raw query =========//
        $accountHeads2 =  DB::table('accounthead')
                            ->select('accounthead.*','accounthead.name as name','accounthead.code as code','accounthead.id as id','accounthead.isTransactional as isTrans')
                            ->where('accounthead.parentId', '=', 0)
                            ->orWhere('accounthead.parentId', '=', NULL)
                            ->get(); 

        foreach($accountHeads2 as $item){

            if($item->isTrans!=1)    

                $addNew = '<a   style="float: right; " id="addew" href="'. URL('/addAccountHead').'/'.$item->id.'"> <i class="material-icons"  title="Add Sub Head">add_circle_outline</i></a>';
                else
                $addNew = "";    

                $edit = '<a  style="float: right; " href="'.URL('/editAccountHead').'/'.$item->id.'"><i class="material-icons" title="Edit Head">mode_edit</i></a>';
               
                $arr.='<li class="dd-item" data-id="'.$item->id.'"><div class="dd-handle">'.$item->code." " .$item->name.$addNew.$edit.'  </div>'.$this->GetTreeAccountHeads($item).'</li>';

        }


        return view('/AccountHead/acc_head_list',compact('arr'));//,'accountHeads3'));
    	
    }


    public function GetTreeAccountHeads($parent){

    $arr=null;  
    //======= Start Raw query =========//

         // $accountHeads2 = DB::select( DB::raw("
                    // SELECT * from accounthead where parentId=".$parent->id));
    
    //======= End Raw query =========//
    $accountHeads2 =  DB::table('accounthead')->where('accounthead.parentId', '=', $parent->id)->get();

    if(count($accountHeads2)!=0){

        foreach($accountHeads2 as $item){

        if($item->isTransactional!=1)
        $addNew = '<a style="float:  right;" id="addew" href="'. URL('/addAccountHead').'/'.$item->id.'"> <i class="material-icons"   title="Add Sub Head">add_circle_outline</i></a>';
        else
        $addNew = "";    

        $edit = '<a style="float:  right;" href="'.URL('/editAccountHead').'/'.$item->id.'"><i class="material-icons" title="Edit Head">mode_edit</i></a>';    
        
         $arr .= '<ol class="dd-list"><li class="dd-item" data-id="'.$item->id.'"><div class="dd-handle">'.$item->code." " .$item->name. $addNew.$edit.'</div>'.$this->GetTreeAccountHeads($item).'</li></ol>';

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
        $tt=$request->acchead_code;
        $res1 = trim($tt,'_');
        $res2  = trim($res1,'-');
        $res3 = trim($res2,'_-');
       /*  $request->acchead_code=$res3; */
        //return $request->acchead_code;
        if(AccountHead::where('code','=',$res3)->exists())
        {


        return redirect()->back()->with('error','Code Already Exist');
            
        }
        $this->validate($request, [
            'acchead_name'=>'required',
            'type_id'=>'required'
            ]
        );

       // $user=Auth::user();
        $insert= new AccountHead;
        $insert->name=trim($request->acchead_name,"_");
        $insert->code=$res3;
        $insert->accHeadTypeId=$request->type_id;
        $insert->isTransactional=$request->is_tran=="on"?1:0;
        $insert->parentId=$request->parent_id;
      	$insert->openingBalance=$request->open_balance;
        $insert->save();

        return redirect('getAccountHeads');   // redirect to MAIN list

    }

       // for updating a record   used for edit

    public function UpdateAccountHead(Request $request){
       

    $tt =$request->acchead_code;
    $res1 = trim($tt,'_');
    $res2  = trim($res1,'-');
    $res3 = trim($res2,'_-');

  //  return $res3;


    if(AccountHead::where('code','=',$res3)->where('id','<>',$request->acchead_id)
          ->exists())
    {

       $this->validate($request, [
                'acchead_code'=>'required|unique:accounthead,code',
                'acchead_name'=>'required',
                'type_id'=>'required'
                ],
                ['acchead_name.unique'=>'Name Already exist',
                 'acchead_code.unique'=>'Code Already exist',
                ]);
        
    }

     if(DB::table('journalentrydetail')->where('accHeadId','=',$request->acchead_id)->exists() && empty($request->is_tran))
    {


     return redirect()->back()->with('error','isTransactional cannot be unchecked!');
        
    }
       
       //return $tt;
       
       
    
     $record= AccountHead::where('id','=',$request->acchead_id)->update([
        'name'         => $request->acchead_name,
        'code'         => $res3,
        'accHeadTypeId'=> $request->type_id,
        'isTransactional'=> isset($request->is_tran)?1:0,
        'openingBalance' => $request->open_balance,
     
        ]);

        return redirect('getAccountHeads');   // redirect to MAIN list

    }
    
    private function RemoveDashes($item){



        if(strpos($item,'_')){   
        $res1 = trim($item,'_');
        $res2  = trim($res1,'-');
        $res3 = trim($res2,'_-');
  
        $this->RemoveDashes($res3);
        }
        else{
//echo $item;
           return $item;

        }




    }
    public function GetAccountHeadsPdf(){

        $arr=null;

        //======= Start Raw query =========//

            // $accountHeads2 = DB::select( DB::raw("
            //             SELECT aha.name,aha.code code ,aha.id id,aha.isTransactional isTrans  FROM accounthead aha
            //             WHERE aha.`parentId` = 0 OR aha.`parentId`IS NULL"));

        //======= End Raw query =========//
        $accountHeads2 =  DB::table('accounthead')
                            ->select('accounthead.*','accounthead.name as name','accounthead.code as code','accounthead.id as id','accounthead.isTransactional as isTrans')
                            /* ->where('accounthead.parentId', '=', 0) */
                            ->where('accounthead.code', 'like', '0%')
                            ->orWhere('accounthead.code', 'like', '1%')
                            ->orWhere('accounthead.code', 'like', '2%')
                            /* ->orWhere('accounthead.code', 'like', '3%')
                            ->orWhere('accounthead.code', 'like', '4%')
                            ->orWhere('accounthead.code', 'like', '6%') */
                            /*->where('accounthead.code', 'like', '7%')
                            ->where('accounthead.code', 'like', '8%')
                            ->where('accounthead.code', 'like', '9%') */
                            /* ->orWhere('accounthead.parentId', '=', NULL) */
                            ->orderBy('code','asc')
                            ->get(); 

        foreach($accountHeads2 as $item){

            if($item->isTrans!=1)    

                $addNew = '<a   style="float: right; " id="addew" href="'. URL('/addAccountHead').'/'.$item->id.'"> <i class="material-icons"  title="Add Sub Head">add_circle_outline</i></a>';
                else
                $addNew = "";    

                $edit = '<a  style="float: right; " href="'.URL('/editAccountHead').'/'.$item->id.'"><i class="material-icons" title="Edit Head">mode_edit</i></a>';
               
                $arr.='<li class="dd-item" data-id="'.$item->id.'"><div class="dd-handle">'.$item->code." " .$item->name.'  </div>'.$this->GetTreeAccountHeadsPdf($item).'</li>';

        }
        //return $arr;
        $pdf = PDF::loadView('pdfTemplateAccountHead',compact('arr'));
        /* return $pdf->download('pdfTemplateAccountHead.pdf'); */
        return $pdf->download('pdfTemplateAccountHead.pdf');

       // return view('/AccountHead/acc_head_list',compact('arr'));//,'accountHeads3'));

    }

    public function GetTreeAccountHeadsPdf($parent){

        $arr=null;  
        //======= Start Raw query =========//
    
             // $accountHeads2 = DB::select( DB::raw("
                        // SELECT * from accounthead where parentId=".$parent->id));
        
        //======= End Raw query =========//
        $accountHeads2 =  DB::table('accounthead')->where('accounthead.parentId', '=', $parent->id)->get();
    
        if(count($accountHeads2)!=0){
    
            foreach($accountHeads2 as $item){
    
            if($item->isTransactional!=1)
            $addNew = '<a style="float:  right;" id="addew" href="'. URL('/addAccountHead').'/'.$item->id.'"> <i class="material-icons"   title="Add Sub Head">add_circle_outline</i></a>';
            else
            $addNew = "";    
    
            $edit = '<a style="float:  right;" href="'.URL('/editAccountHead').'/'.$item->id.'"><i class="material-icons" title="Edit Head">mode_edit</i></a>';    
            
             $arr .= '<ul class="dd-list"><li class="dd-item" data-id="'.$item->id.'"><div class="dd-handle">'.$item->code." " .$item->name.'</div>'.$this->GetTreeAccountHeadsPdf($item).'</li></ul>';
    
            }
            return $arr;
        }else{
    
            return  ; 
    
    
        }
    
    
    
    }







    /*-------------------------------------------Testing PDF with FPDF-------------------------------------------------*/

    public function GetTestPdf(Request $request){

        //$pdf = new Fpdf::();
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(40,10,'Hello World!');
        $pdf->Output();
        
        /* $journalItems = DB::table('journalentries')
    
            ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
            ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
            ->join('journal', 'journalentries.journalId', '=', 'journal.id')
            ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')
    
            ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','accounthead.name as account','journalentrydetail.isDebit as isDebit'
    
                )
            ->get();
    
            $pdf = PDF::loadView('pdfJournalItem',compact('journalItems'));
            return $pdf->stream(); */
    
           // return view('/Journal/journal_item_list')->with('journalItems',$journalItems);
    
    }


}
