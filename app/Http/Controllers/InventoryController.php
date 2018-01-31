<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InvWarehouse;
use App\Customer;
use App\Project;
use App\Product;
use App\InvGrn;
use App\InvGrnDetail;
use App\User;
use DB;
use Response;
use App\InvDeliveryChallan;
use App\InvDcDetail;
use App\InvStockTaking;
use App\InvStockTakingDetail;
use App\warehouseProduct;
use App\Unit;
use App\Pcategory;
use Auth;
use PDF;
class InventoryController extends Controller
{
    public function warehouse_list(){
    	$warehouseList = InvWarehouse::all();
            
     	return view('/inventory/warehouseList')->with('warehouseList',$warehouseList);
    }
    public function warehouse_add(){

     	return view('/inventory/warehouseAdd');
    }

    public function addWarehouse(Request $request)
    {

        $this->validate($request, [
            'code'=>'required|unique:inv_warehouse,warehouse_code',
            ],

            ['code.unique'=>'Code Already exist'
                ]
        );
        $user=Auth::user();
        $warehouse=new InvWarehouse;
        $warehouse->warehouse_code=$request->code;
        $warehouse->warehouse_name=$request->name;
        $warehouse->warehouse_address=$request->address;
        $warehouse->warehouse_address2=$request->address2;
        $warehouse->warehouse_cityid=$request->city;
        $warehouse->warehouse_stateid=$request->state;
        $warehouse->warehouse_countryid=$request->country;
        $warehouse->warehouse_ph=$request->phone;
        $warehouse->warehouse_mobile=$request->mobile;
        $warehouse->user_created=$user->id;
        
        $warehouse->save();
       
        //return redirect('getAddProduct');
        return redirect('warehouse');
    }
    public function getEditWarehouse($id)
    {
        $warehouse=InvWarehouse::find($id);
       
        return view('inventory/warehouseAdd',compact('warehouse'));
    }
    public function editWarehouse(Request $request)
    {
    	$user=Auth::user();
        $warehouse=InvWarehouse::find($request->id);
        $warehouse->warehouse_code=$request->code;
        $warehouse->warehouse_name=$request->name;
        $warehouse->warehouse_address=$request->address;
        $warehouse->warehouse_address2=$request->address2;
        $warehouse->warehouse_cityid=$request->city;
        $warehouse->warehouse_stateid=$request->state;
        $warehouse->warehouse_countryid=$request->country;
        $warehouse->warehouse_ph=$request->phone;
        $warehouse->warehouse_mobile=$request->mobile;
        $warehouse->user_updated=$user->id;
        
        $warehouse->save();

        return redirect('warehouse');
        
    }




    public function grn_list(){
        $grnList = DB::table('inv_grn')
        
        ->join('inv_warehouse', 'inv_warehouse.id', '=', 'inv_grn.wareshouse_id')
        ->join('project', 'project.id', '=', 'inv_grn.project_id')
        ->join('customers', 'customers.id', '=', 'inv_grn.vendor_id')
        ->select('inv_grn.*','inv_warehouse.warehouse_name','project.title as project_title','customers.name as customers_name')
        ->get();   
        return view('/inventory/grnList',compact('grnList'));
    }
    public function grn_add(){
        $vendors=Customer::where("isVendor","on")
        ->select( 'customers.id','customers.name')
        ->get();
        $projects=Project::select('project.id','project.title')->get();
        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        $products=Product::select('products.id','products.name')->get();

        return view('/inventory/grnAdd',compact('vendors','projects','warehouses','products'));
    }




