<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAdvance extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'employee_advance';
    protected $fillable = array(

        'id',
        'empId',
        'advId',
        'monthlyDeduction',
        'numberOfWeek',
        'startMonth',
        'endMonth',
        );
}
