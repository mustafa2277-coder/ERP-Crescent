<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Pcategory;
use App\Journal;
use App\JournalEntries;
use App\JournalEntryDetail;
use Response;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('role:inv-manage|admin');
       //$this->middleware('role:admin');
    } 
    public function categoryList()
    {
        /* $customer=Customer::all(); */
        $arr=null;
        $categoryHead=Pcategory::where('pid',null)->get();

        foreach($categoryHead as $head){

            $addNew = '<a   style="float: right; " id="addew" href="'. URL('/getAddSubCategory').'/'.$head->id.'"> <i class="material-icons"  title="Add Sub Head">add_circle_outline</i></a>';    
            
            $edit = '<a  style="float: right; " href="'.URL('/getEditCategory').'/'.$head->id.'"><i class="material-icons" title="Edit Head">mode_edit</i></a>';

            $arr.='<li class="dd-item" data-id="'.$head->id.'"><div class="dd-handle">'.$head->name.$addNew.$edit.'  </div>'.$this->GetTreeCategory($head).'</li>';
        }
        return view('productCategory/category')->with('arr',$arr);
    }
    public function GetTreeCategory($parent)
    {
        $arr=null;

        $categories=Pcategory::where('pid',$parent->id)->get();
        if(count($categories)>0){
            foreach($categories as $category){
                $addNew = '<a style="float:  right;" id="addew" href="'. URL('/getAddSubCategory').'/'.$category->id.'"> <i class="material-icons"   title="Add Sub Head">add_circle_outline</i></a>';    
                
                $edit = '<a style="float:  right;" href="'.URL('/getEditCategory').'/'.$category->id.'"><i class="material-icons" title="Edit Head">mode_edit</i></a>';    
                        
                $arr .= '<ol class="dd-list"><li class="dd-item" data-id="'.$category->id.'"><div class="dd-handle">'.$category->name.$edit.'</div>'.$this->GetTreeCategory($category).'</li></ol>';
            }
            return $arr;
        }
    }
    public function getAddSubCategory($id)
    {
       $category=Pcategory::find($id);
       /* $category->name=$request->name;
       $category->save(); */
       
       return view('productCategory/categoryForm')->with('categories',$category);
        
    }
    public function getEditCategory($id)
    {
       $category=Pcategory::find($id);
       /* $category->name=$request->name;
       $category->save(); */
    
       return view('productCategory/categoryForm')->with('editCategories',$category);
        
    }
    public function getAddCategory()
    {
        /* $customer=Customer::all(); */

        return view('productCategory/categoryForm')/* ->with('customers',$customer) */;
    }
    public function editCategory(Request $request)
    {
        $category=Pcategory::find($request->id);
        $category->name=$request->cat;
        $category->save();

        return redirect('categoryList');
        
    }
    public function addCategory(Request $request)
    {
        
        if($request->pid)
        {
            $category=new Pcategory;
            $category->name=$request->sub;
            $category->pid=$request->pid;
            $category->save();
        }
        else
        {
            $category=new Pcategory;
            $category->name=$request->name;
            $category->save();
        }   
       return redirect('categoryList');
        
    }
}
