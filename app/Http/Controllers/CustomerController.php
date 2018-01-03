<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Customer;
use App\AccountHead;
use App\Contact;


class CustomerController extends Controller
{
    public function customerList()
    {
        $customerList = Customer::where('isVendor',null)->paginate(6);
        return view('customer/customer_list')->with('customerList',$customerList);
    }
    public function vendorList()
    {
        $customerList = Customer::where('isVendor','on')->paginate(2);
        return view('customer/customer_list')->with('customerList',$customerList);
    }
    
    public function getAddCustomer()
    {
        $accountHeads=AccountHead::all();
        return view('customer/customerForm')->with('accountHeads',$accountHeads);
    }
    public function addCustomer(Request $request)
    {
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
       

        return redirect('customerList');
    }
    public function getEditCustomer($id)
    {
        $accountHeads=AccountHead::all();
        $customer = Customer::where('id','=',$id)->get();
       
        return view('customer/customerForm',compact('accountHeads','customer'));
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
       return redirect('customerList');
        
    }
}
