<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestPurchaseDetail extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'request_purchase_detail';
    protected $fillable = array(

        'id',
        'rpId',
        'productId',
        'productQuantity',      
        );
}
