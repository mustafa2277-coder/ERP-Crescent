<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Journal;
use App\Project;
use App\AccountHead;
use App\JournalEntries;
use App\JournalEntryDetail;
use Auth;
use Response;
use PdfReport;
use PDF;
//use Illuminate\Pagination\Paginator;
use Redirect;
use Illuminate\Pagination\LengthAwarePaginator;

class JournalController extends Controller
{

    // for getting all journals

    public function GetJournals(Request $request){
        
        //======= Start Raw query =========//
            // $journals = DB::select( DB::raw("SELECT * from journal order by name"));
        //======= End Raw query =========//    
        
        $journals =  DB::table('journal')->orderBy('name')->get();

        return view('/Journal/journal_list')->with('journals',$journals);
    	
    }

    // for opening a new record form   used for add new record from

    public function GetJournalForm(){

        return view('/Journal/journal_add');
        
    }

    // for getiing a record against its id  used for editing a record
    public function GetJournalById($id){
       
       $record=Journal::find($id);

       return view('/Journal/journal_add', compact('record'));
       
    }

     // for inserting a record   used for add new record

    public function InsertJournal(Request $request){


        $this->validate($request, [
            'journal_name'=>'required|unique:journal,name',
            'voucher_prefix'=>'required|unique:journal,voucherprefix'
            ],

            ['journal_name.unique'  =>'Name Already exist',
             'voucher_prefix.unique'=>'Voucher Prefix Already exist',
                ]
            );

       // $user=Auth::user();
        $insert= new Journal;
        $insert->name          = $request->journal_name;
        $insert->voucherPrefix = $request->voucher_prefix;
      	$insert->save();

        return redirect('getJournals');   // redirect to MAIN list

    }

       // for updating a record   used for edit

    public function UpdateJournal(Request $request){
        
  
        $this->validate($request, [
            'journal_name'=>'required'
        ]);

        $record= Journal::where('id','=',$request->journal_id)->update([
        'name'         => $request->journal_name,
        'voucherPrefix'=> $request->voucher_prefix
        
        ]);

        return redirect('getJournals');   // redirect to MAIN list

    }

/*----------------------------------Journal Entry-------------------------------*/

    
    public function GetJournalEntriesListView(Request $request){    

        $journals =  DB::table('journal')->orderBy('name')->get();
        $customers=  DB::table('customers')->orderBy('name')->get();
        $projects =  DB::table('project')->orderBy('title')->get();
        $end   = date("d/m/Y");
        $start = date("d/m/Y");

        $journalentries = "";


        return view('/Journal/journal_entry_list_view',compact('journalentries','journals','end','start','projects','projectId','journalId','customers'));

    }


