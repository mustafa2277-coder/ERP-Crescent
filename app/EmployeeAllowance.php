<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAllowance extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'employee_allowance';
    protected $fillable = array(
        
       
        );
}
