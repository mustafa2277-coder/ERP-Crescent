<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTFactory;
use JWTAuth;
use App\User;
use App\Poscustomer;
use Illuminate\Support\Facades\Auth;
use Hash;
use DB;
//use App\Http\Controllers\BaseAPIController\Controller;

class APILoginController extends Controller
{
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
           // return response()->json($validator->errors());
           $object=[];
           $object=json_encode($object,JSON_FORCE_OBJECT);   
           return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
       
        }
        //\Config::get('auth.providers.poscustomers.model');
        
        \Config::set('auth.providers.users.model', \App\Poscustomer::class);
        $credentials = $request->only('email', 'password');
        try 
        {    
            if (! $token = JWTAuth::attempt($credentials)) 
            {
               // return response()->json(['data' => 'invalid_credentials','status'=>'failed','statuscode'=>'500']);
                  
               $object=[];
               $object=json_encode($object,JSON_FORCE_OBJECT);   
               return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
            }

            //dd($request->email . " " . $request->password);
            $userdata=DB::table('poscustomers')
                                ->select('poscustomers.*')
                                ->where('poscustomers.email','=',$request->email)
                                //->where('poscustomers.password','=',Hash::make($request->password))
                                ->get();
            //dd($userdata);
                    foreach($userdata as $record)
                        {
                            if($record->contactNo==null)
                                {
                                    $record->contactNo="";
                                }
                                
                            if($record->token==null)
                                {
                                    $record->token=$token;
                                }
                            else
                                {
                                    $record->token=$token;
                                }    
                            
                            if($record->address==null)
                                {
                                    $record->address="";
                                }
                        }
                    
                        
                    DB::table('poscustomers')->where('poscustomers.email','=',$request->email)
                    ->update(
                    ['token' => $token]
                    );
                    
            return response()->json([/*'token'=>compact('token'),*/'data'=>$userdata,'status'=>'success','statuscode'=>'200']);
        } 
            catch (JWTException $e) 
            {
                //return response()->json(['data' => 'could_not_create_token','status'=>'failed','statuscode'=>'500']);
                $object=[];
                $object=json_encode($object,JSON_FORCE_OBJECT);   
                return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);              
            
            }

            
            catch (\Exception $e) 
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }

    
    }
}
