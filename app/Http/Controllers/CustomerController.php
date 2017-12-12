<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customerList()
    {
        return view('customer/customer_list');
    }
    
    public function getAddCustomer()
    {
        return view('customer/customerForm');
    }
}
