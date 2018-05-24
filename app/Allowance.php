<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'allowance';
    protected $fillable = array(
        'id',
        'alwnc'
        
        );
}
