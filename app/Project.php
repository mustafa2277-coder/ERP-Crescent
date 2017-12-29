<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'project';
    protected $fillable = array(

        'id',
        'title',
        'debitAccHeadId',
        'creditAccHeadId',      
        'customerId',
        'code',
        'start',
        'end',
        'description',
        'cost',
        );
}
