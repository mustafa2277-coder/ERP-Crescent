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
    public function productList()
    {
         $productList = DB::table('products')
        
            ->join('units', 'products.unitId', '=', 'units.id')
            
            ->join('productcategories', 'productcategories.id', '=', 'products.categoryId')

            ->select( 'products.*','units.name as unit','productcategories.name as category')
            
            //->distinct()

            //->get();

            ->get();
            //return $productList;
        return view('product/product_list')->with('productList',$productList);
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
        $product=new Product;
        $product->code=$request->code;
        $product->name=$request->name;
        $product->weight=$request->weight;
        $product->description=$request->description;
        $product->categoryId=$request->categoryId;
        $product->unitId=$request->unit;
        $product->type=$request->type;
        $product->manfLeadTime=date("Y-m-d",strtotime(str_replace('/', '-', $request->mlt)));
        $product->custLeadTime=date("Y-m-d",strtotime(str_replace('/', '-', $request->clt)));
        
        $product->save();
       
        //return redirect('getAddProduct');
        return redirect('productList');
    }
    public function getEditProduct($id)
    {
        $products=Product::find($id);
        $category = Pcategory::all();
        $units=Unit::all();
       
        return view('product/productForm',compact('products','category','units'));
    }
    public function editProduct(Request $request){
        
       Product::where('id','=',$request->id)->update(['name' => $request->name,
                'code'=>$request->code,
                'weight'=>$request->weight,
                'description' => $request->description,
                'unitId'=>$request->unit,
                'categoryId'=>$request->categoryId,
                'type'=>$request->type,
                'manfLeadTime'=>date("Y-m-d",strtotime(str_replace('/', '-', $request->mlt))),
                'custLeadTime'=>date("Y-m-d",strtotime(str_replace('/', '-', $request->clt)))
                ]);
       return redirect('productList');
        
    }
}
