<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'customers';
    protected $fillable = array(

        'id',
        'name',
        'debitAccHeadId',
        'creditAccHeadId',
        'address1',
        'address2',
        'mobile',
        'phone',
        );
}