    public function insertGrn(Request $request){

        $invgrn=new InvGrn;
        $user=Auth::user();

        $invgrn->grn_no = $request->grn_no;
        $invgrn->bill_no = $request->bill_no;
        $invgrn->vendor_id = $request->Vendor;
        $invgrn->project_id = $request->project;
        $invgrn->wareshouse_id= $request->warehouse;
        $invgrn->grn_date= $request->grn_date;
        if ($request->isValidated) {
            $invgrn->grn_validatedby= $request->isValidated;
        }
        $invgrn->user_created=$user->id;
        
        $invgrn->save();
        
         for ($i=0; $i <sizeof($request->grnDetail) ; $i++) {  
            $dataSet[$i] = [
                            'grn_id' => $invgrn->id,
                            'product_id'         => $request->grnDetail[$i]['productId'],
                            'product_quantity'         => $request->grnDetail[$i]['ProductQuantity'],
                            'purchased_price'         => $request->grnDetail[$i]['ProductPrice'],
                            'purchased_currency'         => $request->grnDetail[$i]['PurchasedCurrency'],
                            'exchange_rate'         => $request->grnDetail[$i]['ExchangeRate'],
                            'price_in_pkr'         => $request->grnDetail[$i]['PriceInPkr'],
                            'user_created'         => $user->id
                        ];
            }
            for ($i=0; $i <sizeof($request->grnDetail) ; $i++) { 

                $product=warehouseProduct::where('product_id', $request->grnDetail[$i]['productId'])->get();
                // $totalQuantity=$request->grnDetail[$i]['ProductQuantity']+$product->quantity_in_hand;
                if (count($product)) {
                    
                    $totalQuantity=$request->grnDetail[$i]['ProductQuantity']+$product[0]->quantity_in_hand;
                    DB::table('warehouseproduct')
                    ->where('product_id', $request->grnDetail[$i]['productId'])
                    ->update(['quantity_in_hand' =>$totalQuantity]);
                    // DB::table('warehouseproduct')->increment('quantity_in_hand', $request->grnDetail[$i]['ProductQuantity'] , ['product_id' => $request->grnDetail[$i]['productName']]);
                }else {
                    $dataSetQ = [
                            'warehouse_id' => $request->warehouse,
                            'product_id'         => $request->grnDetail[$i]['productId'],
                            'quantity_in_hand'         => $request->grnDetail[$i]['ProductQuantity'],
                            
                        ];
                    warehouseProduct::insert($dataSetQ);
                }
                
            }
            InvGrnDetail::insert($dataSet);

            
            
        return Response::json(['success'=>'inserted'],201);
       
    }
    public function getEditGrn($id){
        $grn = DB::table('inv_grn')
        ->join('inv_grn_detail', 'inv_grn_detail.grn_id', '=', 'inv_grn.id')
        ->join('products', 'products.id', '=', 'inv_grn_detail.product_id')
        ->select('inv_grn.*','inv_grn.id as grnID','inv_grn_detail.*','products.name as pName')
        ->where('inv_grn_detail.grn_id','=',$id)
        ->get();

        $vendors=Customer::where("isVendor","on")->select( 'customers.id','customers.name')->get();
        $projects=Project::select('project.id','project.title')->get();
        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        $products=Product::select('products.id','products.name')->get();
        // return $grn;
        return view('inventory/grnAdd',compact('grn','vendors','projects','warehouses','products'));
    }
    public function editGrnDetail(Request $request){
        // return $request->id;
        $editGrnDetail=InvGrnDetail::find($request->id);
       
        return $editGrnDetail;

    }

     public function getGrnDetailBeforeDelete(Request $request){
        //return $request->id;
        $GrnDetail=InvGrnDetail::find($request->id);
        $product=warehouseProduct::where('product_id', $GrnDetail->product_id)->get();
        $totalQuantity=$product[0]->quantity_in_hand-$GrnDetail->product_quantity;
        DB::table('warehouseproduct')
        ->where('product_id', $GrnDetail->product_id)
        ->update(['quantity_in_hand' =>$totalQuantity]);
        return Response::json(['success'=>'true'],201);
    }



