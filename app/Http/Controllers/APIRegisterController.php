<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use App\Poscustomer;
use DB;
use Hash;
//use Illuminate\Support\Facades\Mail;
//use App\Mail\SendMailable;
use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
class APIRegisterController extends Controller
{
  //  use Notifiable;
  use \Illuminate\Notifications\Notifiable;
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'firstName' => 'required',
            'lastName' => 'required',
            'password'=> 'required|min:8',
            'contactno'=> 'required',
            'address' => 'required'
        ]);
        if ($validator->fails()) {
            //return response()->json(['data'=>$validator->errors(),'status'=>'failed','statuscode'=>'500']);
            $object=[];
            $object=json_encode($object,JSON_FORCE_OBJECT);
            return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
        }
        /*
        Poscustomer::create([
            'firstName' => $request->get('firstName'),
            'lastName' => $request->get('lastName'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'contactNo' => $request->get('contactno')
        ]);
        */
        try
        {
            if(DB::table('poscustomers')->where('poscustomers.email','=',$request->email)->exists())
                {
                    /*
                    $object=[];
                    $object=json_encode($object,JSON_FORCE_OBJECT);
                    return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);
                    */

                    //return response()->json(['data'=>'User Already Exists','status'=>'failed','statuscode'=>'500']);
                    $object=[];
                    $object=json_encode($object,JSON_FORCE_OBJECT);
                    return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);            
                }

            //dd($request->firstName . " " . $request->lastName . " " . $request->email . " " . $request->contactno . " " . $request->password . " " . $request->address);
        
            else
                {
                    DB::table('poscustomers')->insert(
                        ['firstName' => $request->firstName, 'lastName' => $request->lastName, 'email' => $request->email , 'contactNo' => $request->contactno , 'password' => Hash::make($request->password),'address' => $request->address,'created_at' => \Carbon\Carbon::now(),'updated_at' => \Carbon\Carbon::now()]
                    );
        
                    //$user = Poscustomer::first();
                    $user=DB::table('poscustomers')
                    ->select('poscustomers.*')
                    ->latest()->first();
   
                    //dd($user);
                    $token = JWTAuth::fromUser($user);
                    $object=["token" => $token];
                    $object=json_encode($object,JSON_FORCE_OBJECT);
                    return Response::json([/*'data'=>compact('token'),*/'data'=>[json_decode($object)],'status'=>'success','statuscode'=>'200']);
            
                }
        }
        
        catch(\Exception $e)
            {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
            }
    }

    public function ForgotPassword(Request $request)
    {
        
        \Config::set('auth.providers.users.model', \App\Poscustomer::class);
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password'=> 'required|min:8',
        ]);
        if ($validator->fails()) {
            //return response()->json(['data'=>$validator->errors(),'status'=>'failed','statuscode'=>'500']);
            $object=[];
            $object=json_encode($object,JSON_FORCE_OBJECT);
            return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);            
                
        }
        
        
        
        try
           {
                        
                if(DB::table('poscustomers')->where('poscustomers.email','=',$request->email)->exists())
                {
                    //echo "We are inside condition!";

                    
                    DB::table('poscustomers')->where('poscustomers.email','=',$request->email)
                    ->update(
                    ['password' => Hash::make($request->password),'rand_password'=>'1']
                    );
                    /*
                    $user=DB::table('poscustomers')
                   // ->select('poscustomers.*')
                    ->where('poscustomers.email','=',$request->email)->first();
                    */
                    
                    $user=Poscustomer::where('poscustomers.email','=',$request->email)->first();
                    //dd($user);
                    $token = JWTAuth::fromUser($user);
                    
                    $password=$request->password;
                    /*
                    foreach($user as $value)
                        {
                            $password=$value->password;
                        }
                    */
                    //dd($password);
                   // Mail::to($request->email)->send(new SendMailable($password));
                   //$user->notify(new ResetPassword($password));
                   \Notification::send($user, new ResetPassword($password));
                   $object=["token" => $token];
                   $object=json_encode($object,JSON_FORCE_OBJECT);
                    

                    return response()->json(['data'=>[json_decode($object)],'status'=>'success','statuscode'=>'200']);
                }
                else
                {
                   // return response()->json(['data'=>'No User Found!.','status'=>'failed','statuscode'=>'500']);
                   $object=[];
                   $object=json_encode($object,JSON_FORCE_OBJECT);
                   return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'500']);            
                      
                }
            
            }

        catch(\Exception $e)
              {
                return response()->json(['data'=>[],'status'=>'failed','statuscode'=>'500']);
              }

    }

    /*
    public function toMail($notifiable)
        {
            $url = url('/invoice/'.$this->invoice->id);

            return (new MailMessage)
                ->greeting('Hi There!')
                ->line('Your Password has been reset!');
                //->action('View Invoice', $url)
                //->line('Thank you for using our application!');
        }
    */

}
