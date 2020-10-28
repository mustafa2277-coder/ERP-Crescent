<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvWarehouse;
use App\Customer;
use App\Project;
use App\Product;
use App\InvGrn;
use App\InvGrnDetail;
use App\User;
use App\Role;
use DB;
use Response;
use App\InvDeliveryChallan;
use App\InvDcDetail;
use App\InvStockTaking;
use App\InvStockTakingDetail;
use App\warehouseProduct;
use App\Unit;
use App\Pcategory;
use App\Package;
use App\PackageProduct;
use Auth;
use PDF;

class PackageController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:admin');
       //$this->middleware('role:admin');
    }
    public function packageList(){

        $packages = DB::table('packages')
        
        ->join('package_products', 'package_products.pkgId', '=', 'packages.id')

        ->select( 'packages.*')
       
        ->groupBy('package_products.pkgId')

        ->get(); 
        //return $packages;
        return view('package/productPackage',compact('packages'));
    }
    public function getAddProductPackage(){
        $pkgs=Package::all();
        //$products=Product::all();
        return view('package/addProductPackage',compact('pkgs'));
    }
    public function getEditProductPackage($id){
        //return $id;
        $pkgs=Package::all();
        // $products=Product::all();
        $packageProducts = DB::table('packages')
        
        ->join('package_products', 'package_products.pkgId', '=', 'packages.id')

        ->join('products', 'package_products.prodId', '=', 'products.id')

        ->select( 'packages.*','package_products.*','products.name as product_name', 'products.id as product_id')
       
        ->where('package_products.pkgId',$id)

        ->get(); 
        foreach ($packageProducts as $key => $product) {

        $qtyBoy[$key] = DB::table('warehouseproduct')
                            
                        ->join('products','products.id','=','warehouseproduct.product_id')
                        ->select('products.name as product_name', 'products.id as product_id','warehouseproduct.quantity_in_hand')
                        ->where('products.id',$product->product_id)
                        ->where('warehouseproduct.warehouse_id','7')
                        ->get();

        $qtyGirl[$key] = DB::table('warehouseproduct')
                        
                        ->join('products','products.id','=','warehouseproduct.product_id')
                        ->select('products.name as product_name', 'products.id as product_id','warehouseproduct.quantity_in_hand')
                        ->where('products.id',$product->product_id)
                        ->where('warehouseproduct.warehouse_id','8')
                        ->get();

        $qtyIqbal[$key] = DB::table('warehouseproduct')
                        
                        ->join('products','products.id','=','warehouseproduct.product_id')
                        ->select('products.name as product_name', 'products.id as product_id','warehouseproduct.quantity_in_hand')
                        ->where('products.id',$product->product_id)
                        ->where('warehouseproduct.warehouse_id','9')
                        ->get();

        $qtyJohar[$key] = DB::table('warehouseproduct')
                        
                        ->join('products','products.id','=','warehouseproduct.product_id')
                        ->select('products.name as product_name', 'products.id as product_id','warehouseproduct.quantity_in_hand')
                        ->where('products.id',$product->product_id)
                        ->where('warehouseproduct.warehouse_id','10')
                        ->get();  

        }
        // return Response::json(
        //     [
        //             'qtyBoy'=>$qtyBoy,
        //             'qtyGirl'=>$qtyGirl,
        //             'qtyIqbal'=>$qtyIqbal,
        //             'qtyJohar'=>$qtyJohar
        //     ] );
        // return [$qtyBoy,$qtyGirl,$qtyIqbal,$qtyJohar];
        //return $packageProducts;
        return view('package/addProductPackage',compact('pkgs','packageProducts','qtyBoy','qtyGirl','qtyIqbal','qtyJohar'));
    }
    public function insertProductPakcage(Request $request){
        
            if($request->id!=""){
                if(PackageProduct::where('pkgId',$request->id)->exists()&&$request->id!=$request->package_id){
                    return Response::json(['message'=>'exists'],201);
                }else{
                    PackageProduct::where('pkgId',$request->id)->delete();
                    for ($i=0; $i <$request->rowTotal; $i++){
                            
                        $pkgID=$request->package_id;
                        //return $pkgID;
                        $product=$request->product[$i];
                        $quantity=$request->quantity[$i];
                        $unit=$request->unit[$i];
                        $product_type=$request->product_type[$i];
                        $dataSet[$i] = [
                            'pkgId'         => $pkgID,
                            'prodId' => $product,
                            'qty' => $quantity,
                            'unit'=>$unit,
                            'product_type'=>$product_type

                        ];
            
                        
                    }
                    PackageProduct::insert($dataSet); 
                    return Response::json(['message'=>'inserted'],201); 
                }
            }else{
                if(PackageProduct::where('pkgId',$request->package_id)->exists()){
                    return Response::json(['message'=>'exists'],201);
                }else{
                    for ($i=0; $i <$request->rowTotal; $i++){
                        
                        $pkgID=$request->package_id;
                        //return $pkgID;
                        $product=$request->product[$i];
                        $quantity=$request->quantity[$i];
                        $unit=$request->unit[$i];
                        $product_type=$request->product_type[$i];
                        $dataSet[$i] = [
                            'pkgId'         => $pkgID,
                            'prodId' => $product,
                            'qty' => $quantity,
                            'unit'=>$unit,
                            'product_type'=>$product_type

                        ];
            
                        
                    }
                    
                    PackageProduct::insert($dataSet); 
                    return Response::json(['message'=>'inserted'],201); 
                }
            }
            

            
    }
}
