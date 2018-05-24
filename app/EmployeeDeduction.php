<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeDeduction extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'employee_deduction';
    protected $fillable = array(
        
       
        );
}
