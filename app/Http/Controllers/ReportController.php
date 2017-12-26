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

        $ledgers =  DB::select( DB::raw("SELECT acch.name,jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,
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

    public function GetJournalEntryByEntrynum(Request $request){
       
       $record = DB::table('journalentries')

        ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
        ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
        ->join('journal', 'journalentries.journalId', '=', 'journal.id')
        ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')

        ->select('journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','accounthead.name as account','journalentrydetail.isDebit as isDebit','accounthead.code as accountheadCode' )
        ->where('entryNum','=',$request->entrynum)
        ->get();    

   

       return $record;
       
    }

        // for getting  balance sheet

    public function GetBalanceSheet(Request $request){
        
        $acctypes = DB::table('accountheadtypes')->orderBy('type')->get();


        $assetAccounts =  DB::select( DB::raw("SELECT acct.`type`,acch.`name`,acct.`id`,
                            SUM(CASE WHEN jed.isDebit = 1 THEN jed.`amount` ELSE 0 END) AS Debit,
                            SUM(CASE WHEN jed.isDebit = 0 THEN jed.`amount` ELSE 0 END) AS Credit
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(1,2,4,3,14,15)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type")
                            );
        $liabilitiesAccounts =  DB::select( DB::raw("SELECT acct.`type`,acch.`name`,acct.`id`,
                            SUM(CASE WHEN jed.isDebit = 1 THEN jed.`amount` ELSE 0 END) AS Debit,
                            SUM(CASE WHEN jed.isDebit = 0 THEN jed.`amount` ELSE 0 END) AS Credit
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(6,7,8)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type")
                            );
        $equityAccounts =  DB::select( DB::raw("SELECT acct.`type`,acch.`name`,acct.`id`,
                            SUM(CASE WHEN jed.isDebit = 1 THEN jed.`amount` ELSE 0 END) AS Debit,
                            SUM(CASE WHEN jed.isDebit = 0 THEN jed.`amount` ELSE 0 END) AS Credit
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(12,13)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type")
                            );
     

        return view('/Reports/report_balance_sheet',compact('acctypes','assetAccounts','liabilitiesAccounts','equityAccounts'));
        
    }

    // for getting  balance sheet

    public function GetProfitLoss(Request $request){
        
        $acctypes = DB::table('accountheadtypes')->orderBy('type')->get();


       
        $incomeAccounts =  DB::select( DB::raw("SELECT acct.`type`,acch.`name`,acct.`id`,
                            SUM(CASE WHEN jed.isDebit = 1 THEN jed.`amount` ELSE 0 END) AS Debit,
                            SUM(CASE WHEN jed.isDebit = 0 THEN jed.`amount` ELSE 0 END) AS Credit
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(5,9,10)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type")
                            );

        $expenseAccounts =  DB::select( DB::raw("SELECT acct.`type`,acch.`name`,acct.`id`,
                            SUM(CASE WHEN jed.isDebit = 1 THEN jed.`amount` ELSE 0 END) AS Debit,
                            SUM(CASE WHEN jed.isDebit = 0 THEN jed.`amount` ELSE 0 END) AS Credit
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(11)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type")
                            );
     

        return view('/Reports/report_profit_loss',compact('acctypes','incomeAccounts','expenseAccounts'));
        
    }
    

}
