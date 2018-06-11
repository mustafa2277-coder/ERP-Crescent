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
    public function __construct()
    {
        
        $this->middleware('role:proc-manage|admin');
       //$this->middleware('role:admin');
    }
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

        //$vendor = DB::table('journal')->where('id',$request->journalId)->first();
        $currentMonth  = date('m');
        $currentYear   = date('Y');
        $currentPrefix = 'PO/';
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
            $order = PurchaseOrder::find($request->id);
        
            $order->vendorId = $request->vendorId;
            $order->poDate = date("Y-m-d",strtotime(str_replace('/', '-', $request->datePost))); 
            $order->description = $request->description;
            $order->requiredDate  = date("Y-m-d",strtotime(str_replace('/', '-', $request->rDate))); 
            $order->projectId = $request->projectId;
            $order->updatedBy = $user->name;
            $order->status='1';
            $order->isRFQ=($request->isRFQ == 'on')?'on':'off';
            $order->save();
            /* $poNumber=PurchaseOrder::find($order->id);
            //return $poNumber->id;
            $poNumber->poNum=$currentPrefix.''.$currentYear.'/'.$currentMonth.'/'.$poNumber->id;
            $poNumber->save(); */
            PurchaseOrderDetail::where('poId',$request->id)->delete();
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
            
            

              return Response::json(['message'=>'inserted','poNumber'=>$order->poNum],201);
             
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
            
            

            return Response::json(['message'=>'inserted','poNumber'=>$poNumber->poNum],201);

        }
    }

    public function purchasePrint(Request $request){

        $user=Auth::user();
        $user=$user->name;
        $product=[];
        $quantity=[];
        $unit=[];
        $tax=[];
        $sub=[];
        $prodCode=[];
        $vendor="";
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
                $unit[$i-1]=$request->unit[$i];
                $tax[$i-1]=$request->tax[$i];
                $sub[$i-1]=$request->sub[$i];
            }
            else{
                
                $product[$i-1]='none';
                $prodCode[$i-1]='none';
                $quantity[$i-1]='none';
                $unit[$i-1]='none';
                $tax[$i-1]='none';
                $sub[$i-1]='none';
            }
        }
        //return [$debit,$credit,$acc];
        $proj=Project::find($request->project_id);
        $project=$proj->title;
    
        $vend=Customer::find($request->vendor_id);
        $vendor=$vend->name;
    
        $date=$request->pdate;
        $rdate=$request->rdate;
        $des=$request->description;
        $total=$request->total;
        $poNumber=$request->num;
        //return [$quantity,$unit, $tax,$sub,$rows/* ,'product','vendor','project','date','rdate','des','total','rows','prodCode','user' */];
        //return $proj;
        //return [$debit,$credit,$acc,$journal,$project,$date,$ref,$totalCredit,$totalDebit];
        //return $rows;
        $pdf = PDF::loadView('/purchase/printBlade/pPrint',compact('poNumber','quantity','unit','tax','sub','product','vendor','project','date','rdate','des','total','rows','prodCode','user'));
                        return $pdf->stream();
        //return view('/Journal/printBlade/jEPrint',compact('debit','credit','acc','journal','project','date','ref','totalCredit','totalDebit','rows','accCode'));
    }

    public function getPurchaseOrders(){
        $vendors=Customer::where('isVendor','on')->get();
        //return $vendors;
        $projects=Project::all();
        $products=Product::all();
        //return $vendor;
        return view('/purchase/purchaseOrder',compact('projects','vendors','products'));
    }
    public function getPurchaseOrder($id){
        //return $id;
        //$entry=JournalEntries::find($id);
        $purchaseorders="";
        $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->select('purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')
                        //->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('purchase_order.id',$id)
                        //->groupBy('poNum')
                        ->get();
        $projects=Project::all();
        $vendors=Customer::where('isVendor','on')->get();
        $products=Product::all();
        //return $purchaseorders;
        return view('purchase/addPurchaseOrder', compact('purchaseorders','projects','vendors','products'));
        }
    public function getFilterPurchaseOrder(Request $request){

        if($request->ajax())
        {

        $projectId = $request['filter_project'];
        $vendorId = $request['filter_vendor'];
        $end = $request['end_date'];
        $start = $request['start_date'];
        $purchaseorders = "";


        //filter by date

        if(empty($projectId) && empty($vendorId) && (!empty($end)|| !empty($start))){

                
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
                $purchaseorders=DB::table('purchase_order')
                            ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                            ->join('status','status.id','=','purchase_order.status')
                            ->join('customers','customers.id','=','purchase_order.vendorId')
                            ->join('project','project.id','=','purchase_order.projectId')
                            ->select('purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')
                            ->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                            ->groupBy('poNum')
                            ->get();
                //return $purchaseorder;
                $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');
            //return $journalentries; 

               ///return  $journalentries;//new Paginator($journalentries, 20);
        }

        //  filter by journal only

        if(empty($projectId) && !empty($vendorId) && (empty($end)|| empty($start))){
          
            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->select('purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')
                        //->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('customers.id',$vendorId)
                        ->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');


        } 

        //  filter by project only   
        
        if(!empty($projectId) && empty($vendorId) && (empty($end)|| empty($start))){
            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->select('purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')
                        //->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('project.id',$projectId)
                        ->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');


        }

        //  filter by jounral,project,date   

        if(!empty($projectId) && !empty($vendorId) && (!empty($end)|| !empty($start))){


            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->select('purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')
                        ->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('project.id',$projectId)
                        ->where('customers.id',$vendorId)
                        ->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');

                //return $start;
        }

        //  filter by jounral and date

        if(empty($projectId) && !empty($vendorId) && (!empty($end)|| !empty($start))){

            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->select('purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')
                        ->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('customers.id',$vendorId)
                        ->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');
 
        }

        //  filter by project and date

        if(!empty($projectId) && empty($vendorId) && (!empty($end)|| !empty($start))){

            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->select('purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')
                        ->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('project.id',$projectId)
                        ->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');

        }             
            

        
        $view =  view('/purchase/renderView/orderList',compact('purchaseorders','end','start','vendorId','projectId'))->render();       

        return response($view);

        }
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

    public function getOrderDetailPdf(Request $request){


        $projectId = $request->projectId;
        $vendorId = $request->vendorId;
        $end = $request->end;
        $start = $request->start;
        $purchaseorders = "";


        //filter by date

        if(empty($projectId) && empty($vendorId) && (!empty($end)|| !empty($start))){

                
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
                $purchaseorders=DB::table('purchase_order')
                            ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                            ->join('status','status.id','=','purchase_order.status')
                            ->join('customers','customers.id','=','purchase_order.vendorId')
                            ->join('project','project.id','=','purchase_order.projectId')
                            ->join('products','products.id','=','purchase_order_detail.productId')
                            ->select('products.name as products','products.code as productCode','purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')
                            ->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                            //->groupBy('poNum')
                            ->get();
                //return $purchaseorders;  
                //return view('/purchase/printBlade/pPrint',compact('purchaseorders','end','start')) ;        
                $pdf = PDF::loadView('/purchase/printBlade/pPrint',compact('purchaseorders','end','start'));
                return $pdf->stream();
                //return $purchaseorder;
                //$purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');
            //return $journalentries; 

               ///return  $journalentries;//new Paginator($journalentries, 20);
        }

        //  filter by journal only

        if(empty($projectId) && !empty($vendorId) && (empty($end)|| empty($start))){
          
            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->join('products','products.id','=','purchase_order_detail.productId')
                        ->select('products.name as products','products.code as productCode','purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')                        //->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('customers.id',$vendorId)
                        //->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            //$purchaseorders = $this->paginate($purchaseorders)->setPath('purchaseorders');
            $pdf = PDF::loadView('/purchase/printBlade/pPrint',compact('purchaseorders','end','start'));
            return $pdf->stream();

        } 

        //  filter by project only   
        
        if(!empty($projectId) && empty($vendorId) && (empty($end)|| empty($start))){
            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->join('products','products.id','=','purchase_order_detail.productId')
                        ->select('products.name as products','products.code as productCode','purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')                        //->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('project.id',$projectId)
                        //->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $pdf = PDF::loadView('/purchase/printBlade/pPrint',compact('purchaseorders','end','start'));
            return $pdf->stream();


        }

        //  filter by jounral,project,date   

        if(!empty($projectId) && !empty($vendorId) && (!empty($end)|| !empty($start))){


            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->join('products','products.id','=','purchase_order_detail.productId')
                        ->select('products.name as products','products.code as productCode','purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')                        ->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('project.id',$projectId)
                        ->where('customers.id',$vendorId)
                        //->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $pdf = PDF::loadView('/purchase/printBlade/pPrint',compact('purchaseorders','end','start'));
            return $pdf->stream();

                //return $start;
        }

        //  filter by jounral and date

        if(empty($projectId) && !empty($vendorId) && (!empty($end)|| !empty($start))){

            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->join('products','products.id','=','purchase_order_detail.productId')
                        ->select('products.name as products','products.code as productCode','purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')                        ->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('customers.id',$vendorId)
                        ->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $pdf = PDF::loadView('/purchase/printBlade/pPrint',compact('purchaseorders','end','start'));
            return $pdf->stream();
 
        }

        //  filter by project and date

        if(!empty($projectId) && empty($vendorId) && (!empty($end)|| !empty($start))){

            $purchaseorders=DB::table('purchase_order')
                        ->join('purchase_order_detail','purchase_order.id','=','purchase_order_detail.poId')
                        ->join('status','status.id','=','purchase_order.status')
                        ->join('customers','customers.id','=','purchase_order.vendorId')
                        ->join('project','project.id','=','purchase_order.projectId')
                        ->join('products','products.id','=','purchase_order_detail.productId')
                        ->select('products.name as products','products.code as productCode','purchase_order.*','purchase_order_detail.*','customers.*','project.*','status.id as stId','status.name as stname')                        ->whereBetween('purchase_order.poDate',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->where('project.id',$projectId)
                        ->groupBy('poNum')
                        ->get();
            //return $purchaseorder;
            $pdf = PDF::loadView('/purchase/printBlade/pPrint',compact('purchaseorders','end','start'));
            return $pdf->stream();

        }             
            

        
        

    }
    public function deletePurchaseOrder($id){

        PurchaseOrderDetail::where('poId',$id)->delete();
        PurchaseOrder::where('id',$id)->delete();

        return redirect()->back();
    }
    
}
