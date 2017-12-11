<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Journal;
use App\JournalEntries;
use App\JournalEntryDetail;

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
            'journal_name'=>'required|unique:journal,name'
            ]);

       // $user=Auth::user();
        $insert= new Journal;
        $insert->name=$request->journal_name;
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
        'name'         => $request->journal_name
        
        ]);

        return redirect('getJournals');   // redirect to MAIN list

    }

/*----------------------------------Journal Entry---------------------------------------*/

    // for getting all journal entries

    public function GetJournalEntries(Request $request){
        
            
        $journalentries = DB::select( DB::raw("SELECT distinct je.date_post entryDate,je.id id,jed.amount amount,pj.title project,j.name journal from journalentries je
                    join journalentrydetail jed on jed.journalEntryId = je.id 
                    left join project pj on pj.id = je.projectId
                    join journal j on j.id = je.journalId
                    "));

        return view('/Journal/journal_entry_list')->with('journalentries',$journalentries);
        
    }

    // for opening a new record form   used for add new record from

    public function GetJournalEntryForm(){

        $journals = DB::select( DB::raw("SELECT * from journal Order By name") );
        
        return view('/Journal/journal_entry_add', compact('journals'));
        
    }


}
