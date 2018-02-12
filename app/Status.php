<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'status';
    protected $fillable = array(

        'id',
        'name',
        );
}
