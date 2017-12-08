<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHead extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'accounthead';
    protected $fillable = array(
        'id',
        'name',
        'parentId',
        'code',
        'isTransactional',
        );
}
