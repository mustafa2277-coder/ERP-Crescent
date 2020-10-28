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
use App\TransferDetail;
use Carbon\Carbon;
use Auth;
use PDF;
use App\TransferNote;
class InventoryController extends Controller
{
    public function __construct()
    {
        
        //$this->middleware('role:inv-manage|admin');
        $this->middleware('auth');
            
       //$this->middleware('role:admin');
    }
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



    public function transfer_list()
    {
        $user=Auth::user();
        $role=$user->hasRole('admin'); 
        $vendors=Customer::where('isVendor','on')->get();
        $inv_warehouse=InvWarehouse::all();
        // $transfernotes= DB::table('inv_warehouse as inv1')
        //                 ->join('transfer_notes as t1','inv1.id' , '=' , 't1.from_warehouse_id')
        //                 ->join('transfer_notes as t2','inv1.id' , '=' , 't2.to_warehouse_id')
        //                 ->join('inv_warehouse as inv2','inv2.id' , '=' , 't2.to_warehouse_id')                        
        //                 ->select('inv1.warehouse_name as name1 ','inv2.warehouse_name as name2 ','t1.from_warehouse_quantity as from_quantity','t2.to_warehouse_quantity as to_quantity')
        //                 ->get();

        //$queryString='  ';

        //return $transfernotes;
        /*
        $datafirst=DB::table('transfer_notes')
                                    ->join('warehouseproduct','warehouseproduct.warehouse_id','=','transfer_notes.from_warehouse_id')
                                    ->join('products','products.id','=','warehouseproduct.product_id')
                                    ->select('transfer_notes.warehouse_name as from_warehouse','transfer_notes.created_at as today_date')
                                    ->whereDate('transfer_notes.created_at',Carbon::today())
                                    ->get();
            return $datafirst;
            */                            
                                                                        
        
        if($user->hasRole('admin') || $user->hasRole('inv-manage'))
        {
            
            $data=DB::table('transfer_notes')
            //->join('warehouseproduct','transfer_notes.to_warehouse_id','=','warehouseproduct.warehouse_id')
            //->join('transfer_details','transfer_details.transfer_notes_id','=','transfer_notes.id')
            //->join('products','products.id','=','transfer_details.product_id')
            //->join('transfer_details','transfer_details.to_warehouse_id','=','warehouseproduct.warehouse_id')
            //->select('transfer_notes.warehouse_name as from_warehouse_name','transfer_details.warehouse_name as to_warehouse_name','transfer_details.from_warehouse_quantity as from_quantity','transfer_details.to_warehouse_quantity as to_quantity','transfer_details.created_at as today_date')
            ->join('inv_warehouse','transfer_notes.to_warehouse_id','=','inv_warehouse.id')
            ->select('transfer_notes.warehouse_name as from_warehouse','inv_warehouse.warehouse_name as to_warehouse','transfer_notes.entry_date as today_date','transfer_notes.id as notes_id','transfer_notes.transfer_code')
            ->whereDate('transfer_notes.entry_date',Carbon::today())
            //->groupBy('products.name')
            //->groupBy('transfer_details.warehouse_name')
            //->select('transfer_details.warehouse_name as warehouse_name')
            //->get();
            ->get();
            //return $data;
            //return $data;

            
            
            
            
            return view('/inventory/transfernotes',compact('data','inv_warehouse'));
        }


        
    }

    public function viewtodaytransferedproducts($id)
    {
        $user=Auth::user();
        $role=$user->hasRole('admin'); 
        if($user->hasRole('admin') || $user->hasRole('inv-manage'))
        {
            //$transfer_details=TransferDetail::find($id);
            //$transfer_notes=TransferNote::find($id);
            //$product=Product::find($transfer_details->product_id);
            
            
            /*
            $data=DB::table('transfer_notes')
            //->join('warehouseproduct','transfer_notes.to_warehouse_id','=','warehouseproduct.warehouse_id')
            ->join('transfer_details','transfer_details.transfer_notes_id','=','transfer_notes.id')
            ->join('products','products.id','=','transfer_details.product_id')
            //->join('transfer_details','transfer_details.to_warehouse_id','=','warehouseproduct.warehouse_id')
            //->select('transfer_notes.warehouse_name as from_warehouse_name','transfer_details.warehouse_name as to_warehouse_name','transfer_details.from_warehouse_quantity as from_quantity','transfer_details.to_warehouse_quantity as to_quantity','transfer_details.created_at as today_date')
            ->select('transfer_notes.warehouse_name as from_warehouse','transfer_details.warehouse_name as to_warehouse'
                    ,'transfer_details.from_warehouse_quantity as from_quantity','transfer_details.to_warehouse_quantity as to_quantity'
                    ,'products.name as prodName','transfer_notes.entry_date as today_date',
                    'transfer_details.product_id as prodId',
                    'transfer_details.id as details_id','transfer_notes.id as notes_id',
                    'transfer_details.to_warehouse_id as to_id','transfer_notes.from_warehouse_id as from_id')
            ->where('transfer_details.id','=',$transfer_details->id)
            ->where('transfer_notes.id','=',$transfer_notes->id)
            ->groupBy('products.name')
            ->groupBy('transfer_details.warehouse_name')
            //->select('transfer_details.warehouse_name as warehouse_name')
            //->get();
            ->get();
            */
            //return $data;

            $transfer_notes=TransferNote::find($id);

            $ToWarehouse=InvWarehouse::find($transfer_notes->to_warehouse_id);


            $transfer_details=DB::table('transfer_notes')
            ->join('transfer_details','transfer_details.transfer_notes_id','=','transfer_notes.id')
            ->join('products','products.id','=','transfer_details.product_id')
            ->select('transfer_details.from_warehouse_quantity as from_quantity','transfer_details.to_warehouse_quantity as to_quantity','products.name as name')
            //->select('transfer_notes.warehouse_name as from_warehouse','transfer_notes.entry_date as today_date','transfer_notes.id as notes_id','transfer_notes.transfer_code')
            //->whereDate('transfer_notes.entry_date',Carbon::today())
            ->where('transfer_notes.id','=',$id)
            //->groupBy('products.name')
            //->groupBy('transfer_details.warehouse_name')
            //->select('transfer_details.warehouse_name as warehouse_name')
            //->get();
            ->get();
            //return $data;
            //return $data;
            
            //return $transfer_details;


            //return view('inventory.viewtodaytransferedproducts',compact('transfer_details','transfer_notes','product'));
                return view('inventory.viewtodaytransferedproducts',compact('transfer_notes','ToWarehouse','transfer_details'));
        }

    }

