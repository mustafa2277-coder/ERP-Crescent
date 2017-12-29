<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'units';
    protected $fillable = array(

        'id',
        'name',
        
        );
}