    public function GetFilterJournalEntriesList(Request $request){

        
        if($request->ajax())
        {

        $projectId = $request['filter_project'];
        $journalId = $request['filter_journal'];
        $end = $request['end_date'];
        $start = $request['start_date'];
        $journalentries = "";


        //filter by date
        if(empty($projectId) && empty($journalId) && (!empty($end)|| !empty($start))){

                
                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                ->groupBy('entryDate', 'id','entryNum','journal')
               // ->paginate(20); 
                ->get(); 

            $journalentries = $this->paginate($journalentries)->setPath('journalentries');

               ///return  $journalentries;//new Paginator($journalentries, 20);
        }

        //  filter by journal only

        if(empty($projectId) && !empty($journalId) && (empty($end)|| empty($start))){
          
                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->where('journalentries.journalId', '=', $journalId)
                ->groupBy('entryDate', 'id','entryNum','journal')
                ->get();
                $journalentries = $this->paginate($journalentries)->setPath('journalentries');  


        } 

        //  filter by project only   
        
        if(!empty($projectId) && empty($journalId) && (empty($end)|| empty($start))){
                $end = $request->end_date;
                $start = $request->start_date;
                $projectId = $request->filter_project;
                $journalId = $request->filter_journal;    

                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->where('journalentrydetail.projectId', '=', $projectId)
                ->groupBy('entryDate', 'id','entryNum','journal')
                ->get();
                $journalentries = $this->paginate($journalentries)->setPath('journalentries'); 


        }

        //  filter by jounral,project,date   

        if(!empty($projectId) && !empty($journalId) && (!empty($end)|| !empty($start))){


                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->where('journalentrydetail.projectId', '=', $projectId)
                ->where('journalentries.journalId', '=', $journalId)
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                ->groupBy('entryDate', 'id','entryNum','journal')
                ->get();
                $journalentries = $this->paginate($journalentries)->setPath('journalentries'); 

                //return $start;
        }




        //  filter by jounral and date

        if(empty($projectId) && !empty($journalId) && (!empty($end)|| !empty($start))){        

                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                
                ->where('journalentries.journalId', '=', $journalId)
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                ->groupBy('entryDate', 'id','entryNum','journal')
                ->get();
                $journalentries = $this->paginate($journalentries)->setPath('journalentries');  
 
        }

        //  filter by project and date

        if(!empty($projectId) && empty($journalId) && (!empty($end)|| !empty($start))){        

                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                
                ->where('journalentrydetail.projectId', '=', $projectId)
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                ->groupBy('entryDate', 'id','entryNum','journal')
                ->get();
                $journalentries = $this->paginate($journalentries)->setPath('journalentries');  

        }             
            

        
        $view =  view('/Journal/journal_entry_View/journal_entry_list',compact('journalentries','end','start','journalId','projectId'))->render();       

        return response($view);

        }
    }

    // public function GetJournalEntries(Request $request){
        
  
    //     //======= Start Raw query =========//
    //         // $journals = DB::select( DB::raw("SELECT * from journal Order By name") );
    //         // $projects = DB::select( DB::raw("SELECT * from project Order By title") );
    //     //======= End Raw query =========//
        
    //     $journals =  DB::table('journal')->orderBy('name')->get();
    //     $customers=  DB::table('customers')->orderBy('name')->get();
    //     $projects =  DB::table('project')->orderBy('title')->get();
    //     $journalentries = "";
        
    //     $projectId = $request->filter_project;
    //     $journalId = $request->filter_journal;
    //     $end = $request->end_date;
    //     $start = $request->start_date;



    //     // by default filter by today's date

    //     if(is_null($journalId) && is_null($projectId) && (!isset($end) || !isset($start))){

    //             $end   = date("d/m/Y");
    //             $start = date("d/m/Y");

               

    //             $journalentries = DB::table('journalentries')

    //             ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
    //             ->leftJoin('project', 'journalentrydetail.projectId', '=', 'project.id')
    //             ->join('journal', 'journalentries.journalId', '=', 'journal.id')
    //             ->select('journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

    //         )
    //             ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
    //             ->groupBy('entryDate', 'id','entryNum','project','journal')
    //             ->get(); 
           
    //     }

    //     //  filter by date only
        
    //     if($request->filter_journal==0 && $request->filter_project==0 && ($request->end_date!='null' || $request->start_date!='null')){

                
    //             $journalentries = DB::table('journalentries')
    //             ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
    //             ->leftJoin('project', 'journalentrydetail.projectId', '=', 'project.id')
    //             ->join('journal', 'journalentries.journalId', '=', 'journal.id')
    //             ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

    //             )
    //             ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
    //             ->groupBy('entryDate', 'id','entryNum','project','journal')
    //             ->get(); 


    //     }

    //     //  filter by journal only

    //     if($request->filter_journal!=0 && $request->filter_project==0 && (!isset($request->end_date) || !isset($request->start_date))){
          
    //             $journalentries = DB::table('journalentries')
    //             ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
    //             ->leftJoin('project', 'journalentrydetail.projectId', '=', 'project.id')
    //             ->join('journal', 'journalentries.journalId', '=', 'journal.id')
    //             ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

