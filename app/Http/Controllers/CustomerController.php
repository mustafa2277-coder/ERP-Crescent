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
        $customerList = DB::table('customers as cat1')
        
        ->join('contactaddress as cat2', 'cat2.customerId', '=', 'cat1.id')
        
        ->select( 'cat1.*','cat1.id as custId','cat2.*')
        
        ->paginate(1);
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
        $customer->debitAccHeadId=$request->debit;
        $customer->creditAccHeadId=$request->credit;
        $customer->save();
        $contact=new Contact;
        $contact->customerId=$customer->id;
        $contact->address1=$request->address1;
        $contact->address2=$request->address2;
        $contact->phone=$request->phone;
        $contact->mobile=$request->mobile;
        $contact->save();

        return redirect('customerList');
    }
    public function getEditCustomer($id)
    {
        $accountHeads=AccountHead::all();
        $customer = DB::table('customers as cat1')
        
        ->join('contactaddress as cat2', 'cat2.customerId', '=', 'cat1.id')
        
        ->select( 'cat1.*','cat1.id as custId','cat2.*')

        ->where('cat1.id','=',$id)
        
        ->get();
       
        return view('customer/customerForm',compact('accountHeads','customer'));
    }
    public function editCustomer(Request $request){

       Customer::where('id','=',$request->id)->update(['name' => $request->name,'debitAccHeadId'=>$request->debit,'creditAccHeadId'=>$request->credit]);
       Contact::where('customerId','=',$request->id)->update(['phone' => $request->phone,'address1'=>$request->address1,'address2'=>$request->address2,'mobile'=>$request->mobile ]);
       return redirect('customerList');
        
    }
}
