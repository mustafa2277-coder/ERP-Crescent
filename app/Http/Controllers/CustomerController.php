<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Customer;
use App\AccountHead;
use App\Contact;


class CustomerController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:inv-manage|admin');
       //$this->middleware('role:admin');
    }
    
    public function customerList()
    {
        $customerList = Customer::where('isVendor',null)->paginate(6);
        $chkVendor='0';
        return view('customer/customer_list',compact('customerList','chkVendor'));
    }
    public function customer_list(Request $request){
        if(isset($request->search)){
            $customerList=DB::table('poscustomers')->select('*')
                        ->where('firstName','LIKE','%'.$request->search.'%')
                        ->orWhere('contactNo','LIKE','%'.$request->search.'%')
                        ->paginate('20');
            return view('customer_ledger/posCustomerList',compact('customerList'));
        }else{
            $customerList=DB::table('poscustomers')->select('*')->paginate('21');
            return view('customer_ledger/posCustomerList',compact('customerList'));
        }
    }
    public function vendorList()
    {
        $customerList = Customer::where('isVendor','on')->paginate(6);
        $chkVendor='1';
        return view('customer/customer_list',compact('customerList','chkVendor'));
    }
    
    public function getAddCustomer($chk)
    {
        $accountHeads=AccountHead::all();
        return view('customer/customerForm',compact('accountHeads','chk'));
    }
    public function addCustomer(Request $request)
    {
        //return $request->isVendor;
        $customer=new Customer;
        $customer->name=$request->name;
        $customer->address1=$request->address1;
        $customer->address2=$request->address2;
        $customer->phone=$request->phone;
        $customer->mobile=$request->mobile;
        
        if($request->isVendor){

            $customer->isVendor=$request->isVendor;
        }
        $customer->save();
        if($request->isVendor){

            return redirect('vendorList');
        }else{
        
            return redirect('customerList');
        }
    }
    public function getEditCustomer($id)
    {
        $accountHeads=AccountHead::all();
        $customer = Customer::where('id','=',$id)->get();
        
        return view('customer/customerForm',compact('accountHeads','customer'));
    }
    public function getCustomerDetail($id){

        $sales = DB::table('sales')

        ->join('poscustomers', 'sales.customerId', '=', 'poscustomers.id')
        
        ->join('user_warehouse', 'user_warehouse.user_id', '=', 'sales.employId')

        ->join('inv_warehouse', 'inv_warehouse.id', '=', 'user_warehouse.warehouse_id')

        ->join('users', 'users.id', '=', 'sales.employId')
        
        ->select( /* 'products.name', */'sales.*','users.name as empName','poscustomers.firstName','poscustomers.lastName','poscustomers.contactNo', 'inv_warehouse.warehouse_name')
        
        ->where('sales.customerId',$id)
        
        ->get();
        //return $sales;
        return view('customer_ledger/customerDetail',compact('sales'));
        
    }
    public function editCustomer(Request $request){
        $isVendor=Null;
        if($request->isVendor){
            
            $isVendor=$request->isVendor;
        }

       Customer::where('id','=',$request->id)->update(['name' => $request->name,
                'debitAccHeadId'=>$request->debit,
                'creditAccHeadId'=>$request->credit,
                'phone' => $request->phone,
                'address1'=>$request->address1,
                'address2'=>$request->address2,
                'mobile'=>$request->mobile,
                'isVendor'=>$isVendor
                ]);
        if($request->isVendor){

            return redirect('vendorList');
        }else{
        
            return redirect('customerList');
        }
       
        
    }
}
