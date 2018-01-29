<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvWarehouse extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'inv_warehouse';
    protected $fillable = array(

        'id',
        'warehouse_name',
        'warehouse_code',
        'warehouse_address',
        'warehouse_address2',
        'warehouse_cityid',
        'warehouse_stateid',
        'warehouse_countryid',
        'warehouse_ph',
        'warehouse_mobile',
        'user_created',
        'user_updated',
        );
}