    public function filter_transfer_notes(Request $request)
    {
        $user=Auth::user();
        $role=$user->hasRole('admin'); 
        $vendors=Customer::where('isVendor','on')->get();
        $inv_warehouse=InvWarehouse::all();
        
        //dd("Start Date: " . $request->input('start_date_search') . " End Date: " . $request->input('end_date_search') . " From Warehouse: " . $request->input('from_warehouse_search') . " To Warehouse: " . $request->input('to_warehouse_search'));
        if($user->hasRole('admin') || $user->hasRole('inv-manage'))
        {
            /*
            $data=DB::table('transfer_notes')
            //->join('warehouseproduct','transfer_notes.to_warehouse_id','=','warehouseproduct.warehouse_id')
            ->join('transfer_details','transfer_details.to_warehouse_id','=','transfer_notes.to_warehouse_id')
            ->join('products','products.id','=','transfer_details.product_id')
            //->join('transfer_details','transfer_details.to_warehouse_id','=','warehouseproduct.warehouse_id')
            //->select('transfer_notes.warehouse_name as from_warehouse_name','transfer_details.warehouse_name as to_warehouse_name','transfer_details.from_warehouse_quantity as from_quantity','transfer_details.to_warehouse_quantity as to_quantity','transfer_details.created_at as today_date')
            ->select('transfer_notes.warehouse_name as from_warehouse','transfer_details.warehouse_name as to_warehouse','transfer_details.from_warehouse_quantity as from_quantity','transfer_details.to_warehouse_quantity as to_quantity','products.name as prodName','transfer_details.created_at as today_date')
            //->whereBetween('transfer_notes.created_at',[$request->input('start_date_search'),$request->input('end_date_search')])
            ->where('transfer_notes.warehouse_name','LIKE',''$request->input('from_warehouse_search'))
            ->where('transfer_details.warehouse_name','=',$request->input('to_warehouse_search'))
            ->groupBy('products.name')
            ->groupBy('transfer_details.warehouse_name')
            //->select('transfer_details.warehouse_name as warehouse_name')
            //->get();
            ->get();
            */
            $from_warehouse=$request->input('from_warehouse_search');
            $to_warehouse=$request->input('to_warehouse_search');

           // dd('From: ' . $from_warehouse . " To: " .$to_warehouse);

           $data=DB::table('transfer_notes')
           //->join('warehouseproduct','transfer_notes.to_warehouse_id','=','warehouseproduct.warehouse_id')
           //->join('transfer_details','transfer_details.transfer_notes_id','=','transfer_notes.id')
           //->join('products','products.id','=','transfer_details.product_id')
           //->join('transfer_details','transfer_details.to_warehouse_id','=','warehouseproduct.warehouse_id')
           //->select('transfer_notes.warehouse_name as from_warehouse_name','transfer_details.warehouse_name as to_warehouse_name','transfer_details.from_warehouse_quantity as from_quantity','transfer_details.to_warehouse_quantity as to_quantity','transfer_details.created_at as today_date')
           ->join('inv_warehouse','transfer_notes.to_warehouse_id','=','inv_warehouse.id')
           ->select('transfer_notes.warehouse_name as from_warehouse','inv_warehouse.warehouse_name as to_warehouse','transfer_notes.entry_date as today_date','transfer_notes.id as notes_id','transfer_notes.transfer_code')
           ->whereBetween('transfer_notes.entry_date',[$request->input('start_date_search'),$request->input('end_date_search')])
            ->where('transfer_notes.from_warehouse_id','=',$from_warehouse)
            ->where('transfer_notes.to_warehouse_id','=',$to_warehouse)
            //->select('transfer_details.warehouse_name as warehouse_name')
            ->get();
            //->toSql();
            

            //return $data;
            
            return view('/inventory/transferfilter',compact('inv_warehouse','data'));
        }




    }