    public function updateGrn(Request $request){
        $dataSet=[];
        // $id=$request->GrnId;
        $user=Auth::user();
       $invgrn=InvGrn::find($request->GrnId);
        // $invgrn=InvGrn::where('id',$id)->get();
        // return $invgrn;
        $invgrn->grn_no = $request->grn_no;
        $invgrn->bill_no = $request->bill_no;
        $invgrn->vendor_id = $request->Vendor;
        $invgrn->project_id = $request->project;
        $invgrn->wareshouse_id= $request->warehouse;
        $invgrn->grn_date= $request->grn_date;
        if ($request->isValidated) {
            $invgrn->grn_validatedby= $request->isValidated;
        }
        $invgrn->user_updated=$user->id;
        
        // $invgrn->save();
        
         for ($i=0; $i <sizeof($request->grnDetail) ; $i++) {  
            $dataSet[$i] = [
                            'grn_id' => $invgrn->id,
                            'product_id'         => $request->grnDetail[$i]['productId'],
                            'product_quantity'         => $request->grnDetail[$i]['ProductQuantity'],
                            'purchased_price'         => $request->grnDetail[$i]['ProductPrice'],
                            'purchased_currency'         => $request->grnDetail[$i]['PurchasedCurrency'],
                            'exchange_rate'         => $request->grnDetail[$i]['ExchangeRate'],
                            'price_in_pkr'         => $request->grnDetail[$i]['PriceInPkr'],
                            'user_updated'         => $user->id
                        ];
            }

            for ($i=0; $i <sizeof($request->grnDetail) ; $i++) { 

                $product=warehouseProduct::where('product_id', $request->grnDetail[$i]['productId'])->get();
                // $totalQuantity=$request->grnDetail[$i]['ProductQuantity']+$product->quantity_in_hand;
                if (count($product)) {
                    
                    $totalQuantity1=$request->grnDetail[$i]['ProductQuantity']+$product[0]->quantity_in_hand;
                    // var_dump($totalQuantity);
                    // die();
                    DB::table('warehouseproduct')
                    ->where('product_id', $request->grnDetail[$i]['productId'])
                    ->update(['quantity_in_hand' =>$totalQuantity1]);
                    // DB::table('warehouseproduct')->increment('quantity_in_hand', $request->grnDetail[$i]['ProductQuantity'] , ['product_id' => $request->grnDetail[$i]['productName']]);
                }else {
                    $dataSetQ = [
                            'warehouse_id' => $request->warehouse,
                            'product_id'         => $request->grnDetail[$i]['productId'],
                            'quantity_in_hand'         => $request->grnDetail[$i]['ProductQuantity'],
                            
                        ];
                    warehouseProduct::insert($dataSetQ);
                }
                
            }
        
            InvGrnDetail::insert($dataSet);

            
        return Response::json(['success'=>'inserted'],201);
    }
    public function deleteGrnDetail(Request $request){
        $editGrnDetail=InvGrnDetail::find($request->id);
        $editGrnDetail->delete();
        return Response::json(['success'=>'inserted'],201);
    }




    public function challan_list(){
        $challanList = DB::table('inv_delivery_challan')
        ->join('inv_warehouse', 'inv_warehouse.id', '=', 'inv_delivery_challan.warehouse_id')
        ->join('project', 'project.id', '=', 'inv_delivery_challan.project_id')
        ->select('inv_delivery_challan.*','inv_warehouse.warehouse_name','project.title as project_title')
        ->get();  
         // return $challanList;
        return view('/inventory/challanList',compact('challanList'));
        // $warehouseList = InvWarehouse::all();
        return view('/inventory/challanList');
    }
    public function challan_add(){
       
        $projects=Project::select('project.id','project.title')->get();
        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        $products=Product::select('products.id','products.name')->get();

        return view('/inventory/challanAdd',compact('projects','warehouses','products'));
    }


