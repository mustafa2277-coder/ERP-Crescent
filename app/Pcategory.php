<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcategory extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'productcategories';
    protected $fillable = array(
        'id',
        'name',
        'pid',
        'leaf'
        );
}
