<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use DB;
use App\User;
use App\AccountHead;
use App\Journal;
use App\JournalEntries;
use App\JournalEntryDetail;
use PDF;
use Response;
use Redirect;


class ReportController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:proc-manage|admin');
       //$this->middleware('role:admin');
    }

    // for getting all journals

    public function GetGeneralLedger(Request $request){
        
        //$generalLedger = [];

       // $ledger =  DB::table('accounthead')->orderBy('name')->get();

        $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                    ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                    ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                    FROM journalentrydetail jed
                                    JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                    JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                    LEFT JOIN project pj ON pj.id = je.projectId
                                    GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                    ORDER BY je.date_post,je.`entryNum`") 
                        );

        // $ledgerAccounts = DB::table('accounthead')->orderBy('name')->get();


        $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.code,acch2.id FROM `accounthead` acch2
                                     JOIN (SELECT acch.name,jed.`isDebit`,je.`entryNum`,je.`date_post`,acch.id,
                                    ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                    ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                     FROM journalentrydetail jed
                                    JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                    JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                    GROUP BY acch.name,jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,acch.code
                                    ORDER BY acch.`name`,je.date_post) acc ON acch2.id=acc.id
                                    GROUP BY acch2.name,acch2.code,acch2.id
                                    ORDER BY acch2.code")
                            );
     

        return view('/Reports/report_general_ledger',compact('ledgers','ledgerAccounts'));
    	
    }

    // for getting general ledger view page

    public function GetGeneralLedgerView(Request $request){
        

        $journals =  DB::table('journal')->orderBy('name')->get();
        $accounts=  DB::table('accounthead')->where('isTransactional','1')->orwhere('isTransactional',null)->orderBy('name')->get();
        $customers=  DB::table('customers')->orderBy('name')->get();
        $end   = date("d/m/Y");
        $start = date("d/m/Y");


        return view('/Reports/report_general_ledger_view',compact('journals','end','start','customers','accounts'));
        
    }

    public function GetFilterGeneralLedgerList(Request $request){


        if($request->ajax())
        {

            $projectId = $request['filter_project'];
            $accountHeadId = $request['filter_account'];
            $end = $request['end_date'];
            $start = $request['start_date'];
            $parentAccounts = [];
            //$journalentries = "";


            //filter by date
            if(empty($projectId)  && empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                    
                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end'
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );

               // return $ledgers;

                $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code,acch2.parentId
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start') 
                                    jj ON jj.accHeadId = acch2.id
                                    Where acch2.isTransactional=1 OR acch2.isTransactional is Null  
                                    GROUP BY acch2.name,acch2.id,acch2.code
                                    ORDER BY acch2.code
                                ")
                                    );

               


            
            }

            // by accounthead and date

            if(empty($projectId)  && !empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end' AND jed.accHeadId = '$accountHeadId'
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );


                $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code,acch2.parentId
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start'
                                    ) 
                                    jj ON jj.accHeadId = acch2.id
                                    WHERE acch2.id='$accountHeadId' AND (acch2.isTransactional=1 OR acch2.isTransactional is Null)  
                                    GROUP BY acch2.name,acch2.id,acch2.code
                                    ORDER BY acch2.code")
                                    );


            
            }

            // by project and date
            if(!empty($projectId)  && empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end' AND pj.id = '$projectId'
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );


                $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code,acch2.parentId
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start'
                                    ) 
                                    jj ON jj.accHeadId = acch2.id
                                    WHERE acch2.isTransactional=1 OR acch2.isTransactional is Null    
                                    GROUP BY acch2.name,acch2.id,acch2.code
                                    ORDER BY acch2.code")
                                    );
            }

           // by project ,accounhead and date
            if(!empty($projectId)  && !empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end' AND pj.id = '$projectId' AND jed.accHeadId = '$accountHeadId' 
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );


                $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code,acch2.parentId
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start'
                                    ) 
                                    jj ON jj.accHeadId = acch2.id
                                    WHERE acch2.id='$accountHeadId' AND (acch2.isTransactional=1 OR acch2.isTransactional is Null)    
                                    GROUP BY acch2.name,acch2.id,acch2.code
                                    ORDER BY acch2.code")
                                    );
            }

            foreach ($ledgerAccounts as $ledgerAccount) 
            {
                $parentAccounts[$ledgerAccount->id] =  $this->GetTreeAccountHeads($ledgerAccount);
            }        
       
            $view =  view('/Reports/report_general_ledger_list',compact('ledgers','ledgerAccounts','parentAccounts'))->render(); 

            return response($view);
           
        }

    }

     public function GetGeneralLedgerListByParentId(Request $request){


        if($request->ajax())
        {

            $projectId = $request['filter_project'];
            $accountHeadId = $request['filter_account'];
            $end = $request['end_date'];
            $start = $request['start_date'];
            $parentId = $request['parentId'];
            $parentAccounts = [];
            $ledgers = "";
            $ledgerAccounts = "";
            

            $accountHeads2 =  AccountHead::where('accounthead.id', '=', $parentId)
                                         ->where('accounthead.parentId','=',0)->get();

            // return count($accountHeads2);                            

            if(count($accountHeads2)==0){
           

 
            //filter by date
            // if(empty($projectId)  && !empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                    
                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch2.id,acch2.name,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `accounthead` acch2 ON acch2.`id`= acch.parentId
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end'
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );

               // return $ledgers;

                $ledgerAccounts =  DB::select( DB::raw("SELECT acch3.name,acch3.id,acch3.code,acch3.parentId
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start') 
                                    jj ON jj.accHeadId = acch2.id
                                    JOIN `accounthead` acch3 ON acch3.id=acch2.`parentId` 
                                    WHERE acch3.id='$parentId'  
                                    GROUP BY acch3.name,acch3.id,acch3.code
                                    ORDER BY acch3.code
                                   ")
                                    );

             }
            else
            {

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                    
                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch3.id,acch3.name,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `accounthead` acch2 ON acch2.`id`= acch.parentId
                                            JOIN `accounthead` acch3 ON acch3.`id`= acch2.parentId
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end'
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );

               

                $ledgerAccounts =  DB::select( DB::raw("SELECT acch4.name,acch4.id,acch4.code,acch4.parentId
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start') 
                                    jj ON jj.accHeadId = acch2.id
                                    JOIN `accounthead` acch3 ON acch3.id=acch2.`parentId` 
                                    JOIN `accounthead` acch4 ON acch4.id=acch3.`parentId` 
                                    WHERE  acch4.id='$parentId'
                                    GROUP BY acch4.name,acch4.id,acch4.code
                                    ORDER BY acch4.code
                                   ")
                                    );

            }
            
            // }

            

            // by project and date
            // if(!empty($projectId)  && empty($accountHeadId) && (!empty($end)|| !empty($start))){

            //     $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
            //     $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

            //     $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
            //                                 ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
            //                                 ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
            //                                 FROM journalentrydetail jed
            //                                 JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
            //                                 JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
            //                                 LEFT JOIN project pj ON pj.id = je.projectId
            //                                 WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end' AND pj.id = '$projectId'
            //                                 GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
            //                                 ORDER BY je.date_post,je.`entryNum`") 
            //                     );


            //     $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code,acch2.parentId
            //                          ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
            //                          SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
            //                         FROM `accounthead` acch2
            //                         LEFT JOIN 
            //                         (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
            //                         LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
            //                         WHERE je2.`date_post` < '$start'
            //                         ) 
            //                         jj ON jj.accHeadId = acch2.id
            //                         WHERE acch2.isTransactional=1 OR acch2.isTransactional is Null    
            //                         GROUP BY acch2.name,acch2.id,acch2.code
            //                         ORDER BY acch2.code")
            //                         );
            // }

          
            foreach ($ledgerAccounts as $ledgerAccount) 
            {
                $parentAccounts[$ledgerAccount->id] =  $this->GetTreeAccountHeads($ledgerAccount);
            }
        
            $view =  view('/Reports/report_general_ledger_list',compact('ledgers','ledgerAccounts','parentAccounts'))->render(); 

            return response($view);
           
        }

    }

    public function GetJournalEntryByEntrynum(Request $request){
       
       $record = DB::table('journalentries')

        ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
        ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
        ->join('journal', 'journalentries.journalId', '=', 'journal.id')
        ->join('accounthead', 'journalentrydetail.accHeadId', '=', 'accounthead.id')

        ->select('journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount','accounthead.name as account','journalentrydetail.isDebit as isDebit','accounthead.code as accountheadCode','journalentries.reference as reference' )
        ->where('entryNum','=',$request->entrynum)
        ->get();    

   

       return $record;
       
    }

        // for getting  balance sheet

    public function GetBalanceSheet(Request $request){
        
        // $acctypes = DB::table('accountheadtypes')->orderBy('type')->get();

        $assetAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id` FROM journalentrydetail jed
                                JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                                LEFT JOIN project pj ON pj.id = je.projectId  
                                WHERE acct.id IN(1,2,4,3,14,15)
                                GROUP BY acct.type,acch.`name`,acct.`id`
                                ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
                            );


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

        $liaAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id` FROM journalentrydetail jed
                                JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                                LEFT JOIN project pj ON pj.id = je.projectId  
                                WHERE acct.id IN(6,7,8)
                                GROUP BY acct.type,acch.`name`,acct.`id`
                                ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
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

        $equityAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id` FROM journalentrydetail jed
                                JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                                LEFT JOIN project pj ON pj.id = je.projectId  
                                WHERE acct.id IN(12,13)
                                GROUP BY acct.type,acch.`name`,acct.`id`
                                ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
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
     

        return view('/Reports/report_balance_sheet',compact('assetAccounts','liabilitiesAccounts','equityAccounts','assetAcctypes','liaAcctypes','equityAcctypes'));
        
    }

    // for getting  balance sheet

    public function GetProfitLoss(Request $request){
        
    
        $incomeAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id`
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(5,9,10)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
                            );

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






        $expenseAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id`
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(11)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
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
     

        return view('/Reports/report_profit_loss',compact('incomeAcctypes','incomeAccounts','expenseAcctypes','expenseAccounts'));
        
    }

    public function GetFilterGeneralLedgerList2(Request $request){


        if($request->ajax())
        {

            $projectId = $request['filter_project'];
            $accountHeadId = $request['filter_account'];
            $end = $request['end_date'];
            $start = $request['start_date'];
            $parentAccounts = [];

            //$journalentries = "";


            //filter by date
            if(empty($projectId)  && empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                    
                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end'
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );

               // return $ledgers;

                $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code,acch2.parentId
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start') 
                                    jj ON jj.accHeadId = acch2.id
                                    Where acch2.isTransactional=1 OR acch2.isTransactional is Null  
                                    GROUP BY acch2.name,acch2.id,acch2.code
                                    ORDER BY acch2.code
                                    limit 10")
                                    );

                // $parentAccounts =  DB::table('accounthead')->orderBy('name')->get();

 
   


// return $parentAccounts;exit();
            
            }

            // by accounthead and date

            if(empty($projectId)  && !empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end' AND jed.accHeadId = '$accountHeadId'
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );


                $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start'
                                    ) 
                                    jj ON jj.accHeadId = acch2.id
                                    WHERE acch2.id='$accountHeadId' AND (acch2.isTransactional=1 OR acch2.isTransactional is Null)  
                                    GROUP BY acch2.name,acch2.id,acch2.code
                                    ORDER BY acch2.code")
                                    );


            
            }

            // by project and date
            if(!empty($projectId)  && empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end' AND pj.id = '$projectId'
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );


                $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start'
                                    ) 
                                    jj ON jj.accHeadId = acch2.id
                                    WHERE acch2.isTransactional=1 OR acch2.isTransactional is Null    
                                    GROUP BY acch2.name,acch2.id,acch2.code
                                    ORDER BY acch2.code")
                                    );
            }

           // by project ,accounhead and date
            if(!empty($projectId)  && !empty($accountHeadId) && (!empty($end)|| !empty($start))){

                $end   = date("Y-m-d",strtotime(str_replace('/', '-', $end)));
                $start = date("Y-m-d",strtotime(str_replace('/', '-', $start)));

                $ledgers =  DB::select( DB::raw("SELECT jed.`isDebit`,je.`entryNum`,je.`date_post`,pj.title project,acch.id,
                                            ( CASE WHEN jed.isDebit = 1 THEN jed.`amount` END) AS Debit,
                                            ( CASE WHEN jed.isDebit = 0 THEN jed.`amount` END) AS Credit
                                            FROM journalentrydetail jed
                                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                            LEFT JOIN project pj ON pj.id = je.projectId
                                            WHERE je.`date_post` >= '$start' AND je.`date_post` <= '$end' AND pj.id = '$projectId' AND jed.accHeadId = '$accountHeadId' 
                                            GROUP BY jed.`isDebit`,je.`entryNum`,je.`date_post`,Debit,Credit,project,acch.id
                                            ORDER BY je.date_post,je.`entryNum`") 
                                );


                $ledgerAccounts =  DB::select( DB::raw("SELECT acch2.name,acch2.id,acch2.code
                                     ,(SUM(CASE WHEN jj.isDebit = 1 THEN jj.`amount` ELSE 0  END)-
                                     SUM(CASE WHEN jj.isDebit = 0 THEN jj.`amount`   ELSE 0  END)) AS Balance  
                                      
                                    FROM `accounthead` acch2
                                    LEFT JOIN 
                                    (SELECT jed.amount,jed.`accHeadId`,jed.`isDebit` FROM  journalentrydetail  jed
                                    LEFT JOIN journalentries je2 ON jed.`journalEntryId`=je2.`id` 
                                    WHERE je2.`date_post` < '$start'
                                    ) 
                                    jj ON jj.accHeadId = acch2.id
                                    WHERE acch2.id='$accountHeadId' AND (acch2.isTransactional=1 OR acch2.isTransactional is Null)    
                                    GROUP BY acch2.name,acch2.id,acch2.code
                                    ORDER BY acch2.code")
                                    );
            }     

            foreach ($ledgerAccounts as $ledgerAccount) 
            {
                $parentAccounts[$ledgerAccount->id] =  $this->GetTreeAccountHeads($ledgerAccount);
            }   
        
            $view =  view('/Reports/report_general_ledger_list2',compact('ledgers','ledgerAccounts','parentAccounts'))->render(); 

            return response($view);
           
        }

    }

      public function GetAccountHeads(Request $request){
        
        $arr=null;
        $accountHeads2 =  DB::table('accounthead')
                            ->select('accounthead.*','accounthead.name as name','accounthead.code as code','accounthead.id as id','accounthead.isTransactional as isTrans')
                            ->where('accounthead.parentId', '=', 0)
                            ->orWhere('accounthead.parentId', '=', NULL)
                            ->get(); 

        foreach($accountHeads2 as $item){

               
                $arr.=$item->name .$this->GetTreeAccountHeads($item);

        }


        return view('/AccountHead/acc_head_list',compact('arr'));//,'accountHeads3'));
        
    }


    public function GetTreeAccountHeads($child){

        $arr=[];  
        //$obj={{}}
     
        $accountHeads2 =  AccountHead::where('accounthead.id', '=', $child->parentId)->get();
// return $accountHeads2[0]->name;
       // var_dump(count($accountHeads2));exit();
        if(count($accountHeads2)!=0){
       

             if($this->GetTreeAccountHeads($accountHeads2[0])){
              $arr[] = $this->GetTreeAccountHeads($accountHeads2[0]);
            //  $arr[] = $temp;



            }
           
           if(!$this->GetTreeAccountHeads($accountHeads2[0])){
              return (object)['code'=>$accountHeads2[0]->code,'name'=>$accountHeads2[0]->name,'id'=>$accountHeads2[0]->id];

            }
          
            $arr[] =  (object)['code'=>$accountHeads2[0]->code,'name'=>$accountHeads2[0]->name,'id'=>$accountHeads2[0]->id];
          
            return $arr;
        }else{

            return  ; 


        }



    }
   /*--------------------------------------------------------------------Print Balance Sheet PDF--------------------------------------------------------------------------- */ 
    public function GetBalanceSheetPDF(){

        $assetAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id` FROM journalentrydetail jed
                                JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                                LEFT JOIN project pj ON pj.id = je.projectId  
                                WHERE acct.id IN(1,2,4,3,14,15)
                                GROUP BY acct.type,acch.`name`,acct.`id`
                                ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
                            );


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

        $liaAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id` FROM journalentrydetail jed
                                JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                                LEFT JOIN project pj ON pj.id = je.projectId  
                                WHERE acct.id IN(6,7,8)
                                GROUP BY acct.type,acch.`name`,acct.`id`
                                ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
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

        $equityAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id` FROM journalentrydetail jed
                                JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                                JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                                JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                                LEFT JOIN project pj ON pj.id = je.projectId  
                                WHERE acct.id IN(12,13)
                                GROUP BY acct.type,acch.`name`,acct.`id`
                                ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
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
     
                            $pdf = PDF::loadView('pdfTemplateBalanceSheet',compact('assetAccounts','liabilitiesAccounts','equityAccounts','assetAcctypes','liaAcctypes','equityAcctypes'));

                            return $pdf->stream();
    }

     /*--------------------------------------------------------------------Print Profit Loss PDF--------------------------------------------------------------------------- */ 
     public function GetProfitLossPdf(){

        $incomeAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id`
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(5,9,10)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
                            );

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






        $expenseAcctypes =  DB::select( DB::raw("SELECT acch2.id,acch2.type FROM `accountheadtypes` acch2
                                WHERE acch2.id IN(SELECT acct.`id`
                            FROM journalentrydetail jed
                            JOIN `accounthead` acch ON acch.`id`=jed.`accHeadId`
                            JOIN `journalentries` je ON je.`id`=jed.`journalEntryId`
                            JOIN `accountheadtypes` acct ON acct.`id`=acch.`accHeadTypeId`
                            LEFT JOIN project pj ON pj.id = je.projectId  
                            WHERE acct.id IN(11)
                            GROUP BY acct.type,acch.`name`,acct.`id`
                            ORDER BY acct.type)
                                    GROUP BY acch2.id,acch2.type
                                    ORDER BY acch2.type")
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
     

        $pdf = PDF::loadView('pdfTemplateProfitLoss',compact('incomeAcctypes','incomeAccounts','expenseAcctypes','expenseAccounts'));

        return $pdf->stream();
       


     }


}