    public function insertChallan(Request $request){
        $quantityCheck=0;
            for ($i=0; $i <sizeof($request->challanDetail) ; $i++) { 
                $temp=0;
                $product=warehouseProduct::where('product_id', $request->challanDetail[$i]['productId'])->get();
                
                if (count($product)) {
                    $quantityCheck=$product[0]->quantity_in_hand-$request->challanDetail[$i]['ProductQuantity'];
                   
                    if ($quantityCheck<0) {
                        return [1,$request->challanDetail[$i]['productName'],'You do not have much quantity ','in hand !!'];
                       return Response::json(['quantityCheck'=>'You do not have much quantity in hand !!'],201);
                    }
                }else{
                    return [$request->challanDetail[$i]['productName'],'You do not have much quantity ','in hand !!'];
                    
                }
                
            }
        // return $request->challanDetail[0]['productName'];
        $invchallan=new InvDeliveryChallan;
        $user=Auth::user();

        $invchallan->delivery_challan_no = $request->challan_no;
        $invchallan->project_id = $request->project;
        $invchallan->warehouse_id= $request->warehouse;
        $invchallan->delivery_challan_date= $request->challan_date;

        if ($request->isValidated) {
            $invchallan->delivery_challan_validatedby= $request->isValidated;
        }
        $invchallan->user_created=$user->id;
        
        $invchallan->save();
        
         for ($i=0; $i <sizeof($request->challanDetail) ; $i++) {  
            $dataSet[$i] = [
                            'delivery_challan_id' => $invchallan->id,
                            'product_id'         => $request->challanDetail[$i]['productId'],
                            'product_quantity'         => $request->challanDetail[$i]['ProductQuantity'],
                            'user_created'         => $user->id
                        ];
            }
            
            

            InvDcDetail::insert($dataSet);

            for ($i=0; $i <sizeof($request->challanDetail) ; $i++) { 
                $remainingQuantity=0;
                $product=warehouseProduct::where('product_id', $request->challanDetail[$i]['productId'])->get();
                // $totalQuantity=$request->grnDetail[$i]['ProductQuantity']+$product->quantity_in_hand;
                if (count($product)) {
                    
                    $remainingQuantity=$product[0]->quantity_in_hand-$request->challanDetail[$i]['ProductQuantity'];

                    DB::table('warehouseproduct')
                    ->where('product_id', $request->challanDetail[$i]['productId'])
                    ->update(['quantity_in_hand' =>$remainingQuantity]);
                    // DB::table('warehouseproduct')->increment('quantity_in_hand', $request->grnDetail[$i]['ProductQuantity'] , ['product_id' => $request->grnDetail[$i]['productName']]);
                }else {
                    $dataSetQ = [
                            'warehouse_id' => $request->warehouse,
                            'product_id'         => $request->challanDetail[$i]['productId'],
                            'quantity_in_hand'         => $request->challanDetail[$i]['ProductQuantity'],
                            
                        ];
                    warehouseProduct::insert($dataSetQ);
                }
                
            }


            

            
        return Response::json(['success'=>'inserted'],201);
       
    }
    public function getEditChallan($id){
        $challan = DB::table('inv_delivery_challan')
        ->join('inv_dc_detail', 'inv_dc_detail.delivery_challan_id', '=', 'inv_delivery_challan.id')
        ->join('products', 'products.id', '=', 'inv_dc_detail.product_id')
        ->select('inv_delivery_challan.*','inv_delivery_challan.id as challanID','inv_dc_detail.*','products.name as pName')
        ->where('inv_dc_detail.delivery_challan_id','=',$id)
        ->get();

        $projects=Project::select('project.id','project.title')->get();
        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        $products=Product::select('products.id','products.name')->get();
        // return $challan;
        return view('inventory/challanAdd',compact('challan','projects','warehouses','products'));
    }

    public function editChallanDetail(Request $request){
        // return $request->id;
        $editChallanDetail=InvDcDetail::find($request->id);
       
        return $editChallanDetail;

    }


     public function deleteChallanDetail(Request $request){
        $deleteChallanDetail=InvDcDetail::find($request->id);
        $deleteChallanDetail->delete();
        return Response::json(['success'=>'inserted'],201);
    }


    public function getChallanDetailBeforeDelete(Request $request){
        //return $request->id;
        $ChallanDetail=InvDcDetail::find($request->id);
        $product=warehouseProduct::where('product_id', $ChallanDetail->product_id)->get();
        $totalQuantity=$product[0]->quantity_in_hand+$ChallanDetail->product_quantity;
        DB::table('warehouseproduct')
        ->where('product_id', $ChallanDetail->product_id)
        ->update(['quantity_in_hand' =>$totalQuantity]);
        return Response::json(['success'=>'true'],201);
    }





