<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvGrnDetail extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'inv_grn_detail';
    protected $fillable = array(

        'id',
        'grn_id',
        'product_id',
        'product_quantity',
        'purchased_price',
        'purchased_currency',
        'exchange_rate',
        'price_in_pkr',
        'sale_price',
        'user_created',
        'user_updated',
        );
}