    public function transfer_add()
    {
        $user=Auth::user();
        
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();

        $inv_warehouse=InvWarehouse::all();
        
        $transfer_notes_data = DB::table('products')

            ->join('warehouseproduct as warehouseproduct', 'warehouseproduct.product_id', '=', 'products.id')
            ->select( 'products.*','warehouseproduct.quantity_in_hand',DB::raw('SUM(quantity_in_hand) as quantity_in_hand'))
            // ->where('product_id','=','products.id')
            // ->sum('warehouseproduct.quantity_in_hand');
            // return $productList;
            //->distinct()
            // ->get();
            ->get();


        return view('/inventory/transferadd',compact('user','cats','subs','inv_warehouse','transfer_notes_data'));

    }

    public function transfer_credentials(Request $request)
    {
        
        // $product= Product::find($request->SearchProduct);

        // $warehouse=warehouseProduct::find($request->Warehouse);
    
        
                
        $quantity = DB::table('warehouseproduct')

            ->join('products', 'products.id', '=', 'warehouseproduct.product_id')

            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'warehouseproduct.warehouse_id')
            
            ->select( 'products.id as prodId','products.name','products.code','warehouseproduct.id as wpId ','warehouseproduct.quantity_in_hand as quantity_in_hand')
            
            ->where('warehouseproduct.product_id','=',$request->SearchProduct)

            ->where('warehouseproduct.warehouse_id','=',$request->Warehouse)

            ->get();
        
            $quantity_in_hand=0;
            foreach($quantity as $value)
                {
                   $quantity_in_hand= $value->quantity_in_hand;
                   break;
                }
            
