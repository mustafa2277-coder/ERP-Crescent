<?php

namespace App\Http\Controllers\UserManagement;

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
use Auth;
use PDF;

class UserRegistrationController extends Controller
{
    public function __construct()
    {
        
        //$this->middleware('role:inv-manage|admin');
        $this->middleware('auth');    
        $this->middleware('role:admin');
    }
    public function userList (){
       
       //$users=User::join()->where('users.id','<>','3')->get();
       $users=DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.id','<>','3')
                ->select('users.id','users.name','users.email','roles.display_name as role','roles.id as role_id')
                ->get();
        //return $users;
       return view('userManagement/userList')->with('users',$users);

    }
    public function getAddUser(){

       // $role=Role::where('id','<>','1')->get();
        $role=Role::all();
        return view('userManagement/userForm')->with('roles',$role);
    }

    public function getEditUser($userId,$roleId){

        // $role=Role::where('id','<>','1')->get();
        $roles=Role::all();
        $userDetail=DB::table('role_user')
                ->join('users', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->where('users.id','=',$userId)
                ->where('roles.id','=',$roleId)
                ->select('users.id','users.name','users.email','roles.display_name as role','roles.id as role_id')
                ->get();
         //return $userDetail;
         return view('userManagement/userForm',compact('userDetail','roles'));
     }

    public function addUser(Request $request){
        if($request->id){
            if(User::where('email','=',$request->email)->where('id','<>',$request->id) ->exists()){

                $this->validate($request, [
                    
                    'email' => 'unique:users',
                    ]
                );

            }
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'role'=> 'required',
                'password' => 'required|string|min:6|confirmed',
                ]
            );
            $userDel=User::find($request->id);
            $userDel->delete();

            $user= new User;
            $user->id=$request->id;
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=bcrypt($request->password);
            $user->save();   
            $user->attachRole(Role::where('id',$request->role)->first());
            
        }
        else
        {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role'=> 'required',
                'password' => 'required|string|min:6|confirmed',
                ]
            );
            $user= User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => bcrypt($request['password']),
            ]);
            $user->attachRole(Role::where('id',$request->role)->first());
        }
        return redirect('userList');
    }

    public function deleteUser($id){

        $user=User::find($id);
        $user->delete();
        return redirect('userList');
    }
}
