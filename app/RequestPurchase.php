<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestPurchase extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'request_purchase';
    protected $fillable = array(

        'id',
        'rpDate',
        'rpNum',
        'requiredDate',
        'projectId',      
        'status',
        'description',
        'createdBy',
        'updatedBy',
        );
}