            return $quantity_in_hand;
    }

    public function transfer_credentials_append(Request $request)
    {
        $warehouse= InvWarehouse::find($request->WarehouseTo);
        $warehouse_name=$warehouse->warehouse_name;
        
        $credentials=DB::table('warehouseproduct')

            ->join('products', 'products.id', '=', 'warehouseproduct.product_id')

            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'warehouseproduct.warehouse_id')
            
            ->select( 'products.id as prodId','products.name as productname','inv_warehouse.warehouse_name as warehousename','products.code','warehouseproduct.id as wpId ','warehouseproduct.quantity_in_hand as quantity_in_hand')
            
            ->where('warehouseproduct.product_id','=',$request->SearchProduct)

            ->where('warehouseproduct.warehouse_id','=',$request->Warehouse)

            ->get();
        
            $array = array(2);

            foreach($credentials as $value)
            {
               
                $array=[
                        'product' => $value->productname,
                        'warehouse' => $warehouse_name
                ];
                
            }

        return $array;
        
    }


    public function transfer_store(Request $request)
    {
        // echo "We are in transfer notes create function!" . $request->FromWarehouse . " " . $request->ToWarehouse . " " . $request->entry_date;
        $transfer_notes=new TransferNote();
        $inv_warehouse=InvWarehouse::find($request->FromWarehouse);
        
        $from_warehouse_name=$inv_warehouse->warehouse_name;

        $transfer_notes->from_warehouse_id=$request->FromWarehouse;
        //$date_format=Carbon::parse($request->EntryDate)->format('Y-m-d');
        $date_format= Carbon::createFromFormat('Y-m-d', $request->EntryDate)->format('Y-m-d');
        $transfer_notes->entry_date=$date_format;
        $transfer_notes->warehouse_name=$from_warehouse_name;
        $transfer_notes->to_warehouse_id=$request->ToWarehouse;
        $transfer_notes->transfer_code=time().''.rand(1,10000);
        $transfer_notes->save();

        $transfer_notes_id=$transfer_notes->id;
        //$transfer_details=json_decode($request->TranferDetails);
        
        $transfer_details=$request->TransferDetails;
        echo sizeof($transfer_details);
                
        for($i=0; $i<sizeof($transfer_details); $i++)
        {
            $obj = $request->TransferDetails[$i];
            $transfer_details_table=new TransferDetail();
            $to_inv_warehouse=InvWarehouse::find($request->ToWarehouse);
            $to_warehouse_name=$to_inv_warehouse->warehouse_name;

            
            $transfer_details_table->product_id= $obj['TransferSearchProduct'];
            $transfer_details_table->from_warehouse_quantity= $obj['TransferFromWarehouseQuantity'];
            $transfer_details_table->to_warehouse_quantity= $obj['TransferToWarehouseQuantity'];
            $transfer_details_table->to_warehouse_id=$request->ToWarehouse;
            $transfer_details_table->warehouse_name=$to_warehouse_name;
            $transfer_details_table->transfer_notes_id=$transfer_notes_id;
            $transfer_details_table->transfer_code=time().''.rand(1,10000);
            $transfer_details_table->save();

            /*
            $towarehouseproduct=warehouseProduct::find($request->ToWarehouse);

            $towarehouseproduct->quantity_in_hand=$towarehouseproduct->quantity_in_hand + $obj['TransferToWarehouseQuantity'];

            $towarehouseproduct->save();

            $fromwarehouseproduct=warehouseProduct::find($request->FromWarehouse);

            $fromwarehouseproduct->quantity_in_hand= $obj['TransferFromWarehouseQuantity'];
            
            $fromwarehouseproduct->save();
           */
          DB::table('warehouseproduct')
          ->where('warehouseproduct.product_id', $obj['TransferSearchProduct'])
          ->where('warehouseproduct.warehouse_id',$request->FromWarehouse)
          ->update(['warehouseproduct.quantity_in_hand' => $obj['TransferFromWarehouseQuantity']]);
        


          if(DB::table('warehouseproduct')
          ->select('warehouseproduct.*')
          ->where('warehouseproduct.product_id', $obj['TransferSearchProduct'])
          ->where('warehouseproduct.warehouse_id',$request->ToWarehouse)
          ->exists())  
          {
            DB::table('warehouseproduct')
            ->where('warehouseproduct.product_id', $obj['TransferSearchProduct'])
            ->where('warehouseproduct.warehouse_id',$request->ToWarehouse)
            ->update(['warehouseproduct.quantity_in_hand' => + $obj['TransferToWarehouseQuantity']]);
          }

          else
            {
                DB::table('warehouseproduct')
                ->insert(['warehouseproduct.quantity_in_hand' => $obj['TransferToWarehouseQuantity'],
                        'warehouseproduct.product_id' => $obj['TransferSearchProduct'],
                        'warehouseproduct.warehouse_id' => $request->ToWarehouse
                ]);
                    
            }
          
        }
        
        //return redirect()->back();
        //return $obj['TransferSearchProduct'];
        
    }









    public function grn_list(){
        $user=Auth::user();
        $role=$user->hasRole('admin'); 
        $vendors=Customer::where('isVendor','on')->get();
        //return [$role];
        /* $user = User::with('roles')->find($cuser->id);
        $roles = $user->roles; */
         if($user->hasRole('admin') || $user->hasRole('inv-manage')){
            $grnList = DB::table('inv_grn')
        
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'inv_grn.wareshouse_id')
            ->join('project', 'project.id', '=', 'inv_grn.project_id')
            ->join('customers', 'customers.id', '=', 'inv_grn.vendor_id')
            ->select('inv_grn.*','inv_warehouse.warehouse_name','project.title as project_title','customers.name as customers_name')
            ->whereDate('inv_grn.created_at',Carbon::today())
            ->get(); 
           
            return view('/inventory/grnList',compact('grnList','vendors')); 
        }else{
            $warehouseId=DB::table('user_warehouse')->select('user_warehouse.*')->where('user_id',$user->id)->get();
            //return  $warehouseId;
            $grnList = DB::table('inv_grn')
        
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'inv_grn.wareshouse_id')
            ->join('project', 'project.id', '=', 'inv_grn.project_id')
            ->join('customers', 'customers.id', '=', 'inv_grn.vendor_id')
            ->select('inv_grn.*','inv_warehouse.warehouse_name','project.title as project_title','customers.name as customers_name')
            ->where('inv_grn.wareshouse_id',$warehouseId[0]->warehouse_id)
            ->whereDate('inv_grn.created_at',Carbon::today())
            ->get(); 
            return view('/inventory/grnList',compact('grnList','vendors'));  
        }
       
         
       
    }
    
    public function getFilterGrn(Request $request){
        $user=Auth::user();

        $start = $request->start_date;
        
        $end   = $request->end_date;

        $vendor   = $request->vendor;
        //return $end;
        //$role=$user->hasRole('admin'); 
        $vendors=Customer::where('isVendor','on')->get();
        //return [$role];
        /* $user = User::with('roles')->find($cuser->id);
        $roles = $user->roles; */
        if($user->hasRole('admin') || $user->hasRole('inv-manage')){
            if($vendor){
                $grnList = DB::table('inv_grn')
            
                ->join('inv_warehouse', 'inv_warehouse.id', '=', 'inv_grn.wareshouse_id')
                ->join('project', 'project.id', '=', 'inv_grn.project_id')
                ->join('customers', 'customers.id', '=', 'inv_grn.vendor_id')
                ->select('inv_grn.*','inv_warehouse.warehouse_name','project.title as project_title','customers.name as customers_name')
                ->whereBetween('inv_grn.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                ->where('inv_grn.vendor_id',$vendor)
                ->get(); 
            }else{
                $grnList = DB::table('inv_grn')
            
                ->join('inv_warehouse', 'inv_warehouse.id', '=', 'inv_grn.wareshouse_id')
                ->join('project', 'project.id', '=', 'inv_grn.project_id')
                ->join('customers', 'customers.id', '=', 'inv_grn.vendor_id')
                ->select('inv_grn.*','inv_warehouse.warehouse_name','project.title as project_title','customers.name as customers_name')
                ->whereBetween('inv_grn.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
                
                ->get(); 
            }
            
           
            return view('/inventory/grnList',compact('grnList','vendors')); 
        }else{
            $warehouseId=DB::table('user_warehouse')->select('user_warehouse.*')->where('user_id',$user->id)->get();
            //return  $warehouseId;
            $grnList = DB::table('inv_grn')
        
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'inv_grn.wareshouse_id')
            ->join('project', 'project.id', '=', 'inv_grn.project_id')
            ->join('customers', 'customers.id', '=', 'inv_grn.vendor_id')
            ->select('inv_grn.*','inv_warehouse.warehouse_name','project.title as project_title','customers.name as customers_name')
            ->where('inv_grn.wareshouse_id',$warehouseId[0]->warehouse_id)
            ->whereBetween('sales.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])
            ->get(); 
            return view('/inventory/grnList',compact('grnList','vendors'));  
        }
       
         
       
    }
    public function grn_add(){
        $user=Auth::user();
        $chkroles = DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.id','=',$user->id)
                ->select('roles.id','roles.name')
                ->get();
        //return $chkroles;
        if($chkroles[0]->name=="admin"||$chkroles[0]->name=="inv-manage"){
            $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        }else{
           
            $warehouses = DB::table('user_warehouse')
            ->join('users', 'users.id', '=', 'user_warehouse.user_id')
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            ->where('users.id','=',$user->id)
            ->select('inv_warehouse.id','inv_warehouse.warehouse_name')
            ->get();
        }
       // return $warehouses;
        $vendors=Customer::where("isVendor","on")
                ->select( 'customers.id','customers.name')
                ->get();
        $projects=Project::select('project.id','project.title')->get();
        
        $products=Product::select('products.id','products.name','products.code')->get();

        return view('/inventory/grnAdd',compact('vendors','projects','warehouses','products'));
    }




    public function insertGrn(Request $request){
        $warehouseId=$request->warehouse;
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

                $temp =$request->grnDetail[$i]['productId'];
                $product = DB::select( DB::raw("SELECT * FROM warehouseproduct WHERE warehouse_id=$warehouseId AND product_id=$temp"));
                // $totalQuantity=$request->grnDetail[$i]['ProductQuantity']+$product->quantity_in_hand;
                // return $product;
                if (count($product)) {
                    
                    $totalQuantity=$request->grnDetail[$i]['ProductQuantity']+$product[0]->quantity_in_hand;
                    DB::statement("UPDATE `warehouseproduct` SET `quantity_in_hand` =$totalQuantity WHERE `warehouse_id` = $warehouseId AND `product_id` = $temp ;");

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
        $products=Product::select('products.id','products.name','products.code')->get();
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
        $warehouseId=InvGrn::where('id',$GrnDetail->grn_id)->get();
        $warehouseId=$warehouseId[0]->wareshouse_id;
        $temp=$GrnDetail->product_id;
        //return $temp;
        $product = DB::select( DB::raw("SELECT * FROM warehouseproduct WHERE warehouse_id=$warehouseId AND product_id=$temp"));

        $totalQuantity=$product[0]->quantity_in_hand-$GrnDetail->product_quantity;

        DB::statement("UPDATE `warehouseproduct` SET `quantity_in_hand` =$totalQuantity WHERE `warehouse_id` = $warehouseId AND `product_id` = $temp ;");

        return Response::json(['success'=>'true'],201);
    }



    public function updateGrn(Request $request){
        // return $request->grnDetail;
        $warehouseId=$request->warehouse;
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
        if($request->grnDetail){    
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
                $temp =$request->grnDetail[$i]['productId'];
                $product = DB::select( DB::raw("SELECT * FROM warehouseproduct WHERE warehouse_id=$warehouseId AND product_id=$temp"));
                
                if (count($product)) {
                    
                    $totalQuantity1=$request->grnDetail[$i]['ProductQuantity']+$product[0]->quantity_in_hand;
                    // var_dump($totalQuantity);
                    // die();
                    DB::statement("UPDATE `warehouseproduct` SET `quantity_in_hand` =$totalQuantity1 WHERE `warehouse_id` = $warehouseId AND `product_id` = $temp ;");
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
        }
            
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
        $user=Auth::user();
        $chkroles = DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.id','=',$user->id)
                ->select('roles.id','roles.name')
                ->get();
        //return $chkroles;
        if($chkroles[0]->name=="admin"||$chkroles[0]->name=="inv-manage"){
            $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        }else{
           
            $warehouses = DB::table('user_warehouse')
            ->join('users', 'users.id', '=', 'user_warehouse.user_id')
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            ->where('users.id','=',$user->id)
            ->select('inv_warehouse.id','inv_warehouse.warehouse_name')
            ->get();
        }
        $products=Product::select('products.id','products.name')->get();

        return view('/inventory/challanAdd',compact('projects','warehouses','products'));
    }


    public function insertChallan(Request $request){
        $warehouseId=$request->warehouse;
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
                $temp=$request->challanDetail[$i]['productId'];
                $remainingQuantity=0;
                $product = DB::select( DB::raw("SELECT * FROM warehouseproduct WHERE warehouse_id=$warehouseId AND product_id=$temp"));
                // $totalQuantity=$request->grnDetail[$i]['ProductQuantity']+$product->quantity_in_hand;
                if (count($product)) {
                    
                    $remainingQuantity=$product[0]->quantity_in_hand-$request->challanDetail[$i]['ProductQuantity'];
                    DB::statement("UPDATE `warehouseproduct` SET `quantity_in_hand` =$remainingQuantity WHERE `warehouse_id` = $warehouseId AND `product_id` = $temp ;");

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
        $user=Auth::user();
        $chkroles = DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.id','=',$user->id)
                ->select('roles.id','roles.name')
                ->get();
        //return $chkroles;
        if($chkroles[0]->name=="admin"||$chkroles[0]->name=="inv-manage"){
            $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        }else{
           
            $warehouses = DB::table('user_warehouse')
            ->join('users', 'users.id', '=', 'user_warehouse.user_id')
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            ->where('users.id','=',$user->id)
            ->select('inv_warehouse.id','inv_warehouse.warehouse_name')
            ->get();
        }
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
        // $ChallanDetail=InvDcDetail::find($request->id);
        // $product=warehouseProduct::where('product_id', $ChallanDetail->product_id)->get();
        // $totalQuantity=$product[0]->quantity_in_hand+$ChallanDetail->product_quantity;
        // DB::table('warehouseproduct')
        // ->where('product_id', $ChallanDetail->product_id)
        // ->update(['quantity_in_hand' =>$totalQuantity]);

        $ChallanDetail=InvDcDetail::find($request->id);
        $warehouseId=InvDeliveryChallan::where('id',$ChallanDetail->delivery_challan_id)->get();
        $warehouseId=$warehouseId[0]->wareshouse_id;
        $temp=$ChallanDetail->product_id;
        $product = DB::select( DB::raw("SELECT * FROM warehouseproduct WHERE warehouse_id=$warehouseId AND product_id=$temp"));
        $totalQuantity=$product[0]->quantity_in_hand+$ChallanDetail->product_quantity;

        DB::statement("UPDATE `warehouseproduct` SET `quantity_in_hand` =$totalQuantity WHERE `warehouse_id` = $warehouseId AND `product_id` = $temp ;");
        return Response::json(['success'=>'true'],201);
    }





    public function updateChallan(Request $request){
        //return $request->ChallanId;
        $warehouseId=$request->warehouse;
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
                $temp=$request->challanDetail[$i]['productId'];
                $remainingQuantity=0;
                $product = DB::select( DB::raw("SELECT * FROM warehouseproduct WHERE warehouse_id=$warehouseId AND product_id=$temp"));
                                                    
                if (count($product)) {
                    
                    $remainingQuantity=$product[0]->quantity_in_hand-$request->challanDetail[$i]['ProductQuantity'];

                    DB::statement("UPDATE `warehouseproduct` SET `quantity_in_hand` =$remainingQuantity WHERE `warehouse_id` = $warehouseId AND `product_id` = $temp ;");

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

        $user=Auth::user();
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();
        $chkroles = DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.id','=',$user->id)
                ->select('roles.id','roles.name')
                ->get();
        //return $chkroles;
        if($chkroles[0]->name=="admin"||$chkroles[0]->name=="inv-manage"){
            $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        }else{
           
            $warehouses = DB::table('user_warehouse')
            ->join('users', 'users.id', '=', 'user_warehouse.user_id')
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            ->where('users.id','=',$user->id)
            ->select('inv_warehouse.id','inv_warehouse.warehouse_name')
            ->get();
        }
        $products=Product::select('products.id','products.name')->get();

        return view('/inventory/stockAdd',compact('warehouses','products','cats','subs'));
    }
    public function insertStock(Request $request){
        $invstock=new InvStockTaking;
        $user=Auth::user();
        //return $user;
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
            if($request->stockDetail[$i]['actualQuantity']!=""){
                warehouseProduct::where('product_id', $request->stockDetail[$i]['productId'])
                        ->where('warehouse_id', $request->warehouse)
                        ->update(['quantity_in_hand' => $request->stockDetail[$i]['actualQuantity']]);

            }
            

        }
            
        
            InvStockTakingDetail::insert($dataSet);

            
        return Response::json(['success'=>'inserted'],201);
    }
    public function getEditStock($id){
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();
        $stock = DB::table('inv_stock_taking')
        ->join('inv_stock_taking_detail', 'inv_stock_taking_detail.stock_taking_id', '=', 'inv_stock_taking.id')
        ->join('products', 'products.id', '=', 'inv_stock_taking_detail.product_id')
        ->select('inv_stock_taking.*','inv_stock_taking.id as stockID','inv_stock_taking_detail.*','products.name as pName' ,'products.code as pCode','products.salePrice as price')
        ->where('inv_stock_taking_detail.stock_taking_id','=',$id)
        ->get();

       
        $user=Auth::user();
        $chkroles = DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.id','=',$user->id)
                ->select('roles.id','roles.name')
                ->get();
        //return $chkroles;
        if($chkroles[0]->name=="admin"||$chkroles[0]->name=="inv-manage"){
            $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        }else{
           
            $warehouses = DB::table('user_warehouse')
            ->join('users', 'users.id', '=', 'user_warehouse.user_id')
            ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')
            ->where('users.id','=',$user->id)
            ->select('inv_warehouse.id','inv_warehouse.warehouse_name')
            ->get();
        }
        $products=Product::select('products.id','products.name')->get();
        // return $challan;
        return view('inventory/stockAdd',compact('stock','warehouses','products','cats','subs'));
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
        $cat=$request->cat;
        $sub=$request->sub;
        $id=$request->id;
        $product = DB::table('warehouseproduct')
            ->join('products', 'products.id', '=', 'warehouseproduct.product_id')

            ->select('warehouseproduct.*','products.name as pName','products.code as pCode','products.salePrice as price');

            if($cat!='null'&&$sub=='null'){

                $product->where('products.categoryId',  $cat)->where('warehouseproduct.warehouse_id','=',$id);
            }
            elseif($sub!='null'&&$cat=='null'){

                $product->where('products.categoryId',  $sub)->where('warehouseproduct.warehouse_id','=',$id); 
            }

            elseif($sub!='null'&&$cat!='null'){
     
                $product->where('products.categoryId',  $cat)->orWhere('products.categoryId',  $sub)->where('warehouseproduct.warehouse_id','=',$id);
            }

            elseif($sub=='null'&&$cat=='null'){
                $product->where('warehouseproduct.warehouse_id','=',$id);
            }

        $products=$product->get();
        
        if ($products) {

            return $products;
         } 
         else{
            return [1];
         }
       
    }
    public function warehouseReport(){
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();
        $products=[];
        $products1=[];
        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        return view('/inventory/warehouseReport',compact('warehouses','cats','subs','products','products1'));
    }
    public function getWarehouseReport(Request $request){
        // $grnDeatils=[];
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();
        $warehouses=InvWarehouse::select('inv_warehouse.id','inv_warehouse.warehouse_name')->get();
        $products = DB::table('warehouseproduct')
        ->join('inv_grn_detail','inv_grn_detail.product_id','=','warehouseproduct.product_id')
        ->join('products','products.id','=','warehouseproduct.product_id')
        ->join('units','units.id','=','products.unitId')
        ->join('productcategories', 'productcategories.id', '=', 'products.categoryId')
        ->select('products.weight','products.name as pName','products.code as pCode','warehouseproduct.*','inv_grn_detail.purchased_price','productcategories.name as category','units.name as uName','products.id as pId' )
        ->where('warehouseproduct.warehouse_id','=',$request->report_warehouse)
        ->where('productcategories.id','=',$request->cat)
        //->Where('productcategories.id','=',$request->sub)
        ->groupBy('warehouseproduct.id')
        ->get();
        if($request->sub){
        $products1 = DB::table('warehouseproduct')
        ->join('inv_grn_detail','inv_grn_detail.product_id','=','warehouseproduct.product_id')
        ->join('products','products.id','=','warehouseproduct.product_id')
        ->join('units','units.id','=','products.unitId')
        ->join('productcategories', 'productcategories.id', '=', 'products.categoryId')
        ->select('products.weight','products.name as pName','products.code as pCode','warehouseproduct.*','inv_grn_detail.purchased_price','productcategories.name as category','units.name as uName','products.id as pId' )
        ->where('warehouseproduct.warehouse_id','=',$request->report_warehouse)
        //->where('productcategories.id','=',$request->cat)
        ->Where('productcategories.id','=',$request->sub)
        ->groupBy('warehouseproduct.id')
        ->get();
        //return $products;
            return view('/inventory/warehouseReport',compact('warehouses','cats','subs','products','products1'));
         }else{
             $products1=[];
            return view('/inventory/warehouseReport',compact('warehouses','cats','subs','products','products1'));
         }
        
        
    }
    public function ProductsatReorderLevel(){
        $product = DB::table('warehouseproduct')
        ->join('products','products.id','=','warehouseproduct.product_id')
        ->select('warehouseproduct.*','products.*')
        
        ->get();
        // return sizeof($product);
        for ($i=0; $i <sizeof($product) ; $i++) { 
            $productList = DB::table('warehouseproduct')
            ->join('products','products.id','=','warehouseproduct.product_id')
            ->select('warehouseproduct.*','products.*',DB::raw('SUM(quantity_in_hand) as quantity_in_hand'))
            ->where('warehouseproduct.quantity_in_hand','<=',$product[$i]->reorder_level)
            ->groupBy('warehouseproduct.id')
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
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();

        return view('/inventory/productDeatil',compact('cats','subs'));
    }
    public function productDeatilFilter(Request $request){

        $cat=$request->cat;
        $sub=$request->sub;
        $cats=Pcategory::where('pid','=',null)->get();
        $subs=Pcategory::where('pid','!=',null)->get();
        $product = DB::table('inv_grn_detail')
        ->join('inv_grn','inv_grn.id','=','inv_grn_detail.grn_id')
        ->join('customers','customers.id','=','inv_grn.vendor_id')
        ->join('warehouseproduct','warehouseproduct.warehouse_id','=','inv_grn.wareshouse_id')
        ->join('products','products.id','=','warehouseproduct.product_id')
        ->join('productcategories','productcategories.id','=','products.categoryId')
        ->join('units','units.id','=','products.unitId')
        ->select(/* 'products.name as pName','products.purchasePrice','productcategories.name as categoryName','products.weight' */'productcategories.name as categoryName','products.*','units.name as uName','warehouseproduct.quantity_in_hand','customers.name as cName');
        // ->groupBy('inv_grn_detail.id')
        if($cat!='null'&&$sub=='null'){

                $product->where('products.categoryId',  $cat);
            }
            elseif($sub!='null'&&$cat=='null'){

                $product->where('products.categoryId',  $sub); 
            }

            elseif($sub!='null'&&$cat!='null'){
     
                $product->where('products.categoryId',  $cat)->orWhere('products.categoryId',  $sub);
            }

 
        $product->groupBy('warehouseproduct.id');

        $productDeatil=$product->get();
        //return $productDeatil;

        return view('/inventory/productDeatil',compact('productDeatil','cats','subs'));
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
        $products = DB::table('warehouseproduct')
        ->join('inv_grn_detail','inv_grn_detail.product_id','=','warehouseproduct.product_id')
        ->join('products','products.id','=','warehouseproduct.product_id')
        ->join('units','units.id','=','products.unitId')

        ->select('products.weight','products.name as pName','warehouseproduct.*','inv_grn_detail.purchased_price','units.name as uName','products.id as pId' )
        ->where('warehouseproduct.warehouse_id','=',$request->id)
        ->groupBy('warehouseproduct.id')
        ->get();

        // return $products;
        
        if ($products) {
            $pdf = PDF::loadView('/inventory/warehouseReportPdf',compact('products','warehouseId','warehouse'));
            return $pdf->stream();
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
            ->select('warehouseproduct.*','products.*',DB::raw('SUM(quantity_in_hand) as quantity_in_hand'))
            ->where('warehouseproduct.quantity_in_hand','<=',$product[$i]->reorder_level)
            ->groupBy('warehouseproduct.id')
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
        ->join('inv_grn','inv_grn.id','=','inv_grn_detail.grn_id')
        ->join('customers','customers.id','=','inv_grn.vendor_id')
        ->join('warehouseproduct','warehouseproduct.warehouse_id','=','inv_grn.wareshouse_id')
        ->join('products','products.id','=','warehouseproduct.product_id')
        ->join('units','units.id','=','products.unitId')
        ->select('products.name as pName','products.weight','units.name as uName','warehouseproduct.quantity_in_hand','customers.name as cName')
        // ->groupBy('inv_grn_detail.id')
        ->groupBy('warehouseproduct.id')
        
        ->get();
        $pdf = PDF::loadView('/inventory/productDetailPdf',compact('productDeatil'));
        return $pdf->stream();
    }
    public function productGRNReport(){
        $warehouses= DB::table('inv_warehouse')->select('*')->get();
        //return $warehouses;
        return view('/inventory/productWiseGRN',compact('warehouses'));
    }
    // public function productGRNReport(){
    //     $warehouses= DB::table('inv_warehouse')->select('*')->get();
    //     //return $warehouses;
    //     return view('/inventory/productWiseGRN',compact('warehouses'));
    // }
    public function getFilterProductWiseGRNReport(Request $request){

        $product_id=$request->product_id;
       
        $start = $request->start_date;
        
        $end   = $request->end_date;
        
        $warehouse=$request->warehouse;

        //$user=DB::table('user_warehouse')->select('*')->where('warehouse_id',$warehouse)->get();

        $cwarehouse=DB::table('inv_warehouse')->select('*')->where('id',$warehouse)->get();
        // //return $warehouse;
        $warehouses=DB::table('inv_warehouse')->select('*')->get();
        //$grnDetails=[];
        $grnproductqty=0;
        $prod_name="";
        $prod_code="";
        //$saleDeatil[]=[];
        //return $user;
        // for ($i=0; $i <sizeof($user) ; $i++) {  
            
            $grnDetails= DB::table('inv_grn')

                ->join('inv_grn_detail', 'inv_grn_detail.grn_id', '=', 'inv_grn.id')

                ->join('products', 'products.id', '=', 'inv_grn_detail.product_id')
        
                ->select( 'inv_grn.created_at','inv_grn.id','inv_grn.grn_date','products.name','products.id as prodId','products.code as code','inv_grn_detail.product_quantity','inv_grn_detail.purchased_price as unitPrice','inv_grn_detail.price_in_pkr as itotal')

                ->whereBetween('inv_grn.created_at', [date("Y-m-d",strtotime(str_replace('/', '-', $start))),date("Y-m-d",strtotime(str_replace('/', '-', $end)))])

                ->where('inv_grn.wareshouse_id','=',$warehouse)

                ->where('inv_grn_detail.product_id','=', $product_id)
                
                /* ->orderBy('products.id', 'DESC') */
                // ->sum('warehouseproduct.quantity_in_hand');
                // return $productList;
                //->distinct()
                // ->get();
        
                ->get();  
                // var_dump( $salesDetail[$i]);
                // exit(); 
        
           // return $saleqty;
        // }
        //return $grnDetails;
        return view('/inventory/productWiseGRN',compact('warehouses','cwarehouse','start','end','grnDetails'));
    }
    public function getStockDetailPdf(Request $request){
        $cat=$request->cat;
        $sub=$request->sub;
        $id=$request->id;
        $product = DB::table('warehouseproduct')
            ->join('products', 'products.id', '=', 'warehouseproduct.product_id')

            ->select('warehouseproduct.*','products.name as pName','products.code as pCode','products.salePrice as price');

            if($cat!='null'&&$sub=='null'){

                $product->where('products.categoryId',  $cat)->where('warehouseproduct.warehouse_id','=',$id);
            }
            elseif($sub!='null'&&$cat=='null'){

                $product->where('products.categoryId',  $sub)->where('warehouseproduct.warehouse_id','=',$id); 
            }

            elseif($sub!='null'&&$cat!='null'){
     
                $product->where('products.categoryId',  $cat)->orWhere('products.categoryId',  $sub)->where('warehouseproduct.warehouse_id','=',$id);
            }

            elseif($sub=='null'&&$cat=='null'){
                $product->where('warehouseproduct.warehouse_id','=',$id);
            }

        $products=$product->get();
        
        if ($products) {
            //  return view('/inventory/stockDetailReportPdf',compact('products'));
            $pdf = PDF::loadView('/inventory/stockDetailReportPdf',compact('products'));
            return $pdf->download('StockDetail.pdf');
         } 
       
    }
}

    