    //             )
    //             ->where('journalentries.journalId', '=', $request->journal)
    //             ->groupBy('entryDate', 'id','entryNum','project','journal')
    //             ->get(); 


    //     } 

    //     //  filter by project only   
        
    //     if($request->filter_journal==0 && $request->filter_project!=0 && (!isset($request->end_date) || !isset($request->start_date))){
    //             $end = $request->end_date;
    //             $start = $request->start_date;
    //             $projectId = $request->filter_project;
    //             $journalId = $request->filter_journal;    

    //             $journalentries = DB::table('journalentries')
    //             ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
    //             ->leftJoin('project', 'journalentrydetail.projectId', '=', 'project.id')
    //             ->join('journal', 'journalentries.journalId', '=', 'journal.id')
    //             ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

    //             )
    //             ->where('journalentries.projectId', '=', $projectId)
    //             ->groupBy('entryDate', 'id','entryNum','project','journal')
    //             ->get(); 


    //     }

    //     //  filter by jounral,project,date   

    //     if($request->filter_journal!=0 && $request->filter_project!=0 && (isset($request->end_date) || isset($request->start_date))){


    //             $journalentries = DB::table('journalentries')
    //             ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
    //             ->leftJoin('project', 'journalentrydetail.projectId', '=', 'project.id')
    //             ->join('journal', 'journalentries.journalId', '=', 'journal.id')
    //             ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

    //             )
    //             ->where('journalentries.projectId', '=', $projectId)
    //             ->where('journalentries.journalId', '=', $journalId)
    //             ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
    //             ->groupBy('entryDate', 'id','entryNum','project','journal')
    //             ->get(); 


    //     }




    //     //  filter by jounral and date

    //     if($request->filter_journal!=0 && $request->filter_project==0 && (isset($request->end_date) || isset($request->start_date))){

                

    //             $journalentries = DB::table('journalentries')
    //             ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
    //             ->leftJoin('project', 'journalentrydetail.projectId', '=', 'project.id')
    //             ->join('journal', 'journalentries.journalId', '=', 'journal.id')
    //             ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

    //             )
                
    //             ->where('journalentries.journalId', '=', $journalId)
    //             ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
    //             ->groupBy('entryDate', 'id','entryNum','project','journal')
    //             ->get(); 

 
    //     }

    //     //  filter by project and date

    //     if($request->filter_journal==0 && $request->filter_project!=0 && (isset($request->end_date) || isset($request->start_date))){

                

    //             $journalentries = DB::table('journalentries')
    //             ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
    //             ->leftJoin('project', 'journalentrydetail.projectId', '=', 'project.id')
    //             ->join('journal', 'journalentries.journalId', '=', 'journal.id')
    //             ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

    //             )
                
    //             ->where('journalentrydetail.projectId', '=', $projectId)
    //             ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
    //             ->groupBy('entryDate', 'id','entryNum','project','journal')
    //             ->get(); 

    //     }             
            
    //     return view('/Journal/journal_entry_list',compact('journalentries','journals','end','start','projects','projectId','journalId','customers'));  
    // }

     public function GetJournalEntriesByDate(Request $request){

        $end   = $request->end_date;
        $start = $request->start_date;

        
        $journalentries = DB::table('journalentries')

        ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
        ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
        ->join('journal', 'journalentries.journalId', '=', 'journal.id')
        ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'
                )
        ->where('journalentries.date_post', '>=', date("Y-m-d",strtotime(str_replace('/', '-', $start))))
        ->where('journalentries.date_post', '<=', date("Y-m-d",strtotime(str_replace('/', '-', $end))))
        ->distinct()
        ->paginate(1); 



