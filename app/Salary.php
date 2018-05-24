<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'salary';
    protected $fillable = array(

       
        );
}
