<?php

namespace App\Http\Middleware;

use App\Poscustomer;
use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Middleware\GetUserFromToken;
use App\User;
class PoscustomerTokenAuthenticate extends GetUserFromToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            \Config::set('auth.providers.users.model', \App\Poscustomer::class);
            $token_body = (JWTAuth::parseToken()->getPayload());
        } catch (JWTException $e) {
            //return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
            $object=[];
            $object=json_encode($object,JSON_FORCE_OBJECT);   
            return response()->json(['data'=>[json_decode($object)],'status'=>'failed','statuscode'=>'400']);
        
        }

        /*        
        if ($token_body->get('auth_model') != Poscustomer::class) {
            return $this->respond('tymon.jwt.invalid', 'token_type_invalid', 500);
        }
        */
        
        /*
        config(['auth.model' => Employee::class]);
        config(['auth.table' => 'employee']);
        config(['jwt.user' => Employee::class]);
        */
        return parent::handle($request, $next);
    }
}