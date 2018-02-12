<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'purchase_order';
    protected $fillable = array(

        'id',
        'poDate',
        'poNum',
        'vendorId',
        'requiredDate',
        'projectId',      
        'status',
        'description',
        'createdBy',
        'updatedBy',
        'isRFQ',
        );
}
