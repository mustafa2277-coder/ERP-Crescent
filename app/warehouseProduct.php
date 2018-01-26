<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class warehouseProduct extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'warehouseProduct';
    protected $fillable = array(
        'id',
        'warehouse_id',
        'product_id',
        'quantity_in_hand',
        
        );
}
