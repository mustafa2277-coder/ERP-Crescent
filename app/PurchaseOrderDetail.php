<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'purchase_order_detail';
    protected $fillable = array(

        'id',
        'poId',
        'productId',
        'productQuantity',      
        
        'unitPrice',
        'tax',
        'subTotal',
        );
}
