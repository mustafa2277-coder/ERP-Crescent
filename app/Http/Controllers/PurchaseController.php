<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Journal;
use App\Project;
use App\Customer;
use App\Product;
use App\AccountHead;
use App\JournalEntries;
use App\JournalEntryDetail;
use App\PurchaseOrder;
use App\PurchaseOrderDetail;
use App\Status;
use Auth;
use Response;
use PdfReport;
use PDF;
//use Illuminate\Pagination\Paginator;
use Redirect;
use Illuminate\Pagination\LengthAwarePaginator;

class PurchaseController extends Controller
{
    public function getAddPurchase(){
        $products=Product::all();
        $projects=Project::all();
        $status=Status::all();
        $vendors=Customer::where('isVendor','on')->get();
        //return $vendor;
        return view('/purchase/addPurchaseOrder',compact('projects','vendors','products','status'));
    }
    public function insertPurchaseOrder(Request $request){
        //return $request->datePost;
        $user=Auth::user();

        $vendor = DB::table('journal')->where('id',$request->journalId)->first();
        $currentMonth  = date('m');
        $currentYear   = date('Y');
        $currentPrefix = 'PO/';
     //   $entryNumber =  $this->GenerateJournalEntryNum(strtoupper($journal->voucherPrefix));
 

        if($request->id!=""){
                $journalEntry = JournalEntries::find($request->id);
                //return $journalEntry;
        
                $journalEntry->journalId = $request->journalId;
                $journalEntry->date_post = date("Y-m-d",strtotime(str_replace('/', '-', $request->datePost))); 
                $journalEntry->reference = $request->reference;
                $journalEntry->entryNum  = $entryNumber;
                $journalEntry->projectid = $request->projectId;
                $journalEntry->createdBy = $user->name;
                $journalEntry->save();

                JournalEntryDetail::where('journalEntryId',$request->id)->delete();

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

            return Response::json(['message'=>'inserted'],201);
             
        }
        else
        {

            $order = new PurchaseOrder;
        
            $order->vendorId = $request->vendorId;
            $order->poDate = date("Y-m-d",strtotime(str_replace('/', '-', $request->datePost))); 
            $order->description = $request->description;
            $order->requiredDate  = date("Y-m-d",strtotime(str_replace('/', '-', $request->rDate))); 
            $order->projectId = $request->projectId;
            $order->createdBy = $user->name;
            $order->status='1';
            $order->isRFQ=($request->isRFQ == 'on')?'on':'off';
            $order->save();
            $poNumber=PurchaseOrder::find($order->id);
            //return $poNumber->id;
            $poNumber->poNum=$currentPrefix.''.$currentYear.'/'.$currentMonth.'/'.$poNumber->id;
            $poNumber->save();
            
                 for ($i=0; $i <$request->rowTotal; $i++){
                    /* if($request->debit[$i]== 0){
                        $isDebit = false;
                        $amount = $request->credit[$i];
                    }
                    
                    if($request->credit[$i]== 0){
                        $isDebit = true;
                        $amount = $request->debit[$i];
                    } */
                    $poID=$order->id;
                    $product=$request->product[$i];
                    $quantity=$request->quantity[$i];
                    $unit=$request->unit[$i];
                    $tax=$request->tax[$i];
                    $sub=$request->sub[$i];

                    $dataSet[$i] = [
                        'poId'         => $poID,
                        
                        'productId' => $product,
                        'productQuantity' => $quantity,
                        'unitPrice'        => $unit,
                        'tax'        => $tax,
                        'subTotal'        => $sub

                    ];
        
                    
                }
                
                PurchaseOrderDetail::insert($dataSet);  
            
            

            return Response::json(['message'=>'inserted'],201);

        }
    }

    public function purchasePrint(Request $request){

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
}
