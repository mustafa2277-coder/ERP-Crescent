<?php

namespace App\Http\Controllers;

use DB;
use App\Employee;
use App\Designation;
use App\Department;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    
    public function getDesignation()
    {
       
       
        return view('employee/designation/designationList');
    }

    public function getAddDesignation()
    {
       
       
        return view('employee/designation/designationForm');
    }
}
