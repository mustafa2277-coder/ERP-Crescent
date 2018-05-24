<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'employee';
    protected $fillable = array(

        'id',
        'name',
        'address',
        'mobile',
        'phone',
        'cnic',
        'pic',
        'dptId',
        'desgId',
        'projId',
        );

}
