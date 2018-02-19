<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RpStatus extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'rp_status';
    protected $fillable = array(

        'id',
        'name',
        );
}
