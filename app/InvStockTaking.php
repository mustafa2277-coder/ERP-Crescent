<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvStockTaking extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'inv_stock_taking';
    protected $fillable = array(

        'id',
        'stock_date',
        'warehouse_id',
        'user_created',
        'user_updated',
        );
}