        return view('/Journal/journal_entry_list',compact('journalentries','end','start'));
        
    }

    // for opening a new record form   used for add new record from

    public function GetJournalEntryForm(){

        //======= Start Raw query =========//
        //$journals = DB::select( DB::raw("SELECT * from journal Order By name") );
        //$accounts = DB::select( DB::raw("SELECT * from accounthead where isTransactional=1 or  isTransactional is null Order By name") );
       //$projects = DB::select( DB::raw("SELECT * from project Order By title") );
        //======= End Raw query =========//
        
        $journals =  DB::table('journal')->orderBy('name')->get();
        $accounts =  DB::table('accounthead')->where('accounthead.isTransactional','=',1)->orwhere('accounthead.isTransactional','=',null)->orderBy('name')->get();
        $projects =  DB::table('project')->orderBy('title')->get();

        
        
        return view('/Journal/journal_entry_add', compact('journals','accounts','projects'));
        
    }
/*-----------------------------------------------------------------------OLD INSERTION FUNCTION------------------------------------------------------------------*/
    public function InsertJournalEntry(Request $request){
        //return $request;

        $journal = DB::table('journal')->where('id',$request->journalId)->first();

        $entryNumber =  $this->GenerateJournalEntryNum(strtoupper($journal->voucherPrefix));
 

         

        $journalEntry = new JournalEntries;
       
        $journalEntry->journalId = $request->journalId;
        $journalEntry->date_post = date("Y-m-d",strtotime(str_replace('/', '-', $request->datePost))); 
        $journalEntry->reference = $request->reference;
        $journalEntry->entryNum  = $entryNumber;
        $journalEntry->projectid = $request->projectId;
        $journalEntry->save();

        // generate entry number  or voucher number    
        //$entryNumber.="/".date('Y')."/".$journalEntry->id;

        // JournalEntries::where('id','=',$journalEntry->id)->update([
        // 'entryNum'         => $entryNumber
        
        // ]);

         for ($i=0; $i <sizeof($request->entryDetail) ; $i++) { 
            if($request->entryDetail[$i]['debit'] == 0){
               $isDebit = false;
               $amount = $request->entryDetail[$i]['credit'];
            }
            else{
               $isDebit = true;
               $amount = $request->entryDetail[$i]['debit'];
               
            }
                
            $dataSet[$i] = [
                            'amount'         => $amount,
                            
                            'journalEntryid' => $journalEntry->id,
                            'accHeadId'      => $request->entryDetail[$i]['accountId'],
                            'isDebit'        => $isDebit
                        ];
            }
        
            JournalEntryDetail::insert($dataSet);


        return Response::json(['message'=>'inserted'],201);
       
    }
/*-----------------------------------------------------------------------END OLD INSERTION FUNCTION--------------------------------------------------------------*/

