<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHeadType extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'accountheadtypes';
    protected $fillable = array(
        'id',
        'type',
        );
}
