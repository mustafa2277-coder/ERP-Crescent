<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Pcategory;
use DB;
use Response;
use App\Package;
use App\Poscustomer;
use Validator;
use Illuminate\Contracts\Support\Jsonable;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;
use Auth;

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
            /*
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
            */
            
            $temp=[];
            $map = $data->map(function($items){
                $temp['id'] = $items->id;
                $temp['name'] = $items->name;
                if($items->pid==null)
                    {
                        $temp['pid']="";        
                    }
                else
                    {
                        $temp['pid']=$items->pid;
                    }
                if($items->leaf==null)
                    {
                        $temp['leaf']="";        
                    }
                else
                    {
                        $temp['leaf']=$items->leaf;
                    }
                $temp['created_at'] = "";
                $temp['updated_at'] = "";
                return $temp;
              });
            
            return response()->json(['data'=>$map,'status'=>'success','statuscode'=>'200']);
    

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
            //$data=Package::all();

            $data=DB::table('packages')
                ->select('packages.*')
                ->get();
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
    try 
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
            /*
            $poscustomers=Poscustomer::find($id);

            $poscustomers->firstName=$request->firstname;
            $poscustomers->lastName=$request->lastname;
            $poscustomers->email=$request->email;
            $poscustomers->contactNo=$request->contactno;
            $poscustomers->password=$request->password;
            $poscustomers->created_at=\Carbon\Carbon::now();
            $poscustomers->updated_at=\Carbon\Carbon::now();
            $poscustomers->save();
            */
            $object=[];
            $object=json_encode($object,JSON_FORCE_OBJECT);
            return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
        }
        
        else
        {
            
            DB::table('poscustomers')->insert(
                ['firstName' => $request->firstname, 'lastName' => $request->lastname, 'email' => $request->email , 'contactNo' => $request->contactno , 'password' => bcrypt($request->password),'address' ->$request->address,'created_at' => \Carbon\Carbon::now(),'updated_at' => \Carbon\Carbon::now()]
            );

            $latestentered=DB::table('poscustomers')
                        ->select('poscustomers.firstName','poscustomers.lastName','poscustomers.email','poscustomers.contactNo','poscustomers.password')
                        ->latest()->first();
            return response()->json(['data'=>$latestentered,'status'=>'success','statuscode'=>'200']);
        }
        
    }
    
    catch(\Exception $e)
    {
        return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
    }
}

    public function PlaceMobileOrder(Request $request)
    {
        //\Config::set('auth.providers.users.model', \App\Poscustomer::class);
       
        try
        {

            $data=json_decode($request->getContent(),true);
            //$data=$request->json()->all();
        
            $product_details = $data['Detail'];
            $date=date("Y/m/d");

            
            $userId=Auth::user()->id;

            if($data['customerId']!=$userId)
                {
                    $object=[];
                    $object=json_encode($object,JSON_FORCE_OBJECT);   
                    return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
                }
            
            else
                {
                    
                    $id= DB::table('sales')
                    ->insertGetId(['sales.totalPrice' => $data['totalPrice'], 'sales.subTotal' => $data['subTotal'],
                    'sales.customerId' => $data['customerId'] , 'sales.paid' => $data['paid'],
                    'sales.totalDiscount' => $data['totalDiscount'] , 'sales.previousBal' => '0',
                    'sales.chnge' => '0' , 'sales.paymentMethod' => $data['paymentMethod'],
                    'sales.order_type'=>$data['order_type'] , 'sales.date' => $date , 'sales.created_at' => \Carbon\Carbon::now() , 'sales.updated_at' => \Carbon\Carbon::now(),
                    'sales.packageId'=>$data['packageId'] , 'sales.address' => $data['address'] , 'sales.latitude' => $data['latitude'] , 'sales.longitude' => $data['longitude'],
                    'sales.contact' => $data['contact'],'sales.order_status' => $data['order_status']           
                    ]);

                    $saledata=DB::table('sales')
                    ->select('sales.totalPrice','sales.subTotal' ,
                    'sales.customerId' , 'sales.paid' ,
                    'sales.totalDiscount' , 'sales.previousBal',
                    'sales.chnge', 'sales.paymentMethod' ,
                    'sales.order_type', 'sales.date' , 'sales.created_at', 'sales.updated_at',
                    'sales.packageId', 'sales.address' , 'sales.latitude' , 'sales.longitude',
                    'sales.contact','sales.order_status'             
                    )->where('sales.id','=',$id)
                    ->get();
            
        
        
        
                    foreach($product_details as $values)
                        {
                            /*
                            echo $id;
                            echo $values['productId'];
                            echo $values['qty'];
                            */
                            if($values['pkg_flag']=='0')
                                {
                                    DB::table('sale_details')
                                    ->insert(['sale_details.orderId' => $id , 'sale_details.productId' => $values['ItemId'],
                                    'sale_details.qty' => $values['qty'] , 'sale_details.unitPrice' => $values['UnitPrice'] , 'sale_details.discountPer' => '0',
                                    'sale_details.discount' => '0' , 'sale_details.totalPrice' => $values['TotalPrice'],'sale_details.flag'=>$values['pkg_flag']
                                    ]);
                
                                }
                            elseif($values['pkg_flag']=='1')
                                {
                            
                                DB::table('sale_details')
                                ->insert(['sale_details.orderId' => $id , 'sale_details.packageId' => $values['ItemId'],
                                'sale_details.qty' => $values['qty'] , 'sale_details.unitPrice' => $values['UnitPrice'] , 'sale_details.discountPer' => '0',
                                'sale_details.discount' => '0' , 'sale_details.totalPrice' => $values['TotalPrice'],'sale_details.flag'=>$values['pkg_flag']
                                ]);
                                }
                            
                        }
            
            
                    $saledetailsdata=DB::table('sale_details')
                                ->select('sale_details.orderId', 'sale_details.productId','sale_details.packageId',
                                'sale_details.qty' , 'sale_details.unitPrice' , 'sale_details.discountPer' ,
                                'sale_details.discount' , 'sale_details.totalPrice' )
                                ->where('sale_details.orderId','=',$id)
                                ->get();

                     return response()->json(['data'=>[],'status'=>'success','statuscode'=>'200']);
        
                }
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


    public function SingleMobileShowOrderSalesWithPackage(Request $request)
        {
            try 
                {
                    $data=DB::table('poscustomers')
                        ->join('sales','sales.customerId','=','poscustomers.id')
                        ->select('sales.packageId')
                        //->where('sales.customerId','=',$request->customerId)
                        ->where('sales.id','=',$request->saleId)
                        ->get();
                    $pkgId="";
                    //$testarray=[];
                    foreach($data as $index=>$value)
                        {
                            //$testarray[$index]=$value->packageId;
                            //echo $value->packageId;
                            $pkgId=$value->packageId;
                        }
                        //$multipleids=explode(',',$pkgId);
                        //return $pkgId;
                    
                        if($pkgId=="")
                            {
                                $data=DB::table('poscustomers')
                                    ->join('sales','sales.customerId','=','poscustomers.id')
                                    ->join('sale_details','sale_details.orderId','=','sales.id')
                                    ->join('products','products.id','=','sale_details.productId')
                                    ->select('sale_details.*','products.name as prodName')
                                    //->where('poscustomers.id','=',$request->customerId)
                                    ->where('sale_details.orderId','=',$request->saleId)
                                    ->get();

                                    

                                    $temp=[];
                                    $map = $data->map(function($items){
                                    $temp['id'] = $items->id;
                                    $temp['orderId'] = $items->orderId;
                                    $temp['productId'] = $items->productId;
                                    $temp['qty'] = $items->qty;
                                    $temp['unitPrice'] = $items->unitPrice;
                                    $temp['discountPer'] = $items->discountPer;
                                    $temp['discount'] = $items->discount;
                                    $temp['totalPrice'] = $items->totalPrice;
                                    $temp['prodName'] = $items->prodName;
                                    $temp['created_at'] = "";
                                    $temp['updated_at'] = "";
                                    return $temp;
                                    });



                                    return response()->json(['data'=>$map,'status'=>'success','statuscode'=>'200']);
                            
                            }

                        else
                            {
                                //return $multipleids[0];
                                
                                 $data=DB::table('poscustomers')
                                ->join('sales','sales.customerId','=','poscustomers.id')
                                ->select('sales.packageId')
                                //->where('sales.customerId','=',$request->customerId)
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
                                    //->select('sales.order_status','products.name as prodName',
                                            //'sale_details.qty as quantity','sale_details.unitPrice as UnitPrice','products.img_url as ImageUrl')
                                    ->select('sale_details.*','products.name as prodName')        
                                    //->where('poscustomers.id','=',$request->customerId)
                                    ->where('sale_details.orderId','=',$request->saleId)
                                    ->get();
                                    
                                    
                                    $temp=[];
                                    $map = $data->map(function($items){
                                    $temp['id'] = $items->id;
                                    $temp['orderId'] = $items->orderId;
                                    $temp['productId'] = $items->productId;
                                    $temp['qty'] = $items->qty;
                                    $temp['unitPrice'] = $items->unitPrice;
                                    $temp['discountPer'] = $items->discountPer;
                                    $temp['discount'] = $items->discount;
                                    $temp['totalPrice'] = $items->totalPrice;
                                    $temp['prodName'] = $items->prodName;
                                    $temp['created_at'] = "";
                                    $temp['updated_at'] = "";
                                    return $temp;
                                    });

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
                                
                                return response()->json(['data'=>$map,'data2'=>$json,'status'=>'success','statuscode'=>'200']);
                                
                            }


                }

             catch(\Exception $e)
                {
                    return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
                }   
        }


    
        public function MultipleMobileShowOrderSalesWithPackage(Request $request)
        {
            \Config::set('auth.providers.users.model', \App\Poscustomer::class);
            try
                {
                    $userId=Auth::user()->id;

                    if($request->customerId!=$userId)
                        {
                            $object=[];
                            $object=json_encode($object,JSON_FORCE_OBJECT);   
                            return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
                        }
                    else
                        {
                            $map=[];
                            $map2=[];
                            $flag=DB::table('poscustomers')
                                            ->join('sales','sales.customerId','=','poscustomers.id')
                                            ->join('sale_details','sale_details.orderId','=','sales.id')
                                            //->join('products','products.id','=','sale_details.productId')
                                            ->select('sale_details.flag')
                                            ->where('poscustomers.id','=',$request->customerId)
                                            //->where('sale_details.orderId','=',$request->saleId)
                                            ->get();
        
        
                            foreach($flag as $flag)
                            {
                                if($flag->flag=='0')
                                    {
                                        
                                            $productdata=DB::table('poscustomers')
                                                ->join('sales','sales.customerId','=','poscustomers.id')
                                                ->join('sale_details','sale_details.orderId','=','sales.id')
                                                ->join('products','products.id','=','sale_details.productId')
                                                ->select('sale_details.*','products.name as prodName')
                                                ->where('poscustomers.id','=',$request->customerId)
                                                //->where('sale_details.orderId','=',$request->saleId)
                                                ->get();
        
                                            global $map;
                                            $temp=[];
                                            $map = $productdata->map(function($items){
                                            //$temp['id'] = $items->id;
                                            $temp['orderId'] = $items->orderId;
                                            //$temp['productId'] = $items->productId;
                                            //$temp['qty'] = $items->qty;
                                            //$temp['unitPrice'] = $items->unitPrice;
                                            //$temp['discountPer'] = $items->discountPer;
                                            //$temp['discount'] = $items->discount;
                                            $temp['totalPrice'] = $items->totalPrice;
                                            //$temp['prodName'] = $items->prodName;
                                            $temp['date'] = "";
                                            //$temp['updated_at'] = "";
                                            return $temp;
                                            });
            
                                    }
        
                                elseif($flag->flag=='1')
                                    {
                                        $packagedata=DB::table('poscustomers')
                                        ->join('sales','sales.customerId','=','poscustomers.id')
                                        ->join('sale_details','sale_details.orderId','=','sales.id')
                                        //->join('products','products.id','=','sale_details.productId')
                                        ->join('packages','packages.id','=','sale_details.packageId')
                                        ->select('sale_details.*','packages.name as PackageName')
                                        ->where('poscustomers.id','=',$request->customerId)
                                        //->where('sale_details.orderId','=',$request->saleId)
                                        ->get();
                                        //dd($packagedata);
                                        global $map2;
                                        $temp=[];
                                        $map2 = $packagedata->map(function($items){
                                        //$temp['id'] = $items->id;
                                        $temp['orderId'] = $items->orderId;
                                        //$temp['productId'] = $items->productId;
                                        //$temp['qty'] = $items->qty;
                                        //$temp['unitPrice'] = $items->unitPrice;
                                        //$temp['discountPer'] = $items->discountPer;
                                        //$temp['discount'] = $items->discount;
                                        $temp['totalPrice'] = $items->totalPrice;
                                        //$temp['prodName'] = $items->prodName;
                                        $temp['date'] = "";
                                        //$temp['updated_at'] = "";
                                        return $temp;
                                    });
        
                                    }
        
                            }
            
            
            
                                            return response()->json(['ProductData'=>$map,'PackageData'=>$map2,'status'=>'success','statuscode'=>'200']);
                                        
        
                        }
                    

                }
            
            
            catch(\Exception $e)
                {
                    return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
                }   
            
            /*
            try 
                {
                    
                    //return $request->customerId;
                    $data=DB::table('poscustomers')
                        ->join('sales','sales.customerId','=','poscustomers.id')
                        ->select('sales.packageId')
                        //->where('sales.customerId','=',$request->customerId)
                        ->where('poscustomers.id','=',$request->customerId)
                        //->where('sales.id','=',$request->saleId)
                        ->get();
                        //return $data;
                    $pkgId="";
                    //$testarray=[];
                    foreach($data as $index=>$value)
                        {
                            //$testarray[$index]=$value->packageId;
                            //echo $value->packageId;
                            $pkgId=$value->packageId;
                        }
                        //$multipleids=explode(',',$pkgId);
                        //return $pkgId;
                    
                        if($pkgId==0)
                            {
                                //echo "In If Part!";
                                $data=DB::table('poscustomers')
                                    ->join('sales','sales.customerId','=','poscustomers.id')
                                    ->join('sale_details','sale_details.orderId','=','sales.id')
                                    ->join('products','products.id','=','sale_details.productId')
                                    ->select('sale_details.*','products.name as prodName')
                                    ->where('poscustomers.id','=',$request->customerId)
                                    //->where('sale_details.orderId','=',$request->saleId)
                                    ->get();
                                //return $data;
                                
                                
                                $temp=[];
                                $map = $data->map(function($items){
                                $temp['id'] = $items->id;
                                $temp['orderId'] = $items->orderId;
                                $temp['productId'] = $items->productId;
                                $temp['qty'] = $items->qty;
                                $temp['unitPrice'] = $items->unitPrice;
                                $temp['discountPer'] = $items->discountPer;
                                $temp['discount'] = $items->discount;
                                $temp['totalPrice'] = $items->totalPrice;
                                $temp['prodName'] = $items->prodName;
                                $temp['created_at'] = "";
                                $temp['updated_at'] = "";
                                return $temp;
                                });




                                return response()->json(['data'=>$map,'status'=>'success','statuscode'=>'200']);
                            
                            }

                        else
                            {
                                //return $multipleids[0];
                                 //echo "In Else Part!";
                                 $data=DB::table('poscustomers')
                                ->join('sales','sales.customerId','=','poscustomers.id')
                                ->select('sales.packageId')
                                //->where('sales.customerId','=',$request->customerId)
                                ->where('poscustomers.id','=',$request->customerId)
                                //->where('sales.id','=',$request->saleId)
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
                                    //->select('sales.order_status','products.name as prodName',
                                      //      'sale_details.qty as quantity','sale_details.unitPrice as UnitPrice','products.img_url as ImageUrl')
                                      ->select('sale_details.*','products.name as prodName')
                                    ->where('poscustomers.id','=',$request->customerId)
                                    //->where('sale_details.orderId','=',$request->saleId)
                                    ->get();
                                    //return $data;
                                
                                    $temp=[];
                                    $map = $data->map(function($items){
                                    $temp['id'] = $items->id;
                                    $temp['orderId'] = $items->orderId;
                                    $temp['productId'] = $items->productId;
                                    $temp['qty'] = $items->qty;
                                    $temp['unitPrice'] = $items->unitPrice;
                                    $temp['discountPer'] = $items->discountPer;
                                    $temp['discount'] = $items->discount;
                                    $temp['totalPrice'] = $items->totalPrice;
                                    $temp['prodName'] = $items->prodName;
                                    $temp['created_at'] = "";
                                    $temp['updated_at'] = "";
                                    return $temp;
                                    });
    
                                
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
                                
                                return response()->json(['data'=>$map,'data2'=>$json,'status'=>'success','statuscode'=>'200']);
                                
                            }


                }

             catch(\Exception $e)
                {
                    return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
                }   
        */
        }


        public function SingleOrderDetail(Request $request)
        {
            //\Config::set('auth.providers.users.model', \App\Poscustomer::class);
            try
                {
                    $userId=Auth::user()->id;

                    if($request->customerId!=$userId)
                        {
                            $object=[];
                            $object=json_encode($object,JSON_FORCE_OBJECT);   
                            return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
       
                        }


                    else
                    {
                            
                    $TotalPrice=DB::table('poscustomers')
                    ->join('sales','sales.customerId','=','poscustomers.id')
                    //->join('sale_details','sale_details.orderId','=','sales.id')
                    //->join('products','products.id','=','sale_details.productId')
                    ->select('sales.totalPrice as TotalPrice')
                    ->where('poscustomers.id','=',$request->customerId)
                    ->where('sales.id','=',$request->saleId)
                    ->get();

                    $OrderId=DB::table('poscustomers')
                    ->join('sales','sales.customerId','=','poscustomers.id')
                    //->join('sale_details','sale_details.orderId','=','sales.id')
                    //->join('products','products.id','=','sale_details.productId')
                    ->select('sales.id as OrderId')
                    ->where('poscustomers.id','=',$request->customerId)
                    ->where('sales.id','=',$request->saleId)
                    ->get();

                    $Date=DB::table('poscustomers')
                    ->join('sales','sales.customerId','=','poscustomers.id')
                    //->join('sale_details','sale_details.orderId','=','sales.id')
                    //->join('products','products.id','=','sale_details.productId')
                    ->select('sales.date as Date')
                    ->where('poscustomers.id','=',$request->customerId)
                    ->where('sales.id','=',$request->saleId)
                    ->get();

                    $Discount=DB::table('poscustomers')
                    ->join('sales','sales.customerId','=','poscustomers.id')
                    //->join('sale_details','sale_details.orderId','=','sales.id')
                    //->join('products','products.id','=','sale_details.productId')
                    ->select('sales.totalDiscount as Discount')
                    ->where('poscustomers.id','=',$request->customerId)
                    ->where('sales.id','=',$request->saleId)
                    ->get();
                    
                    $DeliveryAddress=DB::table('poscustomers')
                    ->join('sales','sales.customerId','=','poscustomers.id')
                    //->join('sale_details','sale_details.orderId','=','sales.id')
                    //->join('products','products.id','=','sale_details.productId')
                    ->select('poscustomers.address as DeliveryAddress')
                    ->where('poscustomers.id','=',$request->customerId)
                    ->where('sales.id','=',$request->saleId)
                    ->get();
                    

                    
                    $flag=DB::table('poscustomers')
                    ->join('sales','sales.customerId','=','poscustomers.id')
                    ->join('sale_details','sale_details.orderId','=','sales.id')
                    //->join('products','products.id','=','sale_details.productId')
                    ->select('sale_details.flag as flag')
                    ->where('poscustomers.id','=',$request->customerId)
                    ->where('sales.id','=',$request->saleId)
                    ->get();
                    



                    $array=array();
                    foreach($TotalPrice as $value)
                    {
                        $array[0]=$value->TotalPrice;
                    }
                    foreach($OrderId as $value)
                    {
                        $array[1]=$value->OrderId;
                    }
                    foreach($Date as $value)
                    {
                        $array[2]=$value->Date;
                    }
                    foreach($Discount as $value)
                    {
                        $array[3]=$value->Discount;
                    }
                    foreach($DeliveryAddress as $value)
                    {
                        if($value->DeliveryAddress==null)
                            {
                                $array[4]="";
                            }
                        else
                            {
                                $array[4]=$value->DeliveryAddress;
                            }
                    }

                    foreach($flag as $flag)
                    {
                        if($flag->flag=='0')
                            {
                                
                            $ProductItems=DB::table('poscustomers')
                            ->join('sales','sales.customerId','=','poscustomers.id')
                            ->join('sale_details','sale_details.orderId','=','sales.id')
                            ->join('products','products.id','=','sale_details.productId')
                            //->join('packages','packages.id','=','sale_details.packageId')
                            //->select('sales.order_status','products.name as prodName',
                            //      'sale_details.qty as quantity','sale_details.unitPrice as UnitPrice','products.img_url as ImageUrl')
                            ->select('sale_details.flag as Flag','sale_details.qty as Quantity','sale_details.unitPrice as UnitPrice','products.name as ProductName')
                            ->where('poscustomers.id','=',$request->customerId)
                            ->where('sale_details.orderId','=',$request->saleId)
                            ->get();

                            }
                        elseif($flag->flag=='1')
                            {
                                
                                $PackageItems=DB::table('poscustomers')
                                ->join('sales','sales.customerId','=','poscustomers.id')
                                ->join('sale_details','sale_details.orderId','=','sales.id')
                                //->join('products','products.id','=','sale_details.productId')
                                ->join('packages','packages.id','=','sale_details.packageId')
                                //->select('sales.order_status','products.name as prodName',
                                //      'sale_details.qty as quantity','sale_details.unitPrice as UnitPrice','products.img_url as ImageUrl')
                                ->select('sale_details.flag as Flag','sale_details.qty as Quantity','sale_details.unitPrice as UnitPrice','packages.name as PackageName')
                                ->where('poscustomers.id','=',$request->customerId)
                                ->where('sale_details.orderId','=',$request->saleId)
                                ->get();
                                
                            }
                    }


                    return response()->json(['data'=>["TotalPrice"=>$array[0],'OrderId'=>$array[1],'Date'=>$array[2],'Discount'=>$array[3],'DeliveryAddress'=>$array[4],'ProductItems'=>$ProductItems,'PackageItems'=>$PackageItems],'status'=>'success','statuscode'=>'200']);
                

                }
                }

            catch(\Exception $e)
                {
                    return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
                }


        }
    
        
    public function ForgotPassword(Request $request)
    {
        try
            {
                if(DB::table('poscustomers')->where('poscustomers.email','=',$request->email)->exists())
                    {
                        //echo "We are inside condition!";

                        
                        DB::table('poscustomers')->where('poscustomers.email','=',$request->email)
                        ->update(
                        ['password' => "Hello Pakistan"]
                        );
                        return response()->json(['data'=>'We have reset your password.','status'=>'success','statuscode'=>'200']);
                    }
                else
                    {
                        return response()->json(['data'=>'No User Found!.','status'=>'failed','statuscode'=>'500']);
                    }
                
            }

        catch(\Exception $e)
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }
    }

        
    public function ChangePassword(Request $request)
    {
        try
            {
                if(DB::table('poscustomers')->where('poscustomers.email','=',$request->email)->exists())
                    {
                        //echo "We are inside condition!";

                        
                        DB::table('poscustomers')->where('poscustomers.email','=',$request->email)
                        ->update(
                        ['password' => $request->newpassword]
                        );
                        return response()->json(['data'=>'Your Password has been changed.','status'=>'success','statuscode'=>'200']);
                    }
                else
                    {
                        return response()->json(['data'=>'User not found.','status'=>'failed','statuscode'=>'500']);
                    }
                
            }

        catch(\Exception $e)
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }
    }


    public function Login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        
            try {
            /*
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
            */
            if(DB::table('poscustomers')->where('poscustomers.email','=',$request->email)->where('poscustomers.password','=',$request->password)->exists())
                {            
                    $userdata=DB::table('poscustomers')
                                ->select('poscustomers.*')
                                ->where('poscustomers.email','=',$request->email)
                                ->where('poscustomers.password','=',bcrypt($request->password))
                                ->get();

                    foreach($userdata as $record)
                        {
                            if($record->contactNo==null)
                                {
                                    $record->contactNo="";
                                }
                                
                            if($record->token==null)
                                {
                                    $record->token="";
                                }
                            
                            if($record->address==null)
                                {
                                    $record->address="";
                                }
                        }
                    return response()->json(['data'=>$userdata,'status'=>'success','statuscode'=>'200']);
                }
            else
                {
                    
                    $object=[];
                    $object=json_encode($object,JSON_FORCE_OBJECT);
                    return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
                }
            }
        
        
            catch (\Exception $e) {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }
        

    }

    public function TrackingOrderStatus(Request $request)
        {
            try
                {
                    $data=DB::table('poscustomers')
                    ->join('sales','sales.customerId','=','poscustomers.id')
                    //->join('sale_details','sale_details.orderId','=','sales.id')
                    //->join('products','products.id','=','sale_details.productId')
                    ->select('sales.order_status as OrderStatus')
                    ->where('poscustomers.id','=',$request->customerId)
                    ->where('sales.id','=',$request->saleId)
                    ->get();

                    return response()->json(['data'=>$data,'status'=>'success','statuscode'=>'200']);
                }
            
            catch (\Exception $e) 
                {
                    return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
                }
            
            

        }

    public function ChangeOrderTrackingStatus(Request $request)
        {
            try
                {
                    
                    //dd($request->order_status);
                    DB::table('sales')->where('sales.id','=',$request->saleId)
                    ->where('sales.customerId','=',$request->customerId)
                    ->update(
                    ['order_status' => $request->order_status]
                    );

                    return response()->json(['data'=>"Status Updated",'status'=>'success','statuscode'=>'200']);
                }
            
            catch (\Exception $e) 
                {
                    return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
                }
        }








}