/*-------------------------------------------------------------------------NEW INSERTION FUNCTION----------------------------------------------------------------*/
public function InsertNJournalEntry(Request $request){
    $user=Auth::user();

        $journal = DB::table('journal')->where('id',$request->journalId)->first();

        $entryNumber =  $this->GenerateJournalEntryNum(strtoupper($journal->voucherPrefix));
 

         

        $journalEntry = new JournalEntries;
       
        $journalEntry->journalId = $request->journalId;
        $journalEntry->date_post = date("Y-m-d",strtotime(str_replace('/', '-', $request->datePost))); 
        $journalEntry->reference = $request->reference;
        $journalEntry->entryNum  = $entryNumber;
        $journalEntry->projectid = $request->projectId;
        $journalEntry->createdBy = $user->name;
        $journalEntry->save();

        // generate entry number  or voucher number    
        //$entryNumber.="/".date('Y')."/".$journalEntry->id;

        // JournalEntries::where('id','=',$journalEntry->id)->update([
        // 'entryNum'         => $entryNumber
        
        // ]);
            //return $request->credit;
            for ($i=0; $i <$request->rowTotal; $i++){
                if($request->debit[$i]== 0){
                    $isDebit = false;
                    $amount = $request->credit[$i];
                 }
                
                if($request->credit[$i]== 0){
                    $isDebit = true;
                    $amount = $request->debit[$i];
                 }
                $account=$request->acc[$i];

                $dataSet[$i] = [
                    'amount'         => $amount,
                    
                    'journalEntryid' => $journalEntry->id,
                    'accHeadId'      => $account,
                    'isDebit'        => $isDebit
                ];
    
                
            }
            
            JournalEntryDetail::insert($dataSet); 
        
         /* for ($i=0; $i <sizeof($request->entryDetail) ; $i++) { 
            if($request->entryDetail[$i]['debit'] == 0){
               $isDebit = false;
               $amount = $request->entryDetail[$i]['credit'];
            }
            else{
               $isDebit = true;
               $amount = $request->entryDetail[$i]['debit'];
               
            }
                
            $dataSet[$i] = [
                            'amount'         => $amount,
                            
                            'journalEntryid' => $journalEntry->id,
                            'accHeadId'      => $request->entryDetail[$i]['accountId'],
                            'isDebit'        => $isDebit
                        ];
            }
        
            JournalEntryDetail::insert($dataSet);
         */

        return Response::json(['message'=>'inserted'],201);
   
}


/*-----------------------------------------------------------------------END NEW INSERTION FUNCTION--------------------------------------------------------------*/
public function GetJournalEntries($id){
//return $id;
$entry=JournalEntries::find($id);
/* $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                ->groupBy('entryDate', 'id','entryNum','journal')
               // ->paginate(20); 
                ->get(); */

return $entry;
}
/*----------------------------------Journal Item-------------------------------*/

    // for getting all journal items

    public function GetJournalItems(){
        
        //======= Start Raw query =========//
        // $journalItems = DB::select( DB::raw("SELECT  je.date_post entryDate,je.id id,je.entryNum entryNum,jed.amount amount,pj.title project,j.name journal,ac.name account,jed.isDebit isDebit  from journalentries je
        //             join journalentrydetail jed on jed.journalEntryId = je.id 
        //             left join project pj on pj.id = je.projectId
        //             join journal j on j.id = je.journalId
        //             join accounthead ac on ac.id= jed.accHeadId
        //             "));
        //======= End Raw query =========//  
    
    $journalItems = DB::table('journalentries')

        ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
        ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
        ->join('journal', 'journalentries.journalId', '=', 'journal.id')
        ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')

        ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','accounthead.name as account','journalentrydetail.isDebit as isDebit'

            )
        ->paginate(30);

  

        return view('/Journal/journal_item_list')->with('journalItems',$journalItems);
   
    }


    public function GetProjectsByCustomerId(Request $request){
        

        $projects =  DB::table('project')
                    ->where('customerId','=',$request->id)
                    ->orderBy('title')
                    ->get();

        
        
        return $projects;
        
    }




    

    protected function paginate($items, $perPage = 12)
    {
        //Get current page form url e.g. &page=1
        $currentPage =  LengthAwarePaginator::resolveCurrentPage();

        //Slice the collection to get the items to display in current page
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);

        //Create our paginator and pass it to the view
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }


    public function GenerateJournalEntryNum($prefix)
    {


    $currentMonth  = date('m');
    $currentYear   = date('Y');
    $currentPrefix = $prefix;


    $estmEntryNum  =  $currentPrefix."/".$currentMonth."/".$currentYear;
    
    $journalEntry =  DB::table('journalentries')
                        ->select('journalentries.entryNum')
                         ->where('entryNum','LIKE','%'.$estmEntryNum.'%')
                         ->orderby('id','desc')
                         ->first(); 
/* return $journalEntry; */

    if($journalEntry != null){
        $rest = substr($journalEntry->entryNum, 12);
        $genEntryNum = $estmEntryNum."/".(intVal($rest) + 1);
       /*  var_dump($journalEntry);
        exit(); */
    }

    else
    {

        $genEntryNum =  $estmEntryNum."/1";  
    }
    
    return $genEntryNum;

    }
