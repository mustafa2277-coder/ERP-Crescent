<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'partner';
    protected $fillable = array(

        'id',
        'name',
        );
}
