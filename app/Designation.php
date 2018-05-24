<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'designation';
    protected $fillable = array(

        'id',
        'desg',
        
        );
}