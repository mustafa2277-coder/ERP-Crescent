<?php

namespace App;

//use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
//use \Illuminate\Notifications\Notifiable;

class Poscustomer extends Model implements Authenticatable
{
  //  use Notifiable;
    use \Illuminate\Notifications\Notifiable;
    use AuthenticableTrait;
    protected $guard='poscustomer';
    protected $primaryKey = 'id';
    
    protected $fillable=['email','firstName','lastName','password'];

    protected $table = 'poscustomers';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    /*
    public function routeNotificationForMail()
        {
            return $this->email;
        }
    */
}