/*--------------------------------------------------------------------Print Journal Entries PDF--------------------------------------------------------------------------- */
    public function GetJournalPdf(Request $request){
        //return $request->start;
        

            $projectId = $request->projectId;
            $journalId = $request->journalId;
            $end = $request->end;
            $start = $request->start;
            $journalentries = "";


            //filter by date
            if(empty($projectId) && empty($journalId) && (!empty($end)|| !empty($start))){

                    
                    $journalentries = DB::table('journalentries')
                    ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                    ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                    ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                    ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                    )
                    ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                    ->groupBy('entryDate', 'id','entryNum','journal')
                // ->paginate(20); 
                    ->get(); 
                //$journalentries = $this->paginate($journalentries)->setPath('journalentries');
                $pdf = PDF::loadView('pdfTemplate',compact('journalentries','end','start'));
                return $pdf->stream();

                ///return  $journalentries;//new Paginator($journalentries, 20);
            }

            //  filter by journal only

            if(empty($projectId) && !empty($journalId) && (empty($end)|| empty($start))){
            
                    $journalentries = DB::table('journalentries')
                    ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                    ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                    ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                    ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                    )
                    ->where('journalentries.journalId', '=', $journalId)
                    ->groupBy('entryDate', 'id','entryNum','journal')
                    ->get();
                   // $journalentries = $this->paginate($journalentries)->setPath('journalentries'); 
                   $pdf = PDF::loadView('pdfTemplate',compact('journalentries','end','start'));
                    return $pdf->stream();


            } 

            //  filter by project only   
            
            if(!empty($projectId) && empty($journalId) && (empty($end)|| empty($start))){
                   

                    $journalentries = DB::table('journalentries')
                    ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                    ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                    ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                    ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                    )
                    ->where('journalentrydetail.projectId', '=', $projectId)
                    ->groupBy('entryDate', 'id','entryNum','journal')
                    ->get();
                   // $journalentries = $this->paginate($journalentries)->setPath('journalentries'); 
                   $pdf = PDF::loadView('pdfTemplate',compact('journalentries','end','start'));
                    return $pdf->stream();


            }

            //  filter by jounral,project,date   

            if(!empty($projectId) && !empty($journalId) && (!empty($end)|| !empty($start))){


                    $journalentries = DB::table('journalentries')
                    ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                    ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                    ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                    ->select('journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                    )
                    ->where('journalentrydetail.projectId', '=', $projectId)
                    ->where('journalentries.journalId', '=', $journalId)
                    ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                    ->groupBy('entryDate', 'id','entryNum','journal')
                    ->get();
                  //  $journalentries = $this->paginate($journalentries)->setPath('journalentries'); 
                  $pdf = PDF::loadView('pdfTemplate',compact('journalentries','end','start'));
                    return $pdf->stream();

                    //return $start;
            }




            //  filter by jounral and date

            if(empty($projectId) && !empty($journalId) && (!empty($end)|| !empty($start))){        

                    $journalentries = DB::table('journalentries')
                    ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                    ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                    ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                    ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                    )
                    
                    ->where('journalentries.journalId', '=', $journalId)
                    ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                    ->groupBy('entryDate', 'id','entryNum','journal')
                    ->get();
                  //  $journalentries = $this->paginate($journalentries)->setPath('journalentries');  
                  $pdf = PDF::loadView('pdfTemplate',compact('journalentries','end','start'));
                    return $pdf->stream();
    
            }

            //  filter by project and date

            if(!empty($projectId) && empty($journalId) && (!empty($end)|| !empty($start))){        

                    $journalentries = DB::table('journalentries')
                    ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                    ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                    ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                    ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                    )
                    
                    ->where('journalentrydetail.projectId', '=', $projectId)
                    ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                    ->groupBy('entryDate', 'id','entryNum','journal')
                    ->get();
                  //  $journalentries = $this->paginate($journalentries)->setPath('journalentries');  

                  $pdf = PDF::loadView('pdfTemplate',compact('journalentries','end','start'));
                    return $pdf->stream();

            }             
                

            

        
        //return 'helo';

    }
