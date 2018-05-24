<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'employee_payroll';
    protected $fillable = array(
        
       
        );
}
