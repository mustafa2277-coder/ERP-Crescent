<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'productcategories';
    protected $fillable = array(
        'id',
        'name',
        );
}
