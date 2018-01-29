<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvDcDetail extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'inv_dc_detail';
    protected $fillable = array(

        'id',
        'delivery_challan_id',
        'product_id',
        'product_quantity',
        'user_created',
        'user_updated',
        );
}
