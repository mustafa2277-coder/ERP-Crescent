<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use DB;
use App\User;
use App\Journal;
use App\JournalEntries;
use App\JournalEntryDetail;
use Response;
use Redirect;


class ReportController extends Controller
{

    // for getting all journals

    public function GetGeneralLedger(Request $request){
        
        //$generalLedger = [];

        //$ledger =  DB::table('accounthead')->orderBy('name')->get();

        $ledgers =  DB::select( DB::raw("SELECT acch.name,jed.`isDebit`,je.`entryNum`,je.`date_post`                        ,pj.title project,
                                    ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                    ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                    FROM journalentrydetail jed
                                    JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                    JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                    LEFT JOIN project pj ON pj.id = je.projectId
                                    GROUP BY acch.name,jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project
                                    ORDER BY acch.`name`,je.date_post") 
                        );


        $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.code FROM `accounthead` acch2
                                    JOIN (SELECT acch.name,jed.`isDebit`,je.`entryNum`,je.`date_post`,
                                    ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                    ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                     FROM journalentrydetail jed
                                    JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                    JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                    GROUP BY acch.name,jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,acch.code
                                    ORDER BY acch.`name`,je.date_post) acc ON acch2.name=acc.name
                                    GROUP BY acch2.name,acch2.code
                                    ORDER BY acch2.name")
                            );
     

        return view('/Reports/report_general_ledger',compact('ledgers','ledgerAccounts'));
    	
    }

    

}
