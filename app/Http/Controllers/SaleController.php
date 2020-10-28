<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\InvWarehouse;
use App\ReturnSale;
use App\ReturnSaleDetail;
use PdfReport;
use PDF;

class SaleController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:admin');
       //$this->middleware('role:admin');
    }
    public function getTodaySales(){

        /* $current = Carbon::today(); */
        /* return $current; */
        // $sum=0;
        // $salesSum=DB::table('sales')->select('sales.totalPrice')->whereDate('created_at', Carbon::today())->get();
        // /* return $salesSum; */
        // foreach ($salesSum as $sale) {
        //     $sum=$sum+$sale->totalPrice;
        // }
        // //return $sum;
        $warehouses=InvWarehouse::all();
        $sales = DB::table('sales')

        ->join('poscustomers', 'sales.customerId', '=', 'poscustomers.id')
        
        ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')

        ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
        
        ->join('users', 'users.id', '=', 'sales.employId')
        
        /* ->join('products', 'products.id', '=', 'sale_details.productId') */

        ->select( /* 'products.name', */'sales.*','users.name as empName','poscustomers.firstName','poscustomers.lastName','poscustomers.contactNo', 'inv_warehouse.warehouse_name')
        
        ->whereDate('sales.created_at',Carbon::today())
        
        ->where('sales.done',null)
        
        ->where('sales.token',null)
        
        /* ->orderBy('products.id', 'DESC') */
        // ->sum('warehouseproduct.quantity_in_hand');
        // return $productList;
        //->distinct()
        // ->get();

        ->get();
        
        $returnSales=ReturnSale::select(DB::raw("SUM(totalAmount) as total"))->whereDate('created_at',Carbon::today())->get();
        
        $salesId=DB::table('sales')->select('sales.id')->where('sales.done',1)->whereDate('sales.created_at',Carbon::today())->get();
        //return  $salesId;
        $total=0;
            for( $i=0; $i<sizeof($salesId); $i++){
                //return $id;
                $salesDetail=DB::table('sale_details')->select(DB::raw("SUM(totalPrice) as total"))
                            ->where('sale_details.orderId',$salesId[$i]->id)
                            ->get();
                $total=$total+$salesDetail[0]->total;
            }
        
        //return $returnSales;
        return view('/sales/salesList',compact('sales','warehouses','returnSales','total'));
    }
    public function getTodayReturnSales(){
        
   
        $warehouses=InvWarehouse::all();
        $return_sales = DB::table('return_sales')
        
        ->join('user_warehouse', 'user_warehouse.user_id', '=', 'return_sales.employId')

        ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')

        ->join('users', 'users.id', '=', 'return_sales.employId')
        
        /* ->join('products', 'products.id', '=', 'sale_details.productId') */

        ->select( /* 'products.name', */'return_sales.*','users.name as empName', 'inv_warehouse.warehouse_name')
        
        ->whereDate('return_sales.created_at',Carbon::today())

        
        /* ->orderBy('products.id', 'DESC') */
        // ->sum('warehouseproduct.quantity_in_hand');
        // return $productList;
        //->distinct()
        // ->get();

        ->get();
        

        return view('/return/salesList',compact('warehouses','return_sales'));
    }
    public function getAllSales(){

        /* $current = Carbon::today(); */
        /* return $current; */
        // $sum=0;
        // $salesSum=DB::table('sales')->select('sales.totalPrice')->get();
        // /* return $salesSum; */
        // foreach ($salesSum as $sale) {
        //     $sum=$sum+$sale->totalPrice;
        // }
        //return $sum;
        $warehouses=InvWarehouse::all();
         $sales = DB::table('sales')

        ->join('poscustomers', 'sales.customerId', '=', 'poscustomers.id')

        ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')

        ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
        
        ->join('users', 'users.id', '=', 'sales.employId')
        
        /* ->join('sale_details', 'sale_details.orderId', '=', 'sales.id') */
        
        /* ->join('products', 'products.id', '=', 'sale_details.productId') */
       
        ->select( /* 'products.name', */'sales.*','users.name as empName','poscustomers.firstName','poscustomers.lastName','poscustomers.contactNo', 'inv_warehouse.warehouse_name')
        
        ->where('sales.done',null)
        
        ->where('sales.token',null)
        
        /* ->whereDate('sales.created_at',Carbon::today()) */
        
        /* ->orderBy('products.id', 'DESC') */
        // ->sum('warehouseproduct.quantity_in_hand');
        // return $productList;
        //->distinct()
        // ->get();

        ->get(); 
        
        $returnSales=ReturnSale::all();
        
        /* return $sales; */
        return view('/sales/salesList',compact('sales','$warehouses','returnSales'));
    }
    public function getFilterDateSales(Request $request){
        $start = $request->start_date;
        
        $end   = $request->end_date;
        
        $warehouse=$request->warehouse;

        $biller=$request->biller;

        $warehouses=InvWarehouse::all();
        /* return $start;
        exit(); */
        /* $current = Carbon::today(); */
        /* return $current; */
        // $sum=0;
        // $salesSum=DB::table('sales')->select('sales.*')->whereBetween('created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])->get();
        // /* return $salesSum; */
        // foreach ($salesSum as $sale) {
        //     $sum=$sum+$sale->totalPrice;
        // }
        //return $sum;
        if($biller){
            $sales = DB::table('sales')

            ->join('poscustomers', 'sales.customerId', '=', 'poscustomers.id')
    
             ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')
    
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            
            ->join('users', 'users.id', '=', 'sales.employId')
    
            /* ->join('sale_details', 'sale_details.orderId', '=', 'sales.id') */
            
            /* ->join('products', 'products.id', '=', 'sale_details.productId') */
           
            ->select( /* 'products.name', */'sales.*','users.name as empName','poscustomers.firstName','poscustomers.lastName','poscustomers.contactNo', 'inv_warehouse.warehouse_name')
            
            ->whereBetween('sales.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
    
            ->where('inv_warehouse.id',$warehouse)
            
            ->where('sales.done',null)
            
            ->where('sales.token',null)

            ->where('sales.employId',$biller)
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
    
            ->get(); 
            
            $returnSales=ReturnSale::join('user_warehouse', 'user_warehouse.user_id', '=', 'return_sales.employId')
                                    ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
                                    ->select(DB::raw("SUM(return_sales.totalAmount) as total"))
                                    ->whereBetween('return_sales.created_at',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                                    ->where('inv_warehouse.id',$warehouse)
                                    ->where('return_sales.employId',$biller)
                                    ->get();
            
            // $salesId=DB::table('sales')
            //             ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')
            //             ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            //             ->select('sales.id')
            //             ->where('sales.done',1)
            //             ->where('inv_warehouse.id',$warehouse)
            //             ->whereBetween('sales.created_at',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
            //             ->get();
    
            // $total=0;
            //     for( $i=0; $i<sizeof($salesId); $i++){
            //         //return $id;
            //         $salesDetail=DB::table('sale_details')->select(DB::raw("SUM(totalPrice) as total"))
            //                     ->where('sale_details.orderId',$salesId[$i]->id)
            //                     ->get();
            //         $total=$total+$salesDetail[0]->total;
            //     }
            
            //return $returnSales;
            return view('/sales/salesList',compact('sales','warehouses','returnSales')); 
        }else{
            $sales = DB::table('sales')
    
            ->join('poscustomers', 'sales.customerId', '=', 'poscustomers.id')
    
             ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')
    
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            
            ->join('users', 'users.id', '=', 'sales.employId')
            
            /* ->join('sale_details', 'sale_details.orderId', '=', 'sales.id') */
            
            /* ->join('products', 'products.id', '=', 'sale_details.productId') */
           
            ->select( /* 'products.name', */'sales.*','users.name as empName','poscustomers.firstName','poscustomers.lastName','poscustomers.contactNo', 'inv_warehouse.warehouse_name')
            
            ->whereBetween('sales.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
    
            ->where('inv_warehouse.id',$warehouse)
            
            ->where('sales.done',null)
            
            ->where('sales.token',null)
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
    
            ->get(); 
            
            $returnSales=ReturnSale::join('user_warehouse', 'user_warehouse.user_id', '=', 'return_sales.employId')
                                    ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
                                    ->select(DB::raw("SUM(return_sales.totalAmount) as total"))
                                    ->whereBetween('return_sales.created_at',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                                    ->where('inv_warehouse.id',$warehouse)
                                    ->get();
            
            $salesId=DB::table('sales')
                        ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')
                        ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
                        ->select('sales.id')
                        ->where('sales.done',1)
                        ->where('inv_warehouse.id',$warehouse)
                        ->whereBetween('sales.created_at',[date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                        ->get();
    
            $total=0;
                for( $i=0; $i<sizeof($salesId); $i++){
                    //return $id;
                    $salesDetail=DB::table('sale_details')->select(DB::raw("SUM(totalPrice) as total"))
                                ->where('sale_details.orderId',$salesId[$i]->id)
                                ->get();
                    $total=$total+$salesDetail[0]->total;
                }
            
            //return $returnSales;
            return view('/sales/salesList',compact('sales','warehouses','returnSales','total'));
        }
    }
    public function getFilterDateReturnSales(Request $request){
        $start = $request->start_date;
        
        $end   = $request->end_date;
        
        $warehouse=$request->warehouse;

        $biller=$request->biller;

        $warehouses=InvWarehouse::all();
        
        if($biller){
            $return_sales = DB::table('return_sales')

             ->join('user_warehouse', 'user_warehouse.user_id', '=', 'return_sales.employId')
    
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            
            ->join('users', 'users.id', '=', 'return_sales.employId')
    
            /* ->join('sale_details', 'sale_details.orderId', '=', 'sales.id') */
            
            /* ->join('products', 'products.id', '=', 'sale_details.productId') */
           
            ->select( /* 'products.name', */'return_sales.*','users.name as empName', 'inv_warehouse.warehouse_name')
            
            ->whereBetween('return_sales.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
    
            ->where('inv_warehouse.id',$warehouse)
           
            ->where('return_sales.employId',$biller)
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
    
            ->get(); 
            
            return view('/return/salesList',compact('warehouses','return_sales'));
        }else{
            $return_sales = DB::table('return_sales')

            ->join('user_warehouse', 'user_warehouse.user_id', '=', 'return_sales.employId')

            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            
            ->join('users', 'users.id', '=', 'return_sales.employId')

            /* ->join('sale_details', 'sale_details.orderId', '=', 'sales.id') */
            
            /* ->join('products', 'products.id', '=', 'sale_details.productId') */
        
            ->select( /* 'products.name', */'return_sales.*','users.name as empName' , 'inv_warehouse.warehouse_name')
            
            ->whereBetween('return_sales.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])

            ->where('inv_warehouse.id',$warehouse)
         
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();

            ->get(); 
            
            return view('/return/salesList',compact('warehouses','return_sales'));
        }
    }
    public function printInvoice(Request $request){
        //return $request->id;
        $salesDetail= DB::table('sales')

            ->join('poscustomers', 'sales.customerId', '=', 'poscustomers.id')
            
            ->join('sale_details', 'sale_details.orderId', '=', 'sales.id')
            
            ->join('products', 'products.id', '=', 'sale_details.productId')
    
            ->select( 'sales.*','products.name','sale_details.orderId','sale_details.qty','sale_details.unitPrice','sale_details.totalPrice as itotal','poscustomers.firstName','poscustomers.lastName','poscustomers.contactNo')

            ->where('sale_details.orderId','=',$request->id)
            
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
    
            ->get(); 

            $deleteSales= DB::table('sales')

            ->join('delete_products_sales', 'delete_products_sales.orderId', '=', 'sales.id')
            
            ->join('products', 'products.id', '=', 'delete_products_sales.productId')
    
            ->select( 'products.name','delete_products_sales.qty')

            ->where('delete_products_sales.orderId','=',$request->id)
            
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
    
            ->get(); 
            return  [$salesDetail,$deleteSales ];
            //return Response::json(['salesDetail'=>$salesDetail,'deleteSales'=>$deleteSales , 'message'=>'updated'], 201 );
            //return $salesDetail;
    }
    
    public function printA4($id){
        //return $request->id;
        $salesDetail= DB::table('sales')

            ->join('poscustomers', 'sales.customerId', '=', 'poscustomers.id')
            
            ->join('sale_details', 'sale_details.orderId', '=', 'sales.id')
            
            ->join('products', 'products.id', '=', 'sale_details.productId')
    
            ->select( 'sales.*','products.name','sale_details.orderId','sale_details.qty','sale_details.unitPrice','sale_details.totalPrice as itotal','poscustomers.firstName','poscustomers.lastName','poscustomers.contactNo')

            ->where('sale_details.orderId','=',$id)
            
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
    
            ->get(); 

            // $deleteSales= DB::table('sales')

            // ->join('delete_products_sales', 'delete_products_sales.orderId', '=', 'sales.id')
            
            // ->join('products', 'products.id', '=', 'delete_products_sales.productId')
    
            // ->select( 'products.name','delete_products_sales.qty')

            // ->where('delete_products_sales.orderId','=',$id)
            
            // /* ->orderBy('products.id', 'DESC') */
            // // ->sum('warehouseproduct.quantity_in_hand');
            // // return $productList;
            // //->distinct()
            // // ->get();
    
            // ->get(); 
            //return  $salesDetail;
            $pdf = PDF::loadView('/sales/a4SalesInvoice/a4Print',compact('salesDetail'));
            return $pdf->stream();
            //return Response::json(['salesDetail'=>$salesDetail,'deleteSales'=>$deleteSales , 'message'=>'updated'], 201 );
            //return $salesDetail;
    }
        public function printA4Word($id){
        //return $request->id;
        $salesDetail= DB::table('sales')

            ->join('poscustomers', 'sales.customerId', '=', 'poscustomers.id')
            
            ->join('sale_details', 'sale_details.orderId', '=', 'sales.id')
            
            ->join('products', 'products.id', '=', 'sale_details.productId')
    
            ->select( 'sales.*','products.name','sale_details.orderId','sale_details.qty','sale_details.unitPrice','sale_details.totalPrice as itotal','poscustomers.firstName','poscustomers.lastName','poscustomers.contactNo')

            ->where('sale_details.orderId','=',$id)
            
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
    
            ->get(); 

            // $deleteSales= DB::table('sales')

            // ->join('delete_products_sales', 'delete_products_sales.orderId', '=', 'sales.id')
            
            // ->join('products', 'products.id', '=', 'delete_products_sales.productId')
    
            // ->select( 'products.name','delete_products_sales.qty')

            // ->where('delete_products_sales.orderId','=',$id)
            
            // /* ->orderBy('products.id', 'DESC') */
            // // ->sum('warehouseproduct.quantity_in_hand');
            // // return $productList;
            // //->distinct()
            // // ->get();
    
            // ->get(); 
            //return  $salesDetail;
            return view('/sales/a4SalesInvoice/a4PrintWord',compact('salesDetail'));
            //return $pdf->stream();
            //return Response::json(['salesDetail'=>$salesDetail,'deleteSales'=>$deleteSales , 'message'=>'updated'], 201 );
            //return $salesDetail;
    }
    
    public function printReturnInvoice(Request $request){
        //return $request->id;
        $returnSaleDetails= DB::table('return_sales')

            ->join('return_sale_details', 'return_sale_details.returnId', '=', 'return_sales.id')
            
            ->join('products', 'products.id', '=', 'return_sale_details.productId')
    
            ->select( 'return_sales.*','products.name','return_sale_details.returnId','return_sale_details.qty','return_sale_details.unitPrice','return_sale_details.price as itotal')

            ->where('return_sale_details.returnId','=',$request->id)
            
            /* ->orderBy('products.id', 'DESC') */
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
    
            ->get(); 

            return  $returnSaleDetails;
            //return Response::json(['salesDetail'=>$salesDetail,'deleteSales'=>$deleteSales , 'message'=>'updated'], 201 );
            //return $salesDetail;
    }
    public function productSaleReport(Request $request){

            $warehouses= DB::table('inv_warehouse')->select('*')->get();
            //return $warehouses;
            return view('/sales/salesWiseProduct',compact('warehouses'));
    }

    public function getFilterProductWiseSaleReport(Request $request){

        $product=$request->product;
        //return $product_id;
        $start = $request->start_date;
        
        $end   = $request->end_date;
        
        $warehouse=$request->warehouse;

        // $user=DB::table('user_warehouse')->select('*')->where('warehouse_id',$warehouse)->get();
        $cwarehouse=DB::table('inv_warehouse')->select('*')->where('id',$warehouse)->get();
        //return $warehouse;
        $warehouses=DB::table('inv_warehouse')->select('*')->get();
        $salesDetails=[];
        $saleqty=0;
        $prod_name="";
        $prod_code="";
     
        $salesDetail= DB::table('sales')

                ->join('sale_details', 'sale_details.orderId', '=', 'sales.id')

                ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')

                ->join('products', 'products.id', '=', 'sale_details.productId')
        
                ->select( 'sales.created_at','products.name','products.id as prodId','products.code as code',DB::raw('SUM(sale_details.qty) as qty'),'sale_details.unitPrice','sale_details.totalPrice as itotal')

                ->whereBetween('sales.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])

                ->where('user_warehouse.warehouse_id', $warehouse)

                ->where('products.name','LIKE', '%'.$product.'%')
                
                ->groupBy('products.name')

                ->get();  
         
       
        return view('/sales/salesWiseProduct',compact('salesDetail','warehouses','cwarehouse','start','end'));


    }

}
