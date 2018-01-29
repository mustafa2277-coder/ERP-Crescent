<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvStockTakingDetail extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'inv_stock_taking_detail';
    protected $fillable = array(

        'id',
        'product_id',
        'quantity_in_stock',
        'actual_quantity',
        'reason_of_diff',
        'user_created',
        'user_updated',
        'stock_taking_id',
        );
}
