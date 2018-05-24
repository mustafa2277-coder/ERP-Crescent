<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayrollMonth extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'payroll_month';
    protected $fillable = array(
        
       
        );
}
