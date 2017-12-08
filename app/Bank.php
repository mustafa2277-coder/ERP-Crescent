<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'bank';
    protected $fillable = array(
        'id',
        'name',
        'branchCode',
        'address',
        'email',
        'phone',
        );
}