    public function updateChallan(Request $request){
        //return $request->ChallanId;
        $quantityCheck=0;
        $dataSet=[];
            for ($i=0; $i <sizeof($request->challanDetail) ; $i++) { 
                $temp=0;
                $product=warehouseProduct::where('product_id', $request->challanDetail[$i]['productId'])->get();
                
                if (count($product)) {
                    $quantityCheck=$product[0]->quantity_in_hand-$request->challanDetail[$i]['ProductQuantity'];
                   
                    if ($quantityCheck<0) {
                        return [1,$request->challanDetail[$i]['productName'],'You do not have much quantity ','in hand !!'];
                       return Response::json(['quantityCheck'=>'You do not have much quantity in hand !!'],201);
                    }
                }
                
            }
        
        // return $request->challanDetail[0]['productName'];
        $user=Auth::user();
       $invchallan=InvDeliveryChallan::find($request->ChallanId);
       //return $invchallan;
        $invchallan->delivery_challan_no = $request->challan_no;
        $invchallan->project_id = $request->project;
        $invchallan->warehouse_id= $request->warehouse;
        $invchallan->delivery_challan_date= $request->challan_date;

        if ($request->isValidated) {
            $invchallan->delivery_challan_validatedby= $request->isValidated;
        }
        $invchallan->user_updated=$user->id;
        
        $invchallan->save();
        // return $invchallan->id;
         for ($i=0; $i <sizeof($request->challanDetail) ; $i++) {  
            $dataSet[$i] = [
                            'delivery_challan_id' => $invchallan->id,
                            'product_id'         => $request->challanDetail[$i]['productId'],
                            'product_quantity'         => $request->challanDetail[$i]['ProductQuantity'],
                            'user_updated'         => $user->id
                        ];
            }
        
            
            for ($i=0; $i <sizeof($request->challanDetail) ; $i++) { 
                $remainingQuantity=0;
                $product=warehouseProduct::where('product_id', $request->challanDetail[$i]['productId'])->get();
                // $totalQuantity=$request->grnDetail[$i]['ProductQuantity']+$product->quantity_in_hand;
                if (count($product)) {
                    
                    $remainingQuantity=$product[0]->quantity_in_hand-$request->challanDetail[$i]['ProductQuantity'];

                    DB::table('warehouseproduct')
                    ->where('product_id', $request->challanDetail[$i]['productId'])
                    ->update(['quantity_in_hand' =>$remainingQuantity]);
                    // DB::table('warehouseproduct')->increment('quantity_in_hand', $request->grnDetail[$i]['ProductQuantity'] , ['product_id' => $request->grnDetail[$i]['productName']]);
                }else {
                    $dataSetQ = [
                            'warehouse_id' => $request->warehouse,
                            'product_id'         => $request->challanDetail[$i]['productId'],
                            'quantity_in_hand'         => $request->challanDetail[$i]['ProductQuantity'],
                            
                        ];
                    warehouseProduct::insert($dataSetQ);
                }
                
            }

            InvDcDetail::insert($dataSet);

            
        return Response::json(['success'=>'inserted'],201);
       
    }
    public function stock_list(){
        $stockList = DB::table('inv_stock_taking')
        ->join('inv_warehouse', 'inv_warehouse.id', '=', 'inv_stock_taking.warehouse_id')
        ->select('inv_stock_taking.*','inv_warehouse.warehouse_name')
        ->get();  
         // return $challanList;
        return view('/inventory/stockList',compact('stockList'));
        return view('/inventory/stockList');
    }
    public function stock_add(){

        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        $products=Product::select('products.id','products.name')->get();

        return view('/inventory/stockAdd',compact('warehouses','products'));
    }
    public function insertStock(Request $request){
        $invstock=new InvStockTaking;
        $user=Auth::user();
        $invstock->warehouse_id= $request->warehouse;
        $invstock->stock_date= $request->stock_date;

        $invstock->user_created=$user->id;
        
        $invstock->save();
        
         for ($i=0; $i <sizeof($request->stockDetail) ; $i++) {  
            $dataSet[$i] = [
                            'stock_taking_id' => $invstock->id,
                            'product_id'         => $request->stockDetail[$i]['productId'],
                            'quantity_in_stock'         => $request->stockDetail[$i]['quantityInStock'],
                            'actual_quantity'         => $request->stockDetail[$i]['actualQuantity'],
                            'reason_of_diff'         => $request->stockDetail[$i]['reasonOfDifference'],
                            'user_created'         => $user->id
                        ];
            }
        
            InvStockTakingDetail::insert($dataSet);

            
        return Response::json(['success'=>'inserted'],201);
    }
    public function getEditStock($id){
        $stock = DB::table('inv_stock_taking')
        ->join('inv_stock_taking_detail', 'inv_stock_taking_detail.stock_taking_id', '=', 'inv_stock_taking.id')
        ->join('products', 'products.id', '=', 'inv_stock_taking_detail.product_id')
        ->select('inv_stock_taking.*','inv_stock_taking.id as stockID','inv_stock_taking_detail.*','products.name as pName')
        ->where('inv_stock_taking_detail.stock_taking_id','=',$id)
        ->get();

        
        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        $products=Product::select('products.id','products.name')->get();
        // return $challan;
        return view('inventory/stockAdd',compact('stock','warehouses','products'));
    }
    // public function editStockDetail(Request $request){
    //     // return $request->id;
    //     $InvStockTakingDetail=InvStockTakingDetail::find($request->id);
       
