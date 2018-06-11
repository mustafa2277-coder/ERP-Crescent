<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Journal;
use App\Project;
use App\Product;
use App\RpStatus;
use App\Customer;
use App\AccountHead;
use App\JournalEntries;
use App\JournalEntryDetail;
use App\PurchaseOrder;
use App\PurchaseOrderDetail;
use App\RequestPurchase;
use App\RequestPurchaseDetail;
use Auth;
use Response;
use PdfReport;
use PDF;
use Redirect;
use Illuminate\Pagination\LengthAwarePaginator;

class RequestPurchaseController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:proc-manage|admin');
       //$this->middleware('role:admin');
    }
    public function getRequests(){

        //$vendors=Customer::where('isVendor','on')->get();
        //return $vendors;
        $projects=Project::all();
        $products=Product::all();
        //return $vendor;
        return view('/purchaseRequest/purchaseOrder',compact('projects','products'));
    }
    public function getFilterRequestPurchase(Request $request){

        if($request->ajax())
        {

        $projectId = $request['filter_project'];
        $end = $request['end_date'];
        $start = $request['start_date'];
        $purchaseorders = "";


        //filter by date

        if(empty($projectId)  && (!empty($end)|| !empty($start))){

                
               /*  $journalentries = DB::table('journalentries')
                ->join('journalentrydetail', 'journalentries.id', '=', 'journalentrydetail.journalEntryId')
                ->join('journal', 'journalentries.journalId', '=', 'journal.id')
                ->leftJoin('project', 'journalentries.projectId', '=', 'project.id')
                ->select('journalentries.*', 'journalentries.date_post as entryDate', 'journalentries.id as id','journalentries.entryNum as entryNum','project.title as project','journal.name as journal','journalentrydetail.amount as amount'

                )
                ->whereBetween('journalentries.date_post',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                ->groupBy('entryDate', 'id','entryNum','journal')
               // ->paginate(20); 
                ->get();  */
                $purchaseorders=DB::table('request_purchase')
                            ->join('request_purchase_detail','request_purchase.id','=','request_purchase_detail.rpId')
                            ->join('rp_status','rp_status.id','=','request_purchase.status')
                            
                            ->join('project','project.id','=','request_purchase.projectId')
                            ->select('request_purchase.*','request_purchase_detail.*','project.*','rp_status.id as stId','rp_status.name as stname')
                            ->whereBetween('request_purchase.rpDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                            ->groupBy('rpNum')
                            ->get();
                //return $purchaseorder;
                $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');
            //return $journalentries; 

               ///return  $journalentries;//new Paginator($journalentries, 20);
        }

        //  filter by project only   
        
        if(!empty($projectId) && (empty($end)|| empty($start))){
            $purchaseorders=DB::table('request_purchase')
                        ->join('request_purchase_detail','request_purchase.id','=','request_purchase_detail.rpId')
                        ->join('rp_status','rp_status.id','=','request_purchase.status')
                        
                        ->join('project','project.id','=','request_purchase.projectId')
                        ->select('request_purchase.*','request_purchase_detail.*','project.*','rp_status.id as stId','rp_status.name as stname')
                        //->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('project.id',$projectId)
                        ->groupBy('rpNum')
                        ->get();
            //return $purchaseorder;
            $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');


        }

        //  filter by jounral,project,date   

        if(!empty($projectId) && (!empty($end)|| !empty($start))){


            $purchaseorders=DB::table('request_purchase')
                        ->join('request_purchase_detail','request_purchase.id','=','request_purchase_detail.rpId')
                        ->join('rp_status','rp_status.id','=','request_purchase.status')
                        
                        ->join('project','project.id','=','request_purchase.projectId')
                        ->select('request_purchase.*','request_purchase_detail.*','project.*','rp_status.id as stId','rp_status.name as stname')
                        ->whereBetween('request_purchase.rpDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('project.id',$projectId)
                        
                        ->groupBy('rpNum')
                        ->get();
            //return $purchaseorder;
            $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');

                //return $start;
        }

        //  filter by jounral and date

        
        //  filter by project and date

                 
            

        
        $view =  view('/purchaseRequest/renderView/orderList',compact('purchaseorders','end','start','projectId'))->render();       

        return response($view);

        }
    }
    protected function paginate($items, $perPage = 12){
        //Get current page form url e.g. &page=1
        $currentPage =  LengthAwarePaginator::resolveCurrentPage();

        //Slice the collection to get the items to display in current page
        $currentPageItems = $items->slice(($currentPage - 1) * $perPage, $perPage);

        //Create our paginator and pass it to the view
        return new LengthAwarePaginator($currentPageItems, count($items), $perPage);
    }
    public function getAddRequestPurchase(){

        $products=Product::all();
        $projects=Project::all();
        $status=RpStatus::all();
        $vendors=Customer::where('isVendor','on')->get();
        //return $vendor;
        return view('/purchaseRequest/addPurchaseOrder',compact('projects','vendors','products','status'));
    }
    public function getRequestPurchase($id){
        
        $purchaseorders="";
        $purchaseorders=DB::table('request_purchase')
                        ->join('request_purchase_detail','request_purchase.id','=','request_purchase_detail.rpId')
                        ->join('rp_status','rp_status.id','=','request_purchase.status')
                        
                        ->join('project','project.id','=','request_purchase.projectId')
                        ->select('request_purchase.*','request_purchase_detail.*','project.*','rp_status.id as stId','rp_status.name as stname')
                        //->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('request_purchase.id',$id)
                        //->groupBy('poNum')
                        ->get();
        $projects=Project::all();
        //$vendors=Customer::where('isVendor','on')->get();
        $products=Product::all();
        //return $purchaseorders;
        return view('purchaseRequest/addPurchaseOrder', compact('purchaseorders','projects','products'));
    }
    public function insertRequestPurchase(Request $request){
        //return $request->datePost;
        $user=Auth::user();

        //$vendor = DB::table('journal')->where('id',$request->journalId)->first();
        $currentMonth  = date('m');
        $currentYear   = date('Y');
        $currentPrefix = 'RP/';
     //   $entryNumber =  $this->GenerateJournalEntryNum(strtoupper($journal->voucherPrefix));
 

        if($request->id!=""){
                /* $journalEntry = JournalEntries::find($request->id);
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

            return Response::json(['message'=>'inserted'],201); */
            $order = RequestPurchase::find($request->id);
        
           
            $order->rpDate = date("Y-m-d",strtotime(str_replace('/', '-', $request->datePost))); 
            $order->description = $request->description;
            $order->requiredDate  = date("Y-m-d",strtotime(str_replace('/', '-', $request->rDate))); 
            $order->projectId = $request->projectId;
            $order->updatedBy = $user->name;
            $order->save();
            /* $poNumber=PurchaseOrder::find($order->id);
            //return $poNumber->id;
            $poNumber->poNum=$currentPrefix.''.$currentYear.'/'.$currentMonth.'/'.$poNumber->id;
            $poNumber->save(); */
            RequestPurchaseDetail::where('rpId',$request->id)->delete();
                 for ($i=0; $i <$request->rowTotal; $i++){
                    /* if($request->debit[$i]== 0){
                        $isDebit = false;
                        $amount = $request->credit[$i];
                    }
                    
                    if($request->credit[$i]== 0){
                        $isDebit = true;
                        $amount = $request->debit[$i];
                    } */
                    $rpID=$order->id;
                    $product=$request->product[$i];
                    $quantity=$request->quantity[$i];
                    

                    $dataSet[$i] = [
                        'rpId'         => $rpID,
                        
                        'productId' => $product,
                        'productQuantity' => $quantity,

                    ];
        
                    
                }
                
                RequestPurchaseDetail::insert($dataSet);  
            
            

              return Response::json(['message'=>'inserted','rpNumber'=>$order->rpNum],201);
             
        }
        else
        {

            $order = new RequestPurchase;
        
          
            $order->rpDate = date("Y-m-d",strtotime(str_replace('/', '-', $request->datePost))); 
            $order->description = $request->description;
            $order->requiredDate  = date("Y-m-d",strtotime(str_replace('/', '-', $request->rDate))); 
            $order->projectId = $request->projectId;
            $order->createdBy = $user->name;
            $order->status='1';
            
            $order->save();
            $rpNumber=RequestPurchase::find($order->id);
            //return $poNumber->id;
            $rpNumber->rpNum=$currentPrefix.''.$currentYear.'/'.$currentMonth.'/'.$rpNumber->id;
            $rpNumber->save();
            
                 for ($i=0; $i <$request->rowTotal; $i++){
                    /* if($request->debit[$i]== 0){
                        $isDebit = false;
                        $amount = $request->credit[$i];
                    }
                    
                    if($request->credit[$i]== 0){
                        $isDebit = true;
                        $amount = $request->debit[$i];
                    } */
                    $rpID=$order->id;
                    $product=$request->product[$i];
                    $quantity=$request->quantity[$i];
                    

                    $dataSet[$i] = [
                        'rpId'         => $rpID,
                        
                        'productId' => $product,
                        'productQuantity' => $quantity,
                       

                    ];
        
                    
                }
                
                RequestPurchaseDetail::insert($dataSet);  
            
            

            return Response::json(['message'=>'inserted','rpNumber'=>$rpNumber->rpNum],201);

        }
    }

    public function requestPurchasePrint(Request $request){

        $user=Auth::user();
        $user=$user->name;
        $product=[];
        $quantity=[];
        $prodCode=[];
        $project="";
        $date="";
        $rdate="";
        $des="";
        $totalCredit="";
        $totalDebit="";
        /* return $request->creditAmt; */
    
        $rows=$request->rowTotal;
        //return $request->sub[1];
        //return $rows;
        for($i=1;$i<=$rows;$i++){
            if(isset($request->product[$i])){
    
                $prod=Product::where('id',$request->product[$i])->get();
                //return $prod;
                $product[$i-1]=$prod[0]->name;
                $prodCode[$i-1]=$prod[0]->code;
                $quantity[$i-1]=$request->quantity[$i];
                
            }
            else{
                
                $product[$i-1]='none';
                $prodCode[$i-1]='none';
                $quantity[$i-1]='none';
                
            }
        }
        //return [$debit,$credit,$acc];
        $proj=Project::find($request->project_id);
        $project=$proj->title;
    
    
        $date=$request->pdate;
        $rdate=$request->rdate;
        $des=$request->description;
        //$total=$request->total;
        $rpNumber=$request->num;
        //return [$quantity,$unit, $tax,$sub,$rows/* ,'product','vendor','project','date','rdate','des','total','rows','prodCode','user' */];
        //return $proj;
        //return [$debit,$credit,$acc,$journal,$project,$date,$ref,$totalCredit,$totalDebit];
        //return $rows;
        $pdf = PDF::loadView('/purchaseRequest/printBlade/pPrint',compact('rpNumber','quantity','product','project','date','rdate','des','rows','prodCode','user'));
                        return $pdf->stream();
        //return view('/Journal/printBlade/jEPrint',compact('debit','credit','acc','journal','project','date','ref','totalCredit','totalDebit','rows','accCode'));
    }
    public function deletePurchaseRequest($id){

        RequestPurchaseDetail::where('rpId',$id)->delete();
        RequestPurchase::where('id',$id)->delete();

        return redirect()->back();
    }
}
