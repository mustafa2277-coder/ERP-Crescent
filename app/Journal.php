<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'journal';
    protected $fillable = array(
        'id',
        'name',
        );
}
