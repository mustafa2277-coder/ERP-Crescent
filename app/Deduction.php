<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'deduction';
    protected $fillable = array(
        'id',
        'deduct'
        
        );
}
