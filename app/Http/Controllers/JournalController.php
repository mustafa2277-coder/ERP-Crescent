<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Journal;
use App\JournalEntries;
use App\JournalEntryDetail;
use Response;
use Illuminate\Pagination\Paginator;
use Redirect;


class JournalController extends Controller
{

    // for getting all journals

    public function GetJournals(Request $request){
        
            
        $journals = DB::select( DB::raw("SELECT * from journal order by name"));

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

       // $user=Auth::user();
        $record= Journal::where('id','=',$request->journal_id)->update([
        'name'         => $request->journal_name,
        'voucherPrefix'=> $request->voucher_prefix
        
        ]);

        return redirect('getJournals');   // redirect to MAIN list

    }

/*----------------------------------Journal Entry-------------------------------*/



    public function GetJournalEntries(Request $request){
        
    
        // $journalentries = DB::select( DB::raw("SELECT distinct je.date_post entryDate,je.id id,je.entryNum entryNum,jed.amount amount,pj.title project,j.name journal from journalentries je
        //             join journalentrydetail jed on jed.journalEntryId = je.id 
        //             left join project pj on pj.id = je.projectId
        //             join journal j on j.id = je.journalId
        //             "));
// if(isset($request->id)){
//return $request->selection;
        $journals = DB::select( DB::raw("SELECT * from journal Order By name") );
        $projects = DB::select( DB::raw("SELECT * from project Order By title") );
// }
        switch ($request->selection) {
            case 0:
//return $request->selection;
                $end   = null;
                $start = null;
                $selection = 0;

                $journalentries = DB::table('journalentries')

                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

            )
                ->distinct()
                ->get(); 
                
                //return redirect('getJournalEntries');
              
                return view('/Journal/journal_entry_list',compact('journalentries','end','start','selection','journals','projects'));
                break;
            case 1:
            //return $request->selection;
             
                $end = $request->end_date;
                $start = $request->start_date;
                $selection = 1;
                
                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->where('journalentries.date_post', '>=', date("Y-m-d",strtotime(str_replace('/', '-', $start))))
                ->where('journalentries.date_post', '<=', date("Y-m-d",strtotime(str_replace('/', '-', $end))))
                ->distinct()
                ->get(); 



                return view('/Journal/journal_entry_list',compact('journalentries','end','start','selection','journals','projects'));  
                break;
            case 2: 
                $end = null;
                $start = null;
                $selection = 2;
                $journalId = $request->journal;  

                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->where('journalentries.journalId', '=', $request->journal)
                ->distinct()
                ->get(); 



                return view('/Journal/journal_entry_list',compact('journalentries','selection','journals','journalId','projects'));  
                break; 
             case 3: 
                $end = null;
                $start = null;
                $selection = 3;
                $projectId = $request->project;  

                $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->where('journalentries.projectId', '=', $projectId)
                ->distinct()
                ->get(); 



                return view('/Journal/journal_entry_list',compact('journalentries','selection','journals','projects','projectId'));  
                break;          
            
            default:
           
                $end   = null;
                $start = null;
                $selection = 0;

                $journalentries = DB::table('journalentries')

                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

            )
                ->distinct()
                ->get();
                
               // return redirect('getJournalEntries');
                return view('/Journal/journal_entry_list',compact('journalentries','end','start','selection','journals'));
                break;
                
        }
      
    



        
    }

     public function GetJournalEntriesByDate(Request $request){

       // return $request->api_url;
        $end = $request->end_date;
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

        $journals = DB::select( DB::raw("SELECT * from journal Order By name") );
        $accounts = DB::select( DB::raw("SELECT * from accounthead Order By name") );
        $projects = DB::select( DB::raw("SELECT * from project Order By title") );
        
        return view('/Journal/journal_entry_add', compact('journals','accounts','projects'));
        
    }

    public function InsertJournalEntry(Request $request){
        

        $journal = DB::table('journal')->where('id',$request->journalId)->first();

        $entryNumber =  strtoupper($journal->voucherPrefix);

        $journalEntry = new JournalEntries;
       
        $journalEntry->journalId = $request->journalId;
        $journalEntry->date_post = date("Y-m-d",strtotime(str_replace('/', '-', $request->datePost))); 
        $journalEntry->reference = $request->reference;
        $journalEntry->save();

        // generate entry number  or voucher number    
        $entryNumber.="/".date('Y')."/".$journalEntry->id;

        JournalEntries::where('id','=',$journalEntry->id)->update([
        'entryNum'         => $entryNumber
        
        ]);

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
                            'projectId'      => $request->entryDetail[$i]['projectId'],
                            'journalEntryid' => $journalEntry->id,

                            'accHeadId'      => $request->entryDetail[$i]['accountId'],
                            'isDebit'        => $isDebit
                        ];
            }
        
            JournalEntryDetail::insert($dataSet);


        return Response::json(['message'=>'inserted'],201);
       
    }

    /*----------------------------------Journal Item-------------------------------*/

    // for getting all journal items

    public function GetJournalItems(){
        
            
        // $journalItems = DB::select( DB::raw("SELECT  je.date_post entryDate,je.id id,je.entryNum entryNum,jed.amount amount,pj.title project,j.name journal,ac.name account,jed.isDebit isDebit  from journalentries je
        //             join journalentrydetail jed on jed.journalEntryId = je.id 
        //             left join project pj on pj.id = je.projectId
        //             join journal j on j.id = je.journalId
        //             join accounthead ac on ac.id= jed.accHeadId
        //             "));


         $journalItems = DB::table('journalentries')

        ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
        ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
        ->join('journal', 'journalentries.journalId', '=', 'journal.id')
        ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')

        ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','accounthead.name as account','journalentrydetail.isDebit as isDebit'

    )
        ->paginate(30);
    

        return view('/Journal/journal_item_list')->with('journalItems',$journalItems);
         // return $journalItems;
    }


}
