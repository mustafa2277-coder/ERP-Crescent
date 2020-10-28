<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Pcategory;
use DB;
use Response;
use App\Package;
use App\Poscustomer;
use Illuminate\Contracts\Support\Jsonable;
class APIController extends Controller
{

    /*
    public function __construct()
    {
        $this->middleware('jwt.auth');
        ///$this->middleware('role:admin');
    }
    */
    public function showProductCategories()
    {
        try{
            $data=Pcategory::all();
            $temp=$data;
            
            foreach($temp as $record)
            {
                if($record->pid==null)
                {
                    $record->pid="";
                }
                elseif($record->leaf==null)
                {
                    $record->leaf="";
                }

            } 
            
            /*
            $temp=[];
            $map = $data->map(function($items){
                $temp['id'] = $items->id;
                $temp['name'] = $items->name;
                $temp['created_at'] = "";
                $temp['updated_at'] = "";
                return $temp;
              });
            */
            return response()->json(['data'=>$temp,'status'=>'success','statuscode'=>'200']);
    

        }
        catch(\Exception $e){
            return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
        }
   
    }

    public function getCategoryProductDetail(Request $request)
    {
        try{
            
            $data=DB::table('productcategories')
                //->leftJoin('packages','packages.id','=','package_products.pkgId')
                ->leftJoin('products','products.categoryId','=','productcategories.id')
                ->leftJoin('package_products','package_products.prodId','=','products.id')
                ->select('products.id as prodId','products.name as prodName','products.salePrice as UnitPrice',
                        'package_products.qty as quantity','products.img_url as imageurl','products.description as product_description')
                ->where('productcategories.id','=',$request->catId)        
                ->paginate('50');
            

                            
                $data2=DB::table('productcategories')
                //->leftJoin('packages','packages.id','=','package_products.pkgId')
                ->leftJoin('products','products.categoryId','=','productcategories.id')
                ->leftJoin('package_products','package_products.prodId','=','products.id')
                ->select('products.id as prodId','products.name as prodName','products.salePrice as UnitPrice',
                        'package_products.qty as quantity','products.img_url as imageurl','products.description as product_description')
                ->where('productcategories.id','=',$request->catchildId)        
                ->paginate('50');

                $temp1=[];
                $map1 = $data->map(function($items){
                $temp1['prodId']=$items->prodId;
                $temp1['prodName'] = $items->prodName;
                $temp1['UnitPrice'] = $items->UnitPrice;
                if($items->quantity==null)
                    {
                        $temp1['quantity']="";
                    }
                else
                    {
                        $temp1['quantity'] = $items->quantity;
                    }
                $temp1['imageurl'] = $items->imageurl;
                $temp1['product_description'] = "";
                return $temp1;
                });
                
                
                $temp2=[];
                $map2 = $data2->map(function($items){
                    $temp2['prodId']=$items->prodId;
                    $temp2['prodName'] = $items->prodName;
                    $temp2['UnitPrice'] = $items->UnitPrice;
                    if($items->quantity==null)
                    {
                        $temp2['quantity']="";
                    }
                    else
                    {
                        $temp2['quantity'] = $items->quantity;
                    }
                    $temp2['imageurl'] = $items->imageurl;
                    $temp2['product_description'] = "";
                return $temp2;
                });
            

            
           // $data=Package::all();
            return response()->json(['data'=>$map1,'data2'=> $map2,'status'=>'success','statuscode'=>'200']);
            
        }

        catch(\Exception $e)
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }

    }









    public function getPackageName(Request $request)
    {
        try{
            /*
            $data=DB::table('package_products')
                ->leftJoin('packages','packages.id','=','package_products.pkgId')
                ->leftJoin('products','products.id','=','package_products.prodId')
                ->select('packages.name as PkgName','products.name as prodName','products.type as prodType',
                        'package_products.qty as quantity','products.id as prodId','packages.id as PkgId')
                ->where('products.id','=',$request->prodId)
                ->where('packages.id','=',$request->pkgId)        
                ->get();
            */
            $data=Package::all();
            $temp=[];
            $map = $data->map(function($items){
                $temp['id'] = $items->id;
                $temp['name'] = $items->name;
                $temp['created_at'] = "";
                $temp['updated_at'] = "";
                return $temp;
                });
                
            
            
            
            return response()->json(['data'=>$map,'status'=>'success','statuscode'=>'200']);
        }

        catch(\Exception $e)
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }

    }


    public function getPackageProductDetail(Request $request)
    {
        try{
            
            $data=DB::table('package_products')
                ->leftJoin('packages','packages.id','=','package_products.pkgId')
                ->leftJoin('products','products.id','=','package_products.prodId')
                ->select('products.id as prodId','products.name as prodName','products.salePrice as UnitPrice',
                        'package_products.qty as quantity','products.img_url as imageurl','products.description as product_description')
                ->where('package_products.pkgId','=',$request->pkgId)
                ->where('package_products.prodId','=',$request->prodId)        
                ->get();
                
                $temp=[];
                $map = $data->map(function($items){
                $temp['prodId'] = $items->prodId;
                $temp['prodName'] = $items->prodName;
                $temp['UnitPrice'] = $items->UnitPrice;
                $temp['quantity'] = $items->quantity;
                $temp['imageurl'] = $items->imageurl;
                $temp['product_description'] = "";
                return $temp;
                });
            



           // $data=Package::all();
            return response()->json(['data'=>$map,'status'=>'success','statuscode'=>'200']);
            


        }

        catch(\Exception $e)
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }

    }

    public function getPackageProductsWithDetail(Request $request)
    {
        try{
            
            $data=DB::table('package_products')
                //->leftJoin('packages','packages.id','=','package_products.pkgId')
                ->leftJoin('products','products.id','=','package_products.prodId')
                ->leftJoin('packages','packages.id','=','package_products.pkgId')
                ->select('products.id as prodId','products.name as prodName','products.salePrice as UnitPrice',
                        'package_products.qty as quantity','products.img_url as imageurl','products.description as product_description')
                ->where('package_products.pkgId','=',$request->pkgId)        
                ->get();
            
            
                $temp=[];
                $map = $data->map(function($items){
                $temp['prodId'] = $items->prodId;
                $temp['prodName'] = $items->prodName;
                $temp['UnitPrice'] = $items->UnitPrice;
                $temp['quantity'] = $items->quantity;
                $temp['imageurl'] = $items->imageurl;
                $temp['product_description'] = "";
                return $temp;
                });
            

            
           // $data=Package::all();
            return response()->json(['data'=>$map,'status'=>'success','statuscode'=>'200']);
            
        }

        catch(\Exception $e)
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }

    }






    public function insertSignupDetails(Request $request)
    {
        
        
        if(DB::table('poscustomers')->where('poscustomers.contactNo','=',$request->contactno)->exists())
        {
            $value=DB::table('poscustomers')
                    ->where('poscustomers.contactNo','=',$request->contactno)
                    ->get();
            $id=0;
            foreach($value as $record)
            {
                $id=$record->id;
            }
            
            $poscustomers=Poscustomer::find($id);

            $poscustomers->firstName=$request->firstname;
            $poscustomers->lastName=$request->lastname;
            $poscustomers->email=$request->email;
            $poscustomers->contactNo=$request->contactno;
            $poscustomers->password=bcrypt($request->password);
            $poscustomers->created_at=\Carbon\Carbon::now();
            $poscustomers->updated_at=\Carbon\Carbon::now();
            $poscustomers->save();

            return response()->json(['data'=>[],'status'=>'success','statuscode'=>'200']);

        }
        
        else
        {
            
            DB::table('poscustomers')->insert(
                ['firstName' => $request->firstname, 'lastName' => $request->lastname, 'email' => $request->email , 'contactNo' => $request->contactno , 'password' => bcrypt($request->password),'created_at' => \Carbon\Carbon::now(),'updated_at' => \Carbon\Carbon::now()]
            );

            $latestentered=DB::table('poscustomers')
                        ->select('poscustomers.firstName','poscustomers.lastName','poscustomers.email','poscustomers.contactNo','poscustomers.password')
                        ->latest()->first();
            return response()->json(['data'=>$latestentered,'status'=>'success','statuscode'=>'200']);
        }
        
        
    }

    public function PlaceMobileOrder(Request $request)
    {
        try
        {

            $data=json_decode($request->getContent(),true);
            //$data=$request->json()->all();
        
            $product_details = $data['Detail'];
            $date=date("Y/m/d");

            
            $id= DB::table('sales')
            ->insertGetId(['sales.totalPrice' => $data['totalPrice'], 'sales.subTotal' => $data['subTotal'],
                    'sales.customerId' => $data['customerId'] , 'sales.paid' => $data['paid'],
                    'sales.totalDiscount' => $data['totalDiscount'] , 'sales.previousBal' => '0',
                    'sales.chnge' => '0' , 'sales.paymentMethod' => $data['paymentMethod'],
                    'sales.order_type'=>$data['order_type'] , 'sales.date' => $date , 'sales.created_at' => \Carbon\Carbon::now() , 'sales.updated_at' => \Carbon\Carbon::now(),
                    'sales.packageId'=>$data['packageId'] , 'sales.address' => $data['address'] , 'sales.latitude' => $data['latitude'] , 'sales.longitude' => $data['longitude'],
                    'sales.contact' => $data['contact']             
                    ]);

            $saledata=DB::table('sales')
                    ->select('sales.totalPrice','sales.subTotal' ,
                    'sales.customerId' , 'sales.paid' ,
                    'sales.totalDiscount' , 'sales.previousBal',
                    'sales.chnge', 'sales.paymentMethod' ,
                    'sales.order_type', 'sales.date' , 'sales.created_at', 'sales.updated_at',
                    'sales.packageId', 'sales.address' , 'sales.latitude' , 'sales.longitude',
                    'sales.contact'              
                    )->where('sales.id','=',$id)
                    ->get();
            
        
        
        
            foreach($product_details as $values)
                {
                    /*
                    echo $id;
                    echo $values['productId'];
                    echo $values['qty'];
                    */
                
                    DB::table('sale_details')
                    ->insert(['sale_details.orderId' => $id , 'sale_details.productId' => $values['ItemId'],
                      'sale_details.qty' => $values['qty'] , 'sale_details.unitPrice' => $values['UnitPrice'] , 'sale_details.discountPer' => '0',
                      'sale_details.discount' => '0' , 'sale_details.totalPrice' => $values['TotalPrice']
                        ]);
                
                }
            
            
                $saledetailsdata=DB::table('sale_details')
                                ->select('sale_details.orderId', 'sale_details.productId',
                                'sale_details.qty' , 'sale_details.unitPrice' , 'sale_details.discountPer' ,
                                'sale_details.discount' , 'sale_details.totalPrice' )
                                ->where('sale_details.orderId','=',$id)
                                ->get();

            return response()->json(['data'=>[],'status'=>'success','statuscode'=>'200']);
        }

        
        catch(\Exception $e)
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }    
    }


    public function MobileShowOrderSales(Request $request)
    {

        try
        {
                $data=DB::table('poscustomers')
                        ->join('sales','sales.customerId','=','poscustomers.id')
                        ->select('sales.*')
                        ->where('sales.customerId','=',$request->customerId)
                        ->get();


                        $temp=[];
                        $map = $data->map(function($items){
                        $temp['order_status'] = "";
                        $temp['totalPrice'] = $items->totalPrice;
                        $temp['subTotal'] = $items->subTotal;
                        $temp['customerId'] = $items->customerId;
                        $temp['paid'] = $items->paid;
                        $temp['totalDiscount'] = $items->totalDiscount;
                        $temp['chnge'] = $items->chnge;
                        $temp['paymentMethod'] = $items->paymentMethod;
                        return $temp;
                        });
            
                        
                return response()->json(['data'=>$map,'status'=>'success','statuscode'=>'200']);
        }

    catch(\Exception $e)
    {
        return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
    }

    
    }


    public function MobileShowOrderSalesWithPackage(Request $request)
        {
            try 
                {
                    $data=DB::table('poscustomers')
                        ->join('sales','sales.customerId','=','poscustomers.id')
                        ->select('sales.packageId')
                        ->where('sales.customerId','=',$request->customerId)
                        ->where('sales.id','=',$request->saleId)
                        ->get();
                        //return $data;
                    $pkgId="";
                    //$testarray=[];
                    foreach($data as $index=>$value)
                        {
                            //$testarray[$index]=$value->packageId;
                            echo $value->packageId;
                            $pkgId=$value->packageId;
                        }
                        //$multipleids=explode(',',$pkgId);
                        //return $pkgId;
                    
                        if($pkgId=="")
                            {
                                echo "In If Part!!!";
                                $data=DB::table('poscustomers')
                                    ->join('sales','sales.customerId','=','poscustomers.id')
                                    ->join('sale_details','sale_details.orderId','=','sales.id')
                                    ->join('products','products.id','=','sale_details.productId')
                                    ->select('sale_details.*','products.name as prodName')
                                    ->where('poscustomers.id','=',$request->customerId)
                                    ->where('sale_details.orderId','=',$request->saleId)
                                    ->get();
                                    //return $data;
                                    return response()->json(['data'=>$data,'status'=>'success','statuscode'=>'200']);
                            
                            }

                        else
                            {
                                //return $multipleids[0];
                                echo "In Else Part!!!";
                                 $data=DB::table('poscustomers')
                                ->join('sales','sales.customerId','=','poscustomers.id')
                                ->select('sales.packageId')
                                ->where('sales.customerId','=',$request->customerId)
                                ->where('sales.id','=',$request->saleId)
                                ->get();
                                $pkgId="";
                                foreach($data as $value)
                                    {
                                        $pkgId=$value->packageId;
                                    }
                                $multipleids=explode(',',$pkgId);
                                $data=DB::table('poscustomers')
                                    ->join('sales','sales.customerId','=','poscustomers.id')
                                    ->join('sale_details','sale_details.orderId','=','sales.id')
                                    ->join('products','products.id','=','sale_details.productId')
                                    ->select('sales.order_status','products.name as prodName',
                                            'sale_details.qty as quantity','sale_details.unitPrice as UnitPrice','products.img_url as ImageUrl')
                                    ->where('poscustomers.id','=',$request->customerId)
                                    ->where('sale_details.orderId','=',$request->saleId)
                                    ->get();

                                  $data2[]="";
                                for($i=0; $i<sizeof($multipleids); $i++)
                                    {
                                        
                                        $result=DB::table('packages')
                                        ->select('packages.name as PackageName')
                                        ->where('packages.id','=',$multipleids[$i])
                                        ->get();
                                        $data2[$i]=$result;
                                    }
                                    
                                    $json= json_decode(json_encode($data2));
                                
                                return response()->json(['data'=>$data,'data2'=>$json,'status'=>'success','statuscode'=>'200']);
                                
                            }


                }

             catch(\Exception $e)
                {
                    return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
                }   
        }


}