/*--------------------------------------------------------------------End Print Journal Entries PDF--------------------------------------------------------------------------- */

/*--------------------------------------------------------------------Print Journal Vouchers PDF--------------------------------------------------------------------------- */
public function GetVoucherPdf(Request $request){
    //return $request->start;
    

        $projectId = $request->projectId;
        $journalId = $request->journalId;
        $end = $request->end;
        $start = $request->start;
        $journalentries = "";


        //filter by date
        if(empty($projectId) && empty($journalId) && (!empty($end)|| !empty($start))){

                

                
                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->select('accounthead.name as head','accounthead.code','journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','journalentrydetail.isDebit as isDebit')
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                /* ->groupBy('entryDate', 'id','entryNum','journal') */
            // ->paginate(20); 
                ->get(); 
            //return view('/Journal/printBlade/jEPrint',compact('journalentries','end','start'));
            //$journalentries = $this->paginate($journalentries)->setPath('journalentries');
            $pdf = PDF::loadView('/Journal/printBlade/jEPrint',compact('journalentries','end','start'));
            return $pdf->stream();

            ///return  $journalentries;//new Paginator($journalentries, 20);
        }

        //  filter by journal only

        if(empty($projectId) && !empty($journalId) && (empty($end)|| empty($start))){
        
                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->select('accounthead.name as head','accounthead.code','journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','journalentrydetail.isDebit as isDebit')
                ->where('journalentries.journalId', '=', $journalId)
                /* ->groupBy('entryDate', 'id','entryNum','journal') */
                ->get();
               // $journalentries = $this->paginate($journalentries)->setPath('journalentries'); 
               $pdf = PDF::loadView('/Journal/printBlade/jEPrint',compact('journalentries','end','start'));
                return $pdf->stream();


        } 

        //  filter by project only   
        
        if(!empty($projectId) && empty($journalId) && (empty($end)|| empty($start))){
               
            $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->select('accounthead.name as head','accounthead.code','journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','journalentrydetail.isDebit as isDebit')
                ->where('journalentrydetail.projectId', '=', $projectId)
                /* ->groupBy('entryDate', 'id','entryNum','journal') */
                ->get();
               // $journalentries = $this->paginate($journalentries)->setPath('journalentries'); 
               $pdf = PDF::loadView('/Journal/printBlade/jEPrint',compact('journalentries','end','start'));
                return $pdf->stream();


        }

        //  filter by jounral,project,date   

        if(!empty($projectId) && !empty($journalId) && (!empty($end)|| !empty($start))){


                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->select('accounthead.name as head','accounthead.code','journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','journalentrydetail.isDebit as isDebit')
                ->where('journalentrydetail.projectId', '=', $projectId)
                ->where('journalentries.journalId', '=', $journalId)
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                /* ->groupBy('entryDate', 'id','entryNum','journal') */
                ->get();
              //  $journalentries = $this->paginate($journalentries)->setPath('journalentries'); 
              $pdf = PDF::loadView('/Journal/printBlade/jEPrint',compact('journalentries','end','start'));
                return $pdf->stream();

                //return $start;
        }




        //  filter by jounral and date

        if(empty($projectId) && !empty($journalId) && (!empty($end)|| !empty($start))){        
            $journalentries = DB::table('journalentries')
            ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
            ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')
            ->join('journal', 'journalentries.journalId', '=', 'journal.id')
            ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
            ->select('accounthead.name as head','accounthead.code','journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','journalentrydetail.isDebit as isDebit')
                
                ->where('journalentries.journalId', '=', $journalId)
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                /* ->groupBy('entryDate', 'id','entryNum','journal') */
                ->get();
              //  $journalentries = $this->paginate($journalentries)->setPath('journalentries');  
              $pdf = PDF::loadView('/Journal/printBlade/jEPrint',compact('journalentries','end','start'));
                return $pdf->stream();

        }

        //  filter by project and date

        if(!empty($projectId) && empty($journalId) && (!empty($end)|| !empty($start))){        

                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->select('accounthead.name as head','accounthead.code','journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','journalentrydetail.isDebit as isDebit')
                
                ->where('journalentrydetail.projectId', '=', $projectId)
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                /* ->groupBy('entryDate', 'id','entryNum','journal') */
                ->get();
              //  $journalentries = $this->paginate($journalentries)->setPath('journalentries');  

              $pdf = PDF::loadView('/Journal/printBlade/jEPrint',compact('journalentries','end','start'));
                return $pdf->stream();

        }             
            

        

    
    //return 'helo';

}
/*--------------------------------------------------------------------End Print Journal Vouchers PDF--------------------------------------------------------------------------- */

    
/*--------------------------------------------------------------------Print Journal Items PDF--------------------------------------------------------------------------- */
public function GetJournalItemsPdf(Request $request){

    $journalItems = DB::table('journalentries')

        ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
        ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
        ->join('journal', 'journalentries.journalId', '=', 'journal.id')
        ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')

        ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','accounthead.name as account','journalentrydetail.isDebit as isDebit'

            )
        ->get();

        $pdf = PDF::loadView('pdfJournalItem',compact('journalItems'));
        return $pdf->stream();

       // return view('/Journal/journal_item_list')->with('journalItems',$journalItems);

}