    //     return $InvStockTakingDetail;
    // }
    public function deleteStockDetail(Request $request){
        $InvStockTakingDetail=InvStockTakingDetail::find($request->id);
        $InvStockTakingDetail->delete();
        return Response::json(['success'=>'inserted'],201);
    }
    public function updateStock(Request $request){
        $dataSet=[];
        $user=Auth::user();
       $invstock=InvStockTaking::find($request->StockId);

        
        $invstock->warehouse_id= $request->warehouse;
        $invstock->stock_date= $request->stock_date;

        $invstock->user_updated=$user->id;
        
        $invstock->save();
        
         for ($i=0; $i <sizeof($request->stockDetail) ; $i++) {  
            $dataSet[$i] = [
                            'stock_taking_id' => $invstock->id,
                            'product_id'         => $request->stockDetail[$i]['productId'],
                            'quantity_in_stock'         => $request->stockDetail[$i]['quantityInStock'],
                            'actual_quantity'         => $request->stockDetail[$i]['actualQuantity'],
                            'reason_of_diff'         => $request->stockDetail[$i]['reasonOfDifference'],
                            'user_updated'         => $user->id
                        ];
                InvStockTakingDetail::where('id',$request->stockDetail[$i]['stockTakingDeatilId'])->update($dataSet[$i]);
            }
            
            // InvStockTakingDetail::insert();

            
        return Response::json(['success'=>'inserted'],201);
    }


