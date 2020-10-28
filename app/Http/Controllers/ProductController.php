<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Customer;
use App\Product;
use App\Pcategory;
use App\Unit;
use App\AccountHead;
use App\Contact;


class ProductController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:inv-manage|admin');
       //$this->middleware('role:admin');
    }
     public function getWarehouseProduct(Request $request){
        
        $qtyBoy = DB::table('warehouseproduct')
                            
                            ->join('products','products.id','=','warehouseproduct.product_id')
                            ->select('products.name as product_name', 'products.id as product_id','warehouseproduct.quantity_in_hand')
                            ->where('products.id',$request->id)
                            ->where('warehouseproduct.warehouse_id','7')
                            ->get();
        $qtyGirl = DB::table('warehouseproduct')
                            
                            ->join('products','products.id','=','warehouseproduct.product_id')
                            ->select('products.name as product_name', 'products.id as product_id','warehouseproduct.quantity_in_hand')
                            ->where('products.id',$request->id)
                            ->where('warehouseproduct.warehouse_id','8')
                            ->get();
        $qtyIqbal = DB::table('warehouseproduct')
                            
                            ->join('products','products.id','=','warehouseproduct.product_id')
                            ->select('products.name as product_name', 'products.id as product_id','warehouseproduct.quantity_in_hand')
                            ->where('products.id',$request->id)
                            ->where('warehouseproduct.warehouse_id','9')
                            ->get();
        $qtyJohar = DB::table('warehouseproduct')
                            
                            ->join('products','products.id','=','warehouseproduct.product_id')
                            ->select('products.name as product_name', 'products.id as product_id','warehouseproduct.quantity_in_hand')
                            ->where('products.id',$request->id)
                            ->where('warehouseproduct.warehouse_id','10')
                            ->get();    
        return [$qtyBoy,$qtyGirl,$qtyIqbal,$qtyJohar];
    }
    
    public function getSearchProduct(Request $request){
        $products =Product::where('name','LIKE','%'.$request->name.'%')
                            ->orWhere('code','LIKE',$request->name.'%')
                            ->get();
        return $products;
    }
    public function getSearchProductList(Request $request){
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();
        $productList=[];
        if(isset($request->catId)){
            $productList = DB::table('products')

            -> where('products.categoryId',$request->catId)

            ->join('units', 'products.unitId', '=', 'units.id')

            ->leftJoin('warehouseproduct as warehouseproduct', 'warehouseproduct.product_id', '=', 'products.id')
            
            ->join('productcategories', 'productcategories.id', '=', 'products.categoryId')

            ->select( 'products.*','warehouseproduct.quantity_in_hand','units.name as unit','productcategories.name as category',DB::raw('SUM(quantity_in_hand) as quantity_in_hand'))
            // ->where('product_id','=','products.id')
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();

            ->get();
            
            //return $productList;
            //return $productList;

        }else{
        $productList = DB::table('products')

            -> where('products.id',$request->id)

            ->join('units', 'products.unitId', '=', 'units.id')

            ->leftJoin('warehouseproduct as warehouseproduct', 'warehouseproduct.product_id', '=', 'products.id')
            
            ->join('productcategories', 'productcategories.id', '=', 'products.categoryId')

            ->select( 'products.*','warehouseproduct.quantity_in_hand','units.name as unit','productcategories.name as category',DB::raw('SUM(quantity_in_hand) as quantity_in_hand'))
            // ->where('product_id','=','products.id')
            ->groupBy('products.id')
            ->orderBy('products.id', 'DESC')
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();

            ->get();

            // return $showdata;


            //return $productList;
            //return $productList;
        }
        return view('product/product_list',compact('productList','cats','subs'));
    }

    public function showModalData(Request $request)
    {   
        $showdata=DB::table('warehouseproduct')
        ->join('products','warehouseproduct.product_id','=','products.id')
        ->join('inv_warehouse','warehouseproduct.warehouse_id','=','inv_warehouse.id')
        ->select('inv_warehouse.warehouse_name as warehouse_name','products.name as prodName','warehouseproduct.quantity_in_hand as quantity')
        ->where('products.id','=',$request->id)
        ->get();

        return $showdata;

    }


    public function allProductList(){
        $productList = DB::table('products')
        
        ->join('units', 'products.unitId', '=', 'units.id')

        ->leftJoin('warehouseproduct as warehouseproduct', 'warehouseproduct.product_id', '=', 'products.id')
        
        ->join('productcategories', 'productcategories.id', '=', 'products.categoryId')

        ->select( 'products.*','warehouseproduct.quantity_in_hand','units.name as unit','productcategories.name as category',DB::raw('SUM(quantity_in_hand) as quantity_in_hand'))
        // ->where('product_id','=','products.id')
        ->groupBy('products.id')
        ->orderBy('products.id', 'DESC')
        // ->sum('warehouseproduct.quantity_in_hand');
        // return $productList;
        //->distinct()
        // ->get();

        ->get(); 
        return view('product/allProductList',compact('productList'));
    }
    public function productList(Request $request)
    {
        //return '$productList';
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();
        
            return view('product/product_list',compact('cats','subs')); 
        
    }
    public function getProductSubCategory($id)
    {
        //return '$productList';
        //$cats=Pcategory::where('pid','=',null)->get();
        $subcategory=Pcategory::where('pid','=',$id)->orderBy('pid','asc')->get();
        
            $view= view('product/renderView/subcat',compact('subcategory'))->render(); 

            return response($view);
        
    }
    
    public function getAddProduct()
    {
        //$accountHeads=AccountHead::all();
        $units=Unit::all();
        $category=Pcategory::all();
        return view('product/productForm',compact('units','category'));
    }
    public function addProduct(Request $request)
    {

        $this->validate($request, [
            'code'=>'unique:products,code',
            ],

            ['code.unique'=>'Code Already exist'
                ]
        );

        $product=new Product;
        if($request->code){
            $product->code=$request->code;   
        }else{
           $product->code='prod'.rand();    
        }
        
        $product->name=$request->name;
        $product->weight=$request->weight;
        $product->salePrice=$request->salePrice;
        $product->description=$request->description;
        if($request->subCategoryId){
            $product->categoryId=$request->subCategoryId;
        }else{
            $product->categoryId=$request->categoryId;
        }
        $product->categoryId=$request->categoryId;
        $product->unitId=$request->unit;
        $product->type=$request->type;
        $product->reorder_level=$request->rol;
        $product->reorder_quantity=$request->roq;
        $product->manfLeadTime=$request->mlt;
        $product->custLeadTime=$request->clt;
        
        $product->save();
       
        //return redirect('getAddProduct');
        return redirect('productList');
    }
    public function getEditProduct($id)
    {
        $products=Product::find($id);
        
        //return $products;
        $category=Pcategory::where('pid',null)->get();
        $subcategory=Pcategory::where('pid','!=',null)->orderBy('pid','asc')->get();
        
        $units=Unit::all();
       
        return view('product/productForm',compact('products','category','subcategory','units'));
    }
    public function editProduct(Request $request){


    if(Product::where('code','=',$request->code)->where('id','<>',$request->id)
          ->exists())
    {

       $this->validate($request, [
                'code'=>'required|unique:accounthead,code',
                ],
                [
                 'code.unique'=>'Code Already exist',
                ]);
        
    }
    $cat='';
    if($request->subCategoryId){
            $cat=$request->subCategoryId;
        }else{
            $cat=$request->categoryId;
        }
        
       Product::where('id','=',$request->id)->update(['name' => $request->name,
                'code'=>$request->code,
                'weight'=>$request->weight,
                'salePrice'=>$request->salePrice,
                'description' => $request->description,
                'unitId'=>$request->unit,
                'categoryId'=>$cat,
                'type'=>$request->type,
                'reorder_level'=>$request->rol,
                'reorder_quantity'=>$request->roq,
                'manfLeadTime'=>$request->mlt,
                'custLeadTime'=>$request->clt
                ]);
       return redirect('productList');
    }
}
