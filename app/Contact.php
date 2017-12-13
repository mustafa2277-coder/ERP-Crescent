<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'contactaddress';
    protected $fillable = array(

        'id',
        'address1',
        'address2',
        'mobile',
        'phone',
        'customerId'
        );
}
