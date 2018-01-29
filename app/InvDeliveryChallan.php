<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvDeliveryChallan extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'inv_delivery_challan';
    protected $fillable = array(

        'id',
        'delivery_challan_no',
        'project_id',
        'warehouse_id',
        'delivery_challan_date',
        'delivery_challan_validatedby',
        'user_created',
        'user_updated',
        );
}
