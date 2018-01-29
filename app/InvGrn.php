<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvGrn extends Model
{
    protected $connection = 'mysql';
    protected $primaryKey = 'id';
    protected $table = 'inv_grn';
    protected $fillable = array(

        'id',
        'grn_no',
        'bill_no',
        'vendor_id',
        'project_id',
        'wareshouse_id',
        'grn_date',
        'grn_validatedby',
        'user_created',
        'user_updated',
        );
}
