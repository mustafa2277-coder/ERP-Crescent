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
use Auth;
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
                            'product_id'         => $request->grnDetail[$i]['productName'],
                            'product_quantity'         => $request->grnDetail[$i]['ProductQuantity'],
                            'purchased_price'         => $request->grnDetail[$i]['ProductPrice'],
                            'purchased_currency'         => $request->grnDetail[$i]['PurchasedCurrency'],
                            'exchange_rate'         => $request->grnDetail[$i]['ExchangeRate'],
                            'price_in_pkr'         => $request->grnDetail[$i]['PriceInPkr'],
                            'user_created'         => $user->id
                        ];
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
        
        $invgrn->save();
        
         for ($i=0; $i <sizeof($request->grnDetail) ; $i++) {  
            $dataSet[$i] = [
                            'grn_id' => $invgrn->id,
                            'product_id'         => $request->grnDetail[$i]['productName'],
                            'product_quantity'         => $request->grnDetail[$i]['ProductQuantity'],
                            'purchased_price'         => $request->grnDetail[$i]['ProductPrice'],
                            'purchased_currency'         => $request->grnDetail[$i]['PurchasedCurrency'],
                            'exchange_rate'         => $request->grnDetail[$i]['ExchangeRate'],
                            'price_in_pkr'         => $request->grnDetail[$i]['PriceInPkr'],
                            'user_updated'         => $user->id
                        ];
            }
        
            InvGrnDetail::insert($dataSet);

            
        return Response::json(['success'=>'inserted'],201);
    }
    public function deleteGrnDetail(Request $request){
        $editGrnDetail=InvGrnDetail::find($request->id);
        $editGrnDetail->delete();
        return Response::json(['success'=>'inserted'],201);
    }
}

    