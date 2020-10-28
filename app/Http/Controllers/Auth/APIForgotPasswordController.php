<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Hash;
class APIForgotPasswordController extends Controller
{
    public function forgot(Request $request)
        {
            return $this->sendResetLinkEmail($request);
        }


    protected function sendResetLinkResponse($response)
        {
            $object=[];
            $object=json_encode($object,JSON_FORCE_OBJECT);   
            return response()->json(['data'=>"Reset password link sent.",'status'=>'success','statuscode'=>'200']);
        }

    
    protected function sendResetLinkFailedResponse(Request $request,$response)
        {
            return response()->json(['data'=>'Failed to send reset link to this email address','status'=>'failed','statuscode'=>'500']);
        }

    protected function doReset(Request $request)
        {
            return $this->reset($request);
        }
    
    protected function resetPassword($user,$password)
        {
            $user->password = Hash::make($password);
            $user->save();
            
            event(new PasswordReset($user));
        }
    
}