/*--------------------------------------------------------------------End Print Journal Items PDF--------------------------------------------------------------------------- */

/*---------------------------------------------------------------Print Journal Entries before submission-------------------------------------------------------------------- */
public function jprint(Request $request){

    $user=Auth::user();
    $user=$user->name;
    $debit=[];
    $credit=[];
    $acc=[];
    $accCode=[];
    $journal="";
    $project="";
    $date="";
    $ref="";
    $totalCredit="";
    $totalDebit="";
    /* return $request->creditAmt; */

    $rows=$request->rowTotal;
    //return $rows;
    for($i=1;$i<=$rows;$i++){
        if(isset($request->acc[$i])){

            $account=AccountHead::where('id',$request->acc[$i])->get();
            $acc[$i-1]=$account[0]->name;
            $accCode[$i-1]=$account[0]->code;
            $debit[$i-1]=$request->debit[$i];
            $credit[$i-1]=$request->credit[$i];
        }
        else{
            
            $acc[$i-1]="none";
            $accCode[$i-1]="none";
            $debit[$i-1]="none";
            $credit[$i-1]="none";
        }
    }
    //return [$debit,$credit,$acc];
    $proj=Project::find($request->project_id);
    $project=$proj->title;

    $jour=Journal::find($request->journal_id);
    $journal=$jour->name;

    $date=$request->pdate;
    $ref=$request->reference;
    $totalCredit=$request->creditAmt;
    $totalDebit=$request->debitAmt;

    //return $proj;
    //return [$debit,$credit,$acc,$journal,$project,$date,$ref,$totalCredit,$totalDebit];
    //return $rows;
    $pdf = PDF::loadView('/Journal/printBlade/jEPrint',compact('debit','credit','acc','journal','project','date','ref','totalCredit','totalDebit','rows','accCode','user'));
                    return $pdf->stream();
    //return view('/Journal/printBlade/jEPrint',compact('debit','credit','acc','journal','project','date','ref','totalCredit','totalDebit','rows','accCode'));
}

/*----------------------------------------------------------End Print Journal Entries before submission---------------------------------------------------------------------- */


}