    public function getStockDetail(Request $request){

        $products = DB::table('warehouseproduct')
        ->join('products', 'products.id', '=', 'warehouseproduct.product_id')
        ->select('warehouseproduct.*','products.name as pName')
        ->where('warehouseproduct.warehouse_id','=',$request->id)
        ->get();
        if ($products) {
            return $products;
         } 
         else{
            return [1];
         }
       
    }
    public function warehouseReport(){
        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        return view('/inventory/warehouseReport',compact('warehouses'));
    }
    public function getWarehouseReport(Request $request){
        $grnDeatils=[];
        $products = DB::table('warehouseproduct')
        ->join('inv_grn','inv_grn.wareshouse_id','=','warehouseproduct.warehouse_id')
        ->select('warehouseproduct.*','inv_grn.id as GRNID')
        ->where('warehouseproduct.warehouse_id','=',$request->id)
        ->get();
        for ($i=0; $i <sizeof($products) ; $i++) { 
            $grnDeatils = DB::table('inv_grn_detail')
            ->join('products','products.id','=','inv_grn_detail.product_id')
            ->join('units','units.id','=','products.unitId')
            ->select('products.*','products.name as pName','units.*','inv_grn_detail.*')
            ->where('inv_grn_detail.grn_id','=',$products[$i]->GRNID)
            ->get();
        }
        
        if ($products && $grnDeatils ) {

            // $result = array_merge($grnDeatils, $products);
            return  [$grnDeatils , $products];
         } 
         else{
            return [1];
         }
        
    }
    public function ProductsatReorderLevel(){
        $product = DB::table('warehouseproduct')
        ->join('products','products.id','=','warehouseproduct.product_id')
        ->select('warehouseproduct.*','products.*')
        
        ->get();
        for ($i=0; $i <sizeof($product) ; $i++) { 
            $productList = DB::table('warehouseproduct')
            ->join('products','products.id','=','warehouseproduct.product_id')
            ->select('warehouseproduct.*','products.*')
            ->where('warehouseproduct.quantity_in_hand','<=',$product[$i]->reorder_level)
            ->get();
        }

        return view('/inventory/ProductsAtReorderLevel',compact('productList'));
    }
    public function vendorsReport(){
        $vendors=Customer::select('customers.id','customers.name')->get();
        return view('/inventory/vendorReport',compact('vendors'));
    }
    public function getVendorReport(Request $request){
        // $productsQuantity=[];
        // $products = DB::table('inv_grn')
        // ->join('inv_grn_detail','inv_grn_detail.grn_id','=','inv_grn.id')
        // ->join('products','products.id','=','inv_grn_detail.product_id')
        // ->select('inv_grn_detail.product_quantity','inv_grn_detail.purchased_price','products.name as pName','products.id')
        // ->where('inv_grn.vendor_id','=',$request->id)
        // ->groupBy('product_id')
        // ->get();
        // for ($i=0; $i <sizeof($products) ; $i++) { 
        //     $productsQuantity = DB::table('inv_grn_detail')
        //     ->where('inv_grn_detail.product_id','=',$products[$i]->id)
        //     // ->groupBy('product_id')
        //     ->sum('product_quantity');
        //     // ->get();
        // }
        $products = DB::select( DB::raw("SELECT SUM(inv_grn_detail.`product_quantity`) AS 'sumqaunt', inv_grn_detail.*, products.name  FROM inv_grn_detail
                    JOIN products ON inv_grn_detail.`product_id`= products.`id`
                    JOIN inv_grn ON inv_grn.`id`=inv_grn_detail.`grn_id`
                    WHERE inv_grn.`vendor_id`=$request->id
                    GROUP BY product_id"));
        if($products){
            return $products;
        }
        else{
            return "false";
        }
        
    }
    public function productSummary(){
        $productsSummery = DB::table('products')
        ->join('units','units.id','=','products.unitId')
        ->join('productcategories','productcategories.id','=','products.categoryId')
        ->select('products.*','units.name as uName','productcategories.name as cName')
        ->get();
        $productcategories=Pcategory::select('productcategories.name','productcategories.id')->get();
        return view('/inventory/productSummary',compact('productsSummery','productcategories'));
    }
    public function productDeatil(){
        $productDeatil = DB::table('inv_grn_detail')
        ->join('products','products.id','=','inv_grn_detail.product_id')
        ->join('units','units.id','=','products.unitId')
        ->join('inv_grn','inv_grn.id','=','inv_grn_detail.grn_id')
        ->join('customers','customers.id','=','inv_grn.vendor_id')
        ->join('warehouseproduct','warehouseproduct.product_id','=','inv_grn_detail.product_id')
        ->select('products.name as pName','products.weight','units.name as uName','warehouseproduct.quantity_in_hand','customers.name as cName')
        ->get();
        return view('/inventory/productDeatil',compact('productDeatil'));
    }
    public function getProductSummaryByCategory(Request $request){
        $ProductSummaryByCategory = DB::table('products')
        ->join('units','units.id','=','products.unitId')
         ->join('productcategories','productcategories.id','=','products.categoryId')
        ->select('products.*','products.weight','units.name as uName','productcategories.name as cName')
        ->where('products.categoryId','=',$request->id)
        ->get();
           return $ProductSummaryByCategory;
        
        // return view('/inventory/productDeatil',compact('productDeatil'));
    }
    public function warehouseReportPdf(Request $request){
        $warehouseId=$request->id;
        $warehouse = DB::table('inv_warehouse')  
        ->select('inv_warehouse.warehouse_name')
        ->where('inv_warehouse.id','=', $warehouseId)
        ->get();
        $grnDeatils=[];
        $products = DB::table('warehouseproduct')
        ->join('inv_grn','inv_grn.wareshouse_id','=','warehouseproduct.warehouse_id')
        ->select('warehouseproduct.*','inv_grn.id as GRNID')
        ->where('warehouseproduct.warehouse_id','=',$request->id)
        ->get();
        for ($i=0; $i <sizeof($products) ; $i++) { 
            $grnDeatils = DB::table('inv_grn_detail')
            ->join('products','products.id','=','inv_grn_detail.product_id')
            ->join('units','units.id','=','products.unitId')
            ->select('products.*','products.name as pName','units.*','inv_grn_detail.*')
            ->where('inv_grn_detail.grn_id','=',$products[$i]->GRNID)
            ->get();
        }
        
        if ($products && $grnDeatils ) {
            $pdf = PDF::loadView('/inventory/warehouseReportPdf',compact('grnDeatils','products','warehouseId','warehouse'));
            return $pdf->stream();
            // $result = array_merge($grnDeatils, $products);
            return view('',compact('grnDeatils','products','warehouseId'));
            // view()->share('grnDeatils',$grnDeatils,'products',$products);
            // return  [ , ];
         }
        
    }
    public function productsatReorderLevelPdf(){
        $product = DB::table('warehouseproduct')
        ->join('products','products.id','=','warehouseproduct.product_id')
        ->select('warehouseproduct.*','products.*')
        
        ->get();
        for ($i=0; $i <sizeof($product) ; $i++) { 
            $productList = DB::table('warehouseproduct')
            ->join('products','products.id','=','warehouseproduct.product_id')
            ->select('warehouseproduct.*','products.*')
            ->where('warehouseproduct.quantity_in_hand','<=',$product[$i]->reorder_level)
            ->get();
        }
        $pdf = PDF::loadView('/inventory/productsatReorderLevelPdf',compact('productList'));
        return $pdf->stream();
        return view('/inventory/productsatReorderLevelPdf',compact('productList'));
    }
    public function vendorReportPdf(Request $request){
        $vendor = DB::table('customers')  
        ->select('customers.name')
        ->where('customers.id','=', $request->id)
        ->get();
        $products = DB::select( DB::raw("SELECT SUM(inv_grn_detail.`product_quantity`) AS 'sumqaunt', inv_grn_detail.*, products.name  FROM inv_grn_detail
                    JOIN products ON inv_grn_detail.`product_id`= products.`id`
                    JOIN inv_grn ON inv_grn.`id`=inv_grn_detail.`grn_id`
                    WHERE inv_grn.`vendor_id`=$request->id
                    GROUP BY product_id"));
        if($products){
             $pdf = PDF::loadView('/inventory/vendorReportPdf',compact('products','vendor'));
            return $pdf->stream();
        }
        
    }
    public function productSummaryPdf(){
        $productsSummery = DB::table('products')
        ->join('units','units.id','=','products.unitId')
        ->join('productcategories','productcategories.id','=','products.categoryId')
        ->select('products.*','units.name as uName','productcategories.name as cName')
        ->get();
        $pdf = PDF::loadView('/inventory/productSummaryPdf',compact('productsSummery'));
            return $pdf->stream();
    }
    public function productSummaryByCategoryPdf(Request $request){
        $productsSummery = DB::table('products')
        ->join('units','units.id','=','products.unitId')
         ->join('productcategories','productcategories.id','=','products.categoryId')
        ->select('products.*','products.weight','units.name as uName','productcategories.name as cName')
        ->where('products.categoryId','=',$request->id)
        ->get();
        $category = DB::table('productcategories')  
        ->select('productcategories.name')
        ->where('productcategories.id','=', $request->id)
        ->get();
        $pdf = PDF::loadView('/inventory/productSummaryPdf',compact('productsSummery','category'));
            return $pdf->stream();
    }
    public function productDetailPdf(){
        $productDeatil = DB::table('inv_grn_detail')
        ->join('products','products.id','=','inv_grn_detail.product_id')
        ->join('units','units.id','=','products.unitId')
        ->join('inv_grn','inv_grn.id','=','inv_grn_detail.grn_id')
        ->join('customers','customers.id','=','inv_grn.vendor_id')
        ->join('warehouseproduct','warehouseproduct.product_id','=','inv_grn_detail.product_id')
        ->select('products.name as pName','products.weight','units.name as uName','warehouseproduct.quantity_in_hand','customers.name as cName')
        ->get();
        $pdf = PDF::loadView('/inventory/productDetailPdf',compact('productDeatil'));
        return $pdf->stream();
    }
}

    