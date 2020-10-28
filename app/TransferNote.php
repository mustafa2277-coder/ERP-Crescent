<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferNote extends Model
{
    public $table="transfer_notes";

    protected $fillable=['from_warehouse_id','entry_date','warehouse_name','created_at','updated_at'];
}
