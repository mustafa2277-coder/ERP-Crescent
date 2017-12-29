<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'products';
    protected $fillable = array(

        'id',
        'name',
        'code',
        'categoryId',
        'description',
        'purchasePrice',
        'salePrice',
        'type', 
        'manfLeadTime',
        'custLeadTime',
        'weight',
        'volume',
        'unitId', 

        );
}